<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteEmployeeRequestStructure as Job;
use App\Models\Recruitment;
use DB;

class MainController extends Controller
{
    
    public function index(Request $request){
        $data['jobs'] = Job::available()->select('position',  DB::raw('COUNT(*) as total'))->groupBy('position')->get();
        // return $data;
        // $data['name'] = 'Rudi';
        // $data['position'] = 'Cleaning Associate';
        return view('welcome', $data);
    }
    public function store(Request $request){
        // return $request->all();
        // return back()->withErrors(
        //     [
        //         'nik' => 'NIK sudah pernah melamar pada posisi dan tanggal yang sama'
        //     ]
        // )->withInput();
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'phone' => 'required',
            'experience_position' => 'required',
            'experience_time' => 'required',
            'education' => 'required',
            'position' => 'required',
            'introduction' => 'required',
            'cv' => 'required|mimes:pdf|max:2048',
        ];

        $this->validate($request, $rules);
        $exist = Recruitment::where('nik', $request->nik)->where('date_applied', date('Y-m-d'))->where('position', $request->position)->first();
        if($exist){
            return back()->withErrors(
                [
                    'nik' => 'tidak bisa melamar lebih dari 1 kali dihari yang sama untuk posisi yang sama, silahkan coba kembali besok'
                ]
            )->withInput();
        }
        // store
        $res = new Recruitment;
        $res->name = $request->name;
        $res->email = $request->email;
        $res->nik = $request->nik;
        $res->phone = $request->phone;
        $res->experience_position = $request->experience_position;
        $res->experience_time = $request->experience_time;
        $res->education = $request->education;
        $res->position = $request->position;
        $res->date_applied = date('Y-m-d');
        $res->introduction = $request->name ?? NULL;

        $res->cv = $this->store_file($request->file('cv'), 'recruitment/cv');
        $res->save();
        // cv
        return back()->with('message', '🎉 Lamaran berhasil dikirim! Kami akan segera meninjau dan menghubungi Anda jika lolos tahap berikutnya.');
    }
}
