<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mix Yoga' }}</title>
    <!-- Integrasi Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light text-dark">

    <!-- Header -->
    <header class="bg-white shadow-sm py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <button id="sidebarToggle" class="btn btn-outline-secondary">
                <i class="bi bi-list"></i>
            </button>
            <img src="{{ asset('public/images/logo-mix-yoga.jpg') }}" alt="Mix Yoga Logo" class="img-fluid" style="height: 50px;">
            <div>
                <a href="{{ route('login') }}" class="btn btn-link text-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-link text-primary">Register</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-fill">
        <div class="container">
            @yield('content') <!-- Tempat untuk isi halaman -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-3 text-center">
        <div class="container d-flex justify-content-between">
            <a href="{{ route('privacy.policy') }}" class="text-primary">Privacy Policy</a>
            <a href="https://wa.me/6281234567890" class="text-primary">Contact</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
