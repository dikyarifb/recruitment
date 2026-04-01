@extends('template.master')
@section('script')
<script>
history.pushState(null, null, location.href);

window.onpopstate = function () {
    window.location.replace("/");
};
</script>
@endsection
@section('content')
</script>
</script>
    <div class="section">
  <div class="container">
    <div class="glass p-4">

      <h3 class="mb-4 text-center">🧠 (2/2) Test Kepribadian - 15 minutes</h3>
        <div class="text-center mb-3">
            <h5>
                ⏱ Time Left: <span id="timer">15:00</span>
            </h5>
            <p>Pilih yang paling sesuang dengan diri kamu.</p>
        </div>
      <form action="/test/disc" method="POST" id="form">
        @csrf
        <input type="hidden" name="lazawami" value="{{$id}}">
        @foreach ($datas as $key => $item)
             <div class="mb-4">
                {{-- <p><strong>{{$key+1}}. {{$item->question}}</strong></p> --}}

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quiz-{{$item->id}}" value="a">
                    <label class="form-check-label">{{$item->a}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio"  name="quiz-{{$item->id}}" value="b">
                    <label class="form-check-label">{{$item->b}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio"  name="quiz-{{$item->id}}" value="c">
                    <label class="form-check-label">{{$item->c}}</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="quiz-{{$item->id}}" value="d">
                    <label class="form-check-label">{{$item->d}}</label>
                </div>
            </div>
        @endforeach
        <div class="text-center">
          <button type="submit" class="btn btn-primary" onclick="submitQuiz()">
            Submit Answer
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
let duration = 15 * 60; // 7 minutes in seconds
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

        Swal.fire({
            title: 'Time is up!',
            text: 'Your answers will be submitted automatically.',
            icon: 'warning',
            confirmButtonText: 'OK'
        }).then(() => {
            submitQuiz(); // call your existing function
            const form = document.getElementById("form");

            // Submit the form programmatically
            form.submit();
        });
    }

}, 1000);
</script>
@endsection