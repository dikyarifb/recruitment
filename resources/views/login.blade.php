@extends('template.master')

@section('content')

<div class="floating">
    <i class="fa-solid fa-user"></i>
    <i class="fa-solid fa-lock"></i>
    <i class="fa-solid fa-briefcase"></i>
    <i class="fa-solid fa-building"></i>
</div>

<section class="hero">
    <div class="container">
        <h1>ARSAtech</h1>
        <p>Login to access Logic & DiSC test</p>
    </div>
</section>

<section class="section">
    <div class="container d-flex justify-content-center">
        <div class="glass p-4" style="max-width:400px; width:100%;">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3 input-icon">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="mb-3 input-icon">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button class="btn btn-primary w-100">Login</button>

                <div class="text-center mt-3">
                    <small class="text-secondary">Forgot password?</small>
                </div>

            </form>

        </div>
    </div>
</section>

<style>
/* OVERRIDE TO RED THEME */
.feature i,
.job-card i,
.upload-box i {
    color: #EF3535 !important;
}

.glass:hover,
.job-card:hover,
.upload-box:hover {
    border-color: #EF3535 !important;
}

.nav-tabs .nav-link.active {
    border-bottom: 2px solid #EF3535 !important;
}

.input-icon:hover i {
    color: #EF3535 !important;
}

.btn-primary {
    background: #EF3535 !important;
}

.btn-primary:hover {
    background: #C62828 !important;
}
</style