@extends('template.master')
@section('script')
<script>
history.pushState(null, null, location.href);

window.onpopstate = function () {
    window.location.replace("/");
};
if (performance.getEntriesByType('navigation')[0].type === 'reload') {
    // Redirect to your home page
    window.location.href = '/'; 
}
</script>
@endsection
@section('content')
</script>
</script>
    <div class="section">
  <div class="container">
    <div class="glass p-4">

      <h3 class="mb-4 text-center">🧠 ({{$part}} / 6) {{$title ?? ''}} - {{$time ?? 7}} menit</h3>
        <div class="text-center mb-3">
            <h5>
                ⏱ Time Left: <span id="timer">07:00</span>
            </h5>
        </div>
      <form action="/employee/test/initiative" method="POST" id="form">
        @csrf
        <input type="hidden" name="lazawami" value="{{$id}}">
        <input type="hidden" name="part" value="{{$part}}">
        <input type="hidden" name="is_employee" value="{{$is_employee}}">
        @foreach ($datas as $key => $item)
             <div class="mb-4">
                <p><strong>{{$key+1}}. {{$item->question}}</strong></p>

                
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="quiz-{{$item->id}}" value="a" id="quiz-a-{{$item->id}}">
                    <label class="form-check-label" for="quiz-a-{{$item->id}}">{{$item->a}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio"  name="quiz-{{$item->id}}" value="b" id="quiz-b-{{$item->id}}" >
                    <label class="form-check-label" for="quiz-b-{{$item->id}}" >{{$item->b}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio"  name="quiz-{{$item->id}}" value="c" id="quiz-c-{{$item->id}}" >
                    <label class="form-check-label" for="quiz-c-{{$item->id}}" >{{$item->c}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quiz-{{$item->id}}" value="d" id="quiz-d-{{$item->id}}" >
                    <label class="form-check-label" for="quiz-d-{{$item->id}}">{{$item->d}}</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quiz-{{$item->id}}" value="e" id="quiz-e-{{$item->id}}" >
                    <label class="form-check-label" for="quiz-e-{{$item->id}}">{{$item->e}}</label>
                </div>
            </div>
        @endforeach
        <div class="text-center">
          <button type="submit" class="btn btn-primary" onclick="submitQuiz()">
            Next
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
<script>

// window.onbeforeunload = function () {
//     return "Your progress will be lost!";
// };
let duration = {{$time ?? 7}}*60; // 7 minutes in seconds
let timerDisplay = document.getElementById('timer');

let countdown = setInterval(function () {

    let minutes = Math.floor(duration / 60);
    let seconds = duration % 60;

    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    timerDisplay.innerHTML = minutes + ":" + seconds;

    duration--;

    if (duration < 0) {
        clearInterval(countdown);

        form.submit();
    }

}, 1000);
</script>
@endsection