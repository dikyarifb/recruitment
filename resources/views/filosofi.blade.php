@extends('template.master')
@section('script')
@endsection
@section('content')
<style>
.philosophy {
    min-height: 100vh;
    /* background: #081A33; */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 64px 32px;
    text-align: center;
}

.philosophy h1 {
    margin: 0 0 40px;
    color: #FFFFFF;
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.philosophy p {
    max-width: 760px;
    margin: 0;
    color: rgba(255,255,255,.82);
    font-size: 1.45rem;
    line-height: 2;
    font-style: italic;
    font-weight: 300;
    position: relative;
}

.philosophy p::before {
    content: "“";
    position: absolute;
    top: -45px;
    left: -15px;
    font-size: 7rem;
    color: rgba(255,255,255,.08);
    line-height: 1;
}

.philosophy p::after {
    content: "”";
    position: absolute;
    bottom: -75px;
    right: -10px;
    font-size: 7rem;
    color: rgba(255,255,255,.08);
    line-height: 1;
}
.btn-next {
    margin-top: 56px;
    padding: 14px 42px;
    background: #FFFFFF;
    color: #081A33;
    border: none;
    border-radius: 999px;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: .5px;
    cursor: pointer;
    transition: all .25s ease;
}

.btn-next:hover {
    background: #D6E4FF;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,0,0,.25);
}
</style>
<div class="philosophy">
    <p>
        "{{$text}}"
    </p>
    <a href="/employee/test/initiative" class="btn btn-light btn-next mt-4">
        Selanjutnya
    </a>
</div>
@endsection