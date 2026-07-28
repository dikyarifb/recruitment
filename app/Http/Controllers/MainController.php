<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteEmployeeRequestStructure as Job;
use App\Models\Recruitment;
use App\Models\RecruitmentTest as Test;
use App\Models\Role;
use App\Models\User;
use App\Models\Scheduler;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\Applicant as MailApplicant;

class MainController extends Controller
{
    
    public function index(Request $request){
        // $data['applicant'] = Recruitment::find(22);
        // return view('email.new-applicant', $data);
        $data['jobs'] = Job::available()->select(
            'position',
            DB::raw('MIN(created_at) as created_at'),
            // DB::raw('MAX(site_employee_request.effective_date) as effective_date'),
            DB::raw('COUNT(*) as total'
        ))->groupBy('position')->get()->filter(function($filter){
            $filter->applied = Recruitment::where('position', $filter->position)
                                                ->where('created_at', '>', $filter->created_at)
                                                // ->where('created_at', '<', $filter->created_at)
                                                ->count();
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
        $res->introduction = $request->introduction ?? NULL;

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
        $data['datas'] = Test::where('type', 'iq')->where('level', 'associate')->get();
        $data['id'] = $res->id;
        $data['is_employee'] = 0;
        return view('iq', $data)->with('message', '🎉 Lamaran berhasil dikirim! Silahkan isi pertanyaan singkat dibawah ini.');
        // navigate to quiz
        // return back()
    }
    public function store_iq(Request $request){
        // return $request->all();
        $score = 0;
        $final_score = 0;
        $level = 'associate';
        $arrays =[];
        // if($quiz_count > 0){
        foreach ($request->all() as $key => $answer) {
            array_push($arrays, $key);
            if(str_contains($key, "quiz-")){
                $number = (int) str_replace('quiz-', '', $key);
                $level = Test::find($number)->level;
                if(Test::find($number)->answer === $answer){
                    $score++;
                }
            }
        }

        $quiz_count = Test::where('type', 'iq')->where('level', $level)->count();
        if($quiz_count > 0){
            $final_score = ($score/$quiz_count) * 100;
        }
            
        // }
        if($request->is_employee == 1){
            $user = Auth::user();
            $check = Recruitment::where('nik', $user->NIK)->where('is_employee', 1)->first();
            if($check){
                $candidat = $check;
            }else{
                $candidat = new Recruitment;
                $candidat->is_employee = 1;
                $candidat->nik = $user->NIK;
                $candidat->name = $user->name;
                $candidat->email = $user->email;
                $candidat->date_applied = date('Y-m-d');
            }
            switch ($level) {
                case 'associate':
                    $candidat->iq_score = $final_score ?? 1;
                    break;
                case 'supervisor':
                    $candidat->iq_supervisor_score = $final_score ?? 1;
                    break;
                case 'manager':
                    $candidat->iq_manager_score = $final_score ?? 1;
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            $candidat = Recruitment::find($request->lazawami);
            $candidat->iq_score = $final_score ?? 0;
        }
        $candidat->save();

        if($request->with_disc == "0"){
            // session()->forget('quiz_started');
            $this->mail_applicant_to_hr($candidat);
            $message = '🎉 Lamaran berhasil dikirim! Kami akan segera meninjau dan menghubungi Anda jika lolos tahap berikutnya.';
            if($request->is_employee == 1){
                $message = 'Thank you for your time';
            }
            return redirect('/')->with('message', $message);
        }else{
            if($request->is_employee == 1){
                if($candidat->disc_score){
                    return redirect('/')->with('message', 'Thank you for your time');
                }
            }
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
        if(!$candidat->is_employee){
            $this->mail_applicant_to_hr($candidat);
        }
        return redirect('/')->with('message', $message);
       
    }
    public function employee_iq_form(){
        $level = 'associate';
        $with_disc = 1;
        $participant = Recruitment::where('nik', Auth::user()->NIK)->first();
        $user = Auth::user();
        if($participant){
            if($participant->iq_score){
                $level = 'supervisor';
                $with_disc = 0;
            }
            if($participant->iq_supervisor_score){
                $level = 'manager';
                $with_disc = 0;
            }
            if($participant->iq_manager_score){
                return redirect('/')->with('message', 'Kamu sudah pernah menjalani test ini');
            }
        }else{
            $participant = new Recruitment;
            $participant->is_employee = 1;
            $participant->nik = $user->NIK;
            $participant->name = $user->name;
            $participant->email = $user->email;
            $participant->date_applied = date('Y-m-d');
        }
        switch ($level) {
            case 'supervisor':
                $participant->iq_supervisor_score = 1;
                break;
            case 'manager':
                $participant->iq_manager_score = 1;
                break;
            default:
                $participant->iq_score = 1;
                break;
        }
        $participant->save();
        $data['with_disc'] = $with_disc;
        $data['level'] = $level;
        $data['datas'] = Test::where('type', 'iq')->where('level',$level)->get();
        $data['id'] = Auth::id();
        $data['is_employee'] = 1;
        $data['title'] = 'Logic '.ucfirst($level).' Level';
        $data['time'] = $level == 'associate' ? 7 : 15;

        return view('iq', $data);
    }
    private function mail_applicant_to_hr($data){
        // later use scheduler
        $scheduler = new Scheduler;
        $scheduler->type = 'mail_applicant';
        $scheduler->sub_type = $data->id;
        $scheduler->hidden = 1;
        $scheduler->time = date("Y-m-d H:i:00", strtotime("+2 minutes"));
        $scheduler->status = 1;
        $scheduler->user_id = 33;
        $scheduler->save();

        // $e['applicant'] = $data;
        // \Mail::to('recruitment@arsaindonesia.co.id')->cc('arsatech.notification@arsaindonesia.co.id')->send(new MailApplicant(
        //     $e
        // ));
    }
    public function employee_iniciative_form(){
        $participant = Recruitment::where('nik', Auth::user()->NIK)->first();
        $part = 1;
        if($participant){
            if ($participant->initiative_one_score !== null) {
                $part = 2;
            }

            if ($participant->initiative_two_score !== null) {
                $part = 3;
            }

            if ($participant->initiative_three_score !== null) {
                $part = 4;
            }

            if ($participant->initiative_four_score !== null) {
                $part = 5;
            }
            if ($participant->initiative_five_score !== null) {
                $part = 6;
            }
            // Optional: if all parts are completed
            if ($participant->initiative_six_score !== null) {
                return redirect()->back()->with('success', 'You have completed all initiative assessments.');
            }
        }else{
            $user = Auth::user();
            $participant = new Recruitment;
            $participant->is_employee = 1;
            $participant->nik = $user->NIK;
            $participant->name = $user->name;
            $participant->email = $user->email;
            $participant->date_applied = date('Y-m-d');
            $participant->save();
        }
        $data['part'] = $part;
        $data['title'] = 'ARSA Initiative Assessment';
        $data['time'] = 15;
        $data['id'] = $participant->id;
        $data['is_employee'] = 1;
        $data['datas'] = Test::where('type', 'initiative')->where('level', 'initiative')->where('part', $part)->get();
        return view('initiative', $data);
    }
    public function initiative_next(Request $request){
        // dd($request->all());
        $score = 0;
        $finish = 0;
        $final_score = 0;
        $level = 'initiative';
        $arrays =[];
        // if($quiz_count > 0){
        foreach ($request->all() as $key => $answer) {
            array_push($arrays, $key);
            if(str_contains($key, "quiz-")){
                $number = (int) str_replace('quiz-', '', $key);
                $level = Test::find($number)->level;
                if(Test::find($number)->answer === $answer){
                    $score++;
                }
            }
        }
        $quiz_count = Test::where('type', 'initiative')->where('part', $request->part)->count();
        if($quiz_count > 0){
            $final_score = ($score/$quiz_count) * 100;
        }
        $res = Recruitment::find($request->lazawami);
        switch ($request->part) {
            case '1':
                $res->initiative_one_score = $final_score;
                break;
            case '2':
                $res->initiative_two_score = $final_score;
                break;
            case '3':
                $res->initiative_three_score = $final_score;
                break;
            case '4':
                $res->initiative_four_score = $final_score;
                break;
            case '5':
                $res->initiative_five_score = $final_score;
                break;
            case '6':
                $finish = 1;
                $res->initiative_six_score = $final_score;
                $res->initiative_score = ($res->initiative_one_score+$res->initiative_two_score+$res->initiative_three_score+$res->initiative_four_score+$res->initiative_five_score+$res->initiative_six_score)/6;
                break;
        }
        $res->save();
        if($finish){
            return redirect('/')->with('message', 'Thank you for your time!');
        }else{
            return redirect('/employee/test/initiative');
        }
    }
}
