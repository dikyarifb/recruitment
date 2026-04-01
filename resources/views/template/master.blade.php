
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
@yield('script')
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
@yield('content')



</body>
</html>