@extends('template.master')
@section('script')
@endsection
@section('content')
<div class="section">
  <div class="container">
     @component('components.card',['title' => 'Test Results'])
            <p class="text-dark mb-4 text-center">
                Berikut adalah hasil <strong>ARSA Initiative Assessment</strong> yang mengukur kecenderungan perilaku inisiatif dalam lingkungan kerja. Penilaian ini mencakup enam kompetensi utama, yaitu <strong>Courage to Ask</strong>, <strong>Problem Awareness</strong>, <strong>Decision Making</strong>, <strong>Taking Action</strong>, <strong>Accountability</strong>, dan <strong>Continuous Improvement</strong>. Hasil ini memberikan gambaran mengenai kekuatan serta area pengembangan peserta dalam mengambil inisiatif, menyelesaikan permasalahan, dan menciptakan perbaikan berkelanjutan di tempat kerja.
            </p>
            <strong> Courage to ASK, <small>{{$user->recruitment->initiative_one_score}}</small></strong><hr> 
            <strong> Problem Awareness, <small>{{$user->recruitment->initiative_two_score}}</small></strong><hr> 
            <strong> Decision Making, <small>{{$user->recruitment->initiative_three_score}}</small></strong><hr> 
            <strong> Taking Action, <small>{{$user->recruitment->initiative_four_score}}</small></strong><hr> 
            <strong> Accountability, <small>{{$user->recruitment->initiative_five_score}}</small></strong><hr> 
            <strong> Continuous Improvement, <small>{{$user->recruitment->initiative_six_score}}</small></strong><hr> 
            <center>
                <strong>{{$result_title}}</strong>
                <p class="text-muted">{{$result_subtitle}}</p>
            </center>
    @endcomponent
  </div>
</div>
@endsection