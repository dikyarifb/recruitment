
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
<style>
#container-background {
    position: relative;
    background-image: url('img/banner.jpg');
    background-size: contain;
    background-position: top center;
    background-repeat: no-repeat;
    background-color: black;

    aspect-ratio: 3 / 1; /* adjust based on your image */
    width: 100%;
}
/* BLACK OVERLAY */
#container-background::before {
    content: "";
    position: absolute;
    inset: 0;
    /* background: rgba(0, 0, 0, 0.3); adjust opacity here */
    z-index: 1;
}

/* keep content above overlay */
#container-background * {
    position: relative;
    z-index: 2;
}
</style>
    <!-- HERO -->
<div id="container-background"></div>
<div class="hero"  >

<div class="floating">
    <i>Build your future</i>
    <i>Grow with us</i>
    <i>Join our team</i>
    <i>Create real impact</i>
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
<input type="hidden" name="region" value="{{ request('region') }}">
<div class="row">

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-user"></i>
<input value="{{ old('name') }}" type="text" name="name" placeholder="Nama Lengkap" class="form-control" required>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-envelope"></i>
<input value="{{ old('email') }}" type="email" name="email" placeholder="Email" class="form-control" required>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-phone"></i>
<input value="{{ old('phone') }}" type="text" name="phone" placeholder="Nomor HP" class="form-control">
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-id-card"></i>
<input value="{{ old('nik') }}" type="number" name="nik" placeholder="Nomor Induk KTP (NIK)" class="form-control">
</div>

{{-- pengalaman --}}

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-briefcase"></i>
<select name="experience_position" class="form-select" required>
<option value="">Level Pekerjaan Terakhir</option>
<option value="staff" {{ old('experience_position') == 'staff' ? 'selected' : '' }}>Staff atau Operator</option>
<option value="leader"> {{ old('experience_position') == 'leader' ? 'selected' : '' }}Leader atau Supervisor</option>
<option value="manager_above" {{ old('experience_position') == 'manager_above' ? 'selected' : '' }}>Manager dan diatasnya</option>
<option value="lainnya" {{ old('experience_position') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
</select>
</div>


<div class="col-md-6 mb-3 input-icon">
<i class="fa-regular fa-calendar-check"></i>
<select name="experience_time" class="form-select" required>
<option value="">Lama Bekerja (posisi terakhir)</option>
<option value="dibawah 6 bulan" {{ old('experience_time') == 'dibawah 6 bulan' ? 'selected' : '' }}>Dibawah 6 bulan</option>
<option value="dibawah 1 tahun" {{ old('experience_time') == 'dibawah 1 tahun' ? 'selected' : '' }}>Dibawah 1 tahun</option>
<option value="1 sampai 3 tahun" {{ old('experience_time') == '1 sampai 3 tahun' ? 'selected' : '' }}>1 sampai 3 tahun</option>
<option value="diatas 3 tahun" {{ old('experience_time') == 'diatas 3 tahun' ? 'selected' : '' }}>Diatas 3 tahun</option>
</select>
</div>

{{-- end pengalaman --}}
<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-briefcase"></i>
<select name="position" class="form-select" required>
<option value="">Pilih Posisi yang diinginkan</option>
@foreach($jobs as $job)
<option value="{{ $job->position}}" {{ old('position') == $job->position ? 'selected' : '' }}>{{ $job->position }}</option>
@endforeach
<option value="other"  {{ old('position') == 'other' ? 'selected' : '' }}>Other / Lainnya</option>
</select>
</div>

<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-graduation-cap"></i>
<select name="education" class="form-select" required>
<option value="">Pendidikan Terakhir</option>
<option value="sd-smp" {{ old('education') == 'sd-smp' ? 'selected' : '' }}>SD-SMP</option>
<option value="sma/smk" {{ old('education') == 'sma/smk' ? 'selected' : '' }}>SMA/SMK</option>
<option value="d3" {{ old('education') == 'd3' ? 'selected' : '' }}>D3</option>
<option value="s1/d4" {{ old('education') == 's1/d4' ? 'selected' : '' }}>S1/D4</option>
<option value="s2" {{ old('education') == 's2' ? 'selected' : '' }}>S2</option>
<option value="lainnya" {{ old('education') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
</select>
</div>


<div class="col-12 mb-3 input-icon">
<i class="fa-solid fa-pen"></i>
<textarea name="introduction" rows="4" placeholder="Ceritakan sedikit tentang diri Anda..." class="form-control" required>{{ old('introduction') }}</textarea>
</div>


<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-ruler"></i>
<input value="{{ old('heigth') }}" type="number" name="heigth" placeholder="Tinggi Badan - cm (optional)" class="form-control">
</div>



<div class="col-md-6 mb-3 input-icon">
<i class="fa-solid fa-weight"></i>
<input value="{{ old('weight') }}" type="number" name="weight" placeholder="Berat Badan - kg (optional)" class="form-control">
</div>

<div class="col-12 mb-3 input-icon">
<i class="fa-solid fa-user"></i>
<select name="gender" class="form-select">
<option value="">Jenis Kelamin</option>
<option value="pria" {{ old('gender') == 'pria' ? 'selected' : '' }}>Pria</option>
<option value="wanita" {{ old('gender') == 'wanita' ? 'selected' : '' }}>Wanita</option>
</select>
</div>


<div class="col-12 mb-3">
<div id="upload-box" class="upload-box" onclick="triggerFileInput(this)">
<i class="fa-solid fa-cloud-arrow-up"></i>
<p>Upload CV (drag & drop atau klik) - pdf, max:1MB</p>
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
<p class="mt-2 text-secondary">{{ $job->total }} positions available • {{$job->applied}} applied </p>
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
const box = document.getElementById('upload-box');
const input = box.querySelector('input[type="file"]');
const text = document.getElementById('upload-text');

// CLICK
box.addEventListener('click', () => input.click());

// PREVENT LOOP
input.addEventListener('click', (e) => e.stopPropagation());

// HANDLE FILE
function handleFile(file) {
  if (!file) return;

  // VALIDATION
  if (file.type !== 'application/pdf') {
    alert('Hanya file PDF yang diperbolehkan!');
    resetFile();
    return;
  }

  if (file.size > 1024 * 1024) {
    alert('Ukuran file maksimal 1MB!');
    resetFile();
    return;
  }

  // UPDATE UI
  text.innerText = file.name;
}

// INPUT CHANGE
input.addEventListener('change', () => {
  handleFile(input.files[0]);
});

// DRAG OVER
box.addEventListener('dragover', (e) => {
  e.preventDefault();
  box.classList.add('hover');
});

// DRAG LEAVE
box.addEventListener('dragleave', () => {
  box.classList.remove('hover');
});

// DROP
box.addEventListener('drop', (e) => {
  e.preventDefault();
  box.classList.remove('hover');

  const file = e.dataTransfer.files[0];
  if (!file) return;

  handleFile(file);

  // Assign file to input
  const dt = new DataTransfer();
  dt.items.add(file);
  input.files = dt.files;
});
</script>
@endsection
