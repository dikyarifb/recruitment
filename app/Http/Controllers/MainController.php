<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteEmployeeRequestStructure as Job;
use App\Models\Recruitment;
use App\Models\RecruitmentTest as Test;
use App\Models\Role;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    
    public function index(Request $request){
        $data['jobs'] = Job::available()->select(
            'position',
            DB::raw('MIN(created_at) as created_at'),
            DB::raw('COUNT(*) as total'
        ))->groupBy('position')->get()->filter(function($filter){
            $filter->applied = Recruitment::where('position', $filter->position)->where('created_at', '<', $filter->created_at)->count();
            return $filter;
        });
        // return $data;
        // $data['position'] = 'Cleaning Associate';
        // session()->forget('quiz_started');
        // session()->forget('quiz_disc_started');
        // $request->session()->forget('quiz_started');
        return view('welcome', $data);
    }
    public function login(Request $request){
        // $data['jobs'] = Job::available()->select('position',  DB::raw('COUNT(*) as total'))->groupBy('position')->get();
        // return $data;
        // $data['position'] = 'Cleaning Associate';
        // session()->forget('quiz_started');
        // session()->forget('quiz_disc_started');
        // $request->session()->forget('quiz_started');
        return view('login');
    }
    public function login_post(Request $request)
{
    // validate
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // attempt login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/employee/test/iq'); // change to your dashboard
    }

    // failed
    return back()->withErrors([
        'email' => 'Email or password is incorrect',
    ])->withInput();
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
            'cv' => 'required|mimes:pdf|max:1024',
        ];

        $this->validate($request, $rules);
        // --check existing
        $exist = Recruitment::where('nik', $request->nik)->where('date_applied', date('Y-m-d'))->where('position', $request->position)->first();
        if($exist){
            return back()->withErrors(
                [
                    'nik' => 'tidak bisa melamar lebih dari 1 kali dihari yang sama untuk posisi yang sama, silahkan coba kembali besok'
                ]
            )->withInput();
        }
        // --store
        $res = new Recruitment;
        $res->name = $request->name;
        $res->email = $request->email;
        $res->nik = $request->nik;
        $res->phone = $request->phone;
        $res->experience_position = $request->experience_position;
        $res->experience_time = $request->experience_time;
        $res->education = $request->education;
        $res->position = $request->position;
        $res->gender = $request->gender ?? '-';
        $res->heigth = $request->heigth ?? 0;
        $res->weight = $request->weight ?? 0;
        $res->region = $request->region ?? 'metro';
        $res->date_applied = date('Y-m-d');
        $res->introduction = $request->name ?? NULL;

        $res->cv = $this->store_file($request->file('cv'), 'recruitment/cv');
        $res->save();
        // cv
        // check role level
        $level = 0;
        $role = Role::where('name', $res->position)->first();
        if($role){
            $level = $role->level;
        }
        if($res->position == 'other'){
            $level = 1;
        }
        $data['with_disc'] = $level > 0 ? 1 : 0;
        $data['datas'] = Test::where('type', 'iq')->get();
        $data['id'] = $res->id;
        $data['is_employee'] = 0;
        return view('iq', $data)->with('message', '🎉 Lamaran berhasil dikirim! Silahkan isi pertanyaan singkat dibawah ini.');
        // navigate to quiz
        // return back()
    }
    public function store_iq(Request $request){
        // return $request->all();
        $score = 0;
        $quiz_count = Test::where('type', 'iq')->count();
        $final_score = 0;
        $arrays =[];
        // if($quiz_count > 0){
            foreach ($request->all() as $key => $answer) {
                array_push($arrays, $key);
                if(str_contains($key, "quiz-")){
                    $number = (int) str_replace('quiz-', '', $key);
                    if(Test::find($number)->answer === $answer){
                        $score++;
                    }
                }
            }
            if($quiz_count > 0){
                $final_score = ($score/$quiz_count) * 100;
            }
            
        // }
        if($request->is_employee == 1){
            $user = Auth::user();

            $check = Recruitment::where('nik', $user->NIK)->where('is_employee', 1)->first();
            if($check){
                return abort(404);
            }
            $candidat = new Recruitment;
            $candidat->is_employee = 1;
            $candidat->nik = $user->NIK;
            $candidat->name = $user->name;
            $candidat->email = $user->email;
            $candidat->date_applied = date('Y-m-d');
        }else{
            $candidat = Recruitment::find($request->lazawami);
        }
        $candidat->iq_score = $final_score ?? 0;
        $candidat->save();

        if($request->with_disc == "0"){
            // session()->forget('quiz_started');
            return redirect('/')->with('message', '🎉 Lamaran berhasil dikirim! Kami akan segera meninjau dan menghubungi Anda jika lolos tahap berikutnya.');
        }else{
            $data['datas'] = Test::where('type', 'disc')->get();
            $data['id'] = $candidat->id;
            return view('disc', $data);      // return redirect('/')->with('message', '🎉 Lamaran berhasil dikirim! Kami akan segera meninjau dan menghubungi Anda jika lolos tahap berikutnya.');
        }
    }
    public function store_disc(Request $request){

        $d=0;
        $i=0;
        $s=0;
        $c=0;

       foreach ($request->all() as $key => $answer) {
            if (str_contains($key, "quiz-")) {
                switch ($answer) {
                    case 'a': $d++; break;
                    case 'b': $i++; break;
                    case 'c': $s++; break;
                    case 'd': $c++; break;
                }
            }
        }

        $scores = [
            'D' => $d,
            'I' => $i,
            'S' => $s,
            'C' => $c,
        ];
        arsort($scores); // urut dari terbesar
        $types = array_keys($scores);

        $primary = $types[0];
        $secondary = $types[1];
        if ($scores[$primary] == $scores[$secondary]) {
            $result = $primary . '/' . $secondary; // contoh: D/I
        } else {
            $result = $primary;
        }
        if (($scores[$primary] - $scores[$secondary]) <= 1) {
            $result = $primary . '/' . $secondary;
        }
        $descriptions = [
            'D' => 'Dominance: Tegas, cepat mengambil keputusan, fokus pada hasil dan tantangan.',
            'I' => 'Influence: Komunikatif, persuasif, energik, dan mudah bergaul.',
            'S' => 'Steadiness: Sabar, stabil, loyal, dan suka membantu orang lain.',
            'C' => 'Conscientiousness: Teliti, analitis, perfeksionis, dan berorientasi pada detail.',

            'D/I' => 'Dominance-Influence: Leader yang agresif, komunikatif, dan mampu mempengaruhi orang lain.',
            'D/S' => 'Dominance-Steadiness: Tegas namun tetap stabil dan suportif.',
            'D/C' => 'Dominance-Conscientiousness: Fokus hasil dengan pendekatan analitis.',

            'I/S' => 'Influence-Steadiness: Ramah, sabar, dan mudah bekerja dalam tim.',
            'I/C' => 'Influence-Conscientiousness: Komunikatif tapi tetap teliti dan terstruktur.',

            'S/C' => 'Steadiness-Conscientiousness: Stabil, teliti, dan sangat dapat diandalkan.',
        ];
        $output = [
            'scores' => $scores,
            'result' => $result,
            'description' => $descriptions[$result] ?? $descriptions[$primary],
        ];

        $candidat = Recruitment::find($request->lazawami);
        $candidat->disc_score = $result;
        $candidat->disc_desc = $descriptions[$result] ?? $descriptions[$primary];
        $candidat->d = $d;
        $candidat->i = $i;
        $candidat->s = $s;
        $candidat->c = $c;
        $candidat->save();

        // session()->forget('quiz_started');
        // session()->forget('quiz_disc_started');
        $message = $candidat->is_employee ? 'Record saved' : '🎉 Lamaran berhasil dikirim! Kami akan segera meninjau dan menghubungi Anda jika lolos tahap berikutnya.'; 
        return redirect('/')->with('message', $message);
       
    }
    public function employee_iq_form(){
        $data['with_disc'] = 1;
        $data['datas'] = Test::where('type', 'iq')->get();
        $data['id'] = Auth::id();
        $data['is_employee'] = 1;
        return view('iq', $data);
    }
}
