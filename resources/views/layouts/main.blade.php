<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mix Yoga' }}</title>
    <!-- Integrasi Bootstrap CSS dan Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light text-dark">

    <!-- Header -->
    <header class="bg-white shadow-sm py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo Tengah dengan Link ke Home -->
            <a href="{{ route('home') }}" class="d-block">
                <img src="{{ asset('public/images/logo-mix-yoga.jpg') }}" alt="Mix Yoga Logo" class="img-fluid" style="height: 50px;">
            </a>
            <!-- Login dan Register di Kanan -->
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
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold">Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">About</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Blog</a></li>
                    </ul>
                </div>

                <!-- Join Us -->
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold">Join with Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">Studio Yoga Owner</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Merchant Partners</a></li>
                    </ul>
                </div>

                <!-- Get in Touch -->
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold">Get in touch</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">Our Location</a></li>
                    </ul>
                </div>

                <!-- Social Media Links -->
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold">Connect with Us</h5>
                    <div>
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube fs-4"></i></a>
                    </div>
                </div>
            </div>

            <!-- Privacy Policy and Contact -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('privacy.policy') }}" class="text-primary text-decoration-none">Privacy Policy</a>
                <a href="https://wa.me/6281234567890" class="text-primary text-decoration-none" target="_blank">Contact</a>
            </div>
        </div>
        <div class="container text-center">
            <p>&copy; 2024 Mix Yoga. All rights reserved.</p>
    </div>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>