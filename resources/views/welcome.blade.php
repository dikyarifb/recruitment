<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Arsa Indonesia Careers</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
    font-family: 'Inter', sans-serif;
    background: #020617;
    color: #e2e8f0;
    overflow-x: hidden;
}

/* FLOATING ICONS */
.floating i {
    position: absolute;
    color: rgba(56,189,248,0.15);
    animation: float 6s infinite ease-in-out;
}

.floating i:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
.floating i:nth-child(2) { top: 30%; left: 80%; animation-delay: 1s; }
.floating i:nth-child(3) { top: 70%; left: 10%; animation-delay: 2s; }
.floating i:nth-child(4) { top: 60%; left: 70%; animation-delay: 3s; }

@keyframes float {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.hero {
    position: relative;
    padding: 100px 0 60px;
    text-align: center;
    background: radial-gradient(circle at top, #1e293b, #020617);
}

.hero h1 { font-size: 48px; font-weight: 700; }
.hero p { color: #94a3b8; margin-top: 10px; }
.cta-btn { margin-top: 20px; }

.section { padding: 60px 0; }

.glass {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    transition: 0.3s;
}

.glass:hover {
    border-color: #0b5ed7;
}

.feature { text-align: center; padding: 20px; }
.feature i { font-size: 30px; color: #0b5ed7; transition: 0.3s; }
.feature:hover i { transform: scale(1.2) rotate(5deg); }

.nav-tabs { border: none; justify-content: center; }
.nav-tabs .nav-link { border: none; color: #94a3b8; font-weight: 600; }
.nav-tabs .nav-link.active { color: navy; border-bottom: 2px solid #0b5ed7; }

.form-control, .form-select {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding-left: 40px;
}

.input-icon { position: relative; }
.input-icon i {
    position: absolute;
    top: 50%;
    left: 22px;
    transform: translateY(-50%);
    color: #94a3b8;
    transition: 0.2s;
}

.input-icon:hover i { color: #0b5ed7; }

.job-card { transition: 0.3s; cursor: pointer; }
.job-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: #0b5ed7;
}

.job-card i { color: #0b5ed7; margin-right: 6px; }

.btn-primary {
    background: #0b5ed7;
    border: none;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #0ea5e9;
    transform: scale(1.03);
}

.footer { text-align: center; color: #64748b; padding: 40px 0; }

/* DRAG & DROP */
.upload-box {
    border: 2px dashed rgba(255,255,255,0.2);
    padding: 30px;
    text-align: center;
    border-radius: 15px;
    transition: 0.3s;
}

.upload-box:hover {
    border-color: #0b5ed7;
    background: rgba(56,189,248,0.05);
}

.upload-box i {
    font-size: 30px;
    margin-bottom: 10px;
    color: #0b5ed7;
}

.form-control::placeholder {
  color: grey; /* Example: A shade of red, you can use hex codes, RGB, or color names */
  opacity: 1; /* Firefox uses a lower opacity by default, this ensures consistency */
}

</style>
</head>
<body>
@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    let errors = `{!! implode('<br>', $errors->all()) !!}`;
    
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: errors
    });
});
</script>
@endif
@if (session('message'))
<script>
document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 2000
        });
});
</script>
@endif

<!-- HERO -->
<div class="hero">

<div class="floating">
    <i class="fa-solid fa-code fa-2x"></i>
    <i class="fa-solid fa-database fa-2x"></i>
    <i class="fa-solid fa-server fa-2x"></i>
    <i class="fa-solid fa-microchip fa-2x"></i>
</div>

<div class="container">
    <h1><i class="fa-solid fa-rocket"></i>Join ARSA Indonesia</h1>
    <p>We deliver professional services that support businesses and communities. Be part of a team that creates real-world impact every day.</p>
    <button class="btn btn-primary cta-btn" onclick="scrollToSection()">
        <i class="fa-solid fa-briefcase"></i> Explore Careers
    </button>
</div>
</div>

<!-- FEATURES -->
<div class="section">
<div class="container">
<div class="row">

<div class="col-md-4">
<div class="feature">
<i class="fa-solid fa-bolt mb-4"></i>
<h6>Meaningful Work</h6>
<p class="text-secondary">Contribute to services that directly support clients and improve daily operations.</p>
</div>
</div>

<div class="col-md-4">
<div class="feature">
<i class="fa-solid fa-chart-line mb-4"></i>
<h6>Career Development</h6>
<p class="text-secondary">We support continuous learning and long-term career growth.</p>
</div>
</div>

<div class="col-md-4">
<div class="feature">
<i class="fa-solid fa-code mb-4"></i>
<h6>Professional Excellence</h6>
<p class="text-secondary">Deliver high-quality service with strong standards and teamwork.</p>
</div>
</div>

</div>
</div>
</div>

<!-- CAREER -->
<div class="section" id="career">
<div class="container">

<ul class="nav nav-tabs">
<li class="nav-item">
<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#apply">
<i class="fa-solid fa-paper-plane"></i> Apply
</button>
</li>
<li class="nav-item">
<button class="nav-link" data-bs-toggle="tab" data-bs-target="#jobs">
<i class="fa-solid fa-list"></i> Open Roles
</button>
</li>
</ul>

<div class="tab-content mt-4">

<!-- APPLY -->
<div class="tab-pane fade show active" id="apply">
<div class="glass p-4">
<h5 class="mb-4"><i class="fa-solid fa-user-plus"></i> Apply Now</h5>

<form action="/apply" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-user"></i>
<input type="text" name="name" placeholder="Nama Lengkap" class="form-control" required>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-envelope"></i>
<input type="email" name="email" placeholder="Email" class="form-control" required>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-phone"></i>
<input type="text" name="phone" placeholder="Nomor HP" class="form-control">
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-id-card"></i>
<input type="text" name="nik" placeholder="Nomor Induk KTP (NIK)" class="form-control">
</div>

{{-- pengalaman --}}

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-briefcase"></i>
<select name="experience_position" class="form-select" required>
<option value="">Level Pekerjaan Terakhir</option>
<option value="staff">Staff atau Operator</option>
<option value="leader">Leader atau Supervisor</option>
<option value="manager_above">Manager dan diatasnya</option>
<option value="lainnya">Lainnya</option>
</select>
</div>


<div class="col-md-6 mb-3 input-icon">
<i class="fa-regular fa-calendar-check"></i>
<select name="experience_time" class="form-select" required>
<option value="">Lama Bekerja (posisi terakhir)</option>
<option value="dibawah 6 bulan">Dibawah 6 bulan</option>
<option value="dibawah 1 tahun">Dibawah 1 tahun</option>
<option value="1 sampai 3 tahun">1 sampai 3 tahun</option>
<option value="diatas 3 tahun">Diatas 3 tahun</option>
</select>
</div>

{{-- end pengalaman --}}
<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-briefcase"></i>
<select name="position" class="form-select" required>
<option value="">Pilih Posisi yang diinginkan</option>
@foreach($jobs as $job)
<option value="{{ $job->position}}">{{ $job->position }}</option>
@endforeach
<option value="other">Other / Lainnya</option>
</select>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-graduation-cap"></i>
<select name="education" class="form-select" required>
<option value="">Pendidikan Terakhir</option>
<option value="sd-smp">SD-SMP</option>
<option value="sma/smk">SMA/SMK</option>
<option value="d3">D3</option>
<option value="s1/d4">S1/D4</option>
<option value="s2">S2</option>
<option value="lainnya">Lainnya</option>
</select>
</div>


<div class="col-12 mb-3 input-icon">
<i class="fa-solid fa-pen"></i>
<textarea name="introduction" rows="4" placeholder="Ceritakan sedikit tentang diri Anda..." class="form-control" required></textarea>
</div>

<div class="col-12 mb-3">
<div class="upload-box">
<i class="fa-solid fa-cloud-arrow-up"></i>
<p>Upload CV (drag & drop atau klik) - pdf, max:2MB</p>
<input type="file" name="cv" class="form-control mt-2">
</div>
</div>

</div>

<button class="btn btn-primary w-100">
<i class="fa-solid fa-paper-plane"></i> Kirim Lamaran
</button>
</form>
</div>
</div>

<!-- JOBS -->
<div class="tab-pane fade" id="jobs">
<div class="row">

@foreach($jobs as $job)
<div class="col-md-6 mb-4">
<div class="glass p-4 job-card" onclick="applyJob('{{ $job->id }}')">
<h6 class="fw-bold"><i class="fa-solid fa-briefcase"></i> {{ $job->position }}</h6>
<small class="text-secondary">
{{-- <i class="fa-solid fa-location-dot"></i> {{ $job->position }} --}}
</small>
<p class="mt-2 text-secondary">{{ $job->total }} positions available • 0 applied today </p>
</div>
</div>
@endforeach

</div>
</div>

</div>
</div>
</div>

<div class="footer">
<i class="fa-solid fa-code"></i> © {{ date('Y') }} Arsa Indonesia — Built with purpose
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function applyJob(id) {
    document.querySelector('[data-bs-target="#apply"]').click();
    setTimeout(() => {
        document.querySelector('[name="job_id"]').value = id;
    }, 200);
}

function scrollToSection() {
    document.getElementById('career').scrollIntoView({ behavior: 'smooth' });
}
</script>

</body>
</html>
