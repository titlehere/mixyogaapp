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
            <button id="sidebarToggle" class="btn btn-outline-secondary">
                <i class="bi bi-list"></i>
            </button>
            <!-- Logo Tengah -->
            <a href="{{ route('member.dashboard') }}" class="d-block">
                <img src="{{ asset('public/images/logo-mix-yoga.jpg') }}" alt="Mix Yoga Logo" class="img-fluid" style="height: 50px;">
            </a>
            <!-- Logout -->
            <div>
                <a href="{{ route('logout') }}" class="btn btn-link text-danger">Log Out</a>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="d-flex">
        <nav id="sidebar" class="bg-white border-end shadow-sm" style="width: 250px; min-height: 100vh;">
            <div class="p-4">
                <!-- Profile -->
                <div class="text-center mb-4">
                    <div style="width: 100px; height: 100px; overflow: hidden; border: 2px solid #ddd; border-radius: 50%;">
                        @if (session('user')->studio_logo)
                            <img src="{{ asset('public/images/studio_logos/' . session('user')->studio_logo) }}" 
                                class="w-100 h-100 object-fit-cover" alt="Logo Studio">
                        @else
                            <div class="text-muted d-flex align-items-center justify-content-center h-100">No Image</div>
                        @endif
                    </div>   
                    <h5>{{ session('user')->member_name }}</h5>
                </div>                                          
                <!-- Sidebar Buttons -->
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-building me-2"></i> Profil & Studio</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-calendar-check me-2"></i> Penjadwalan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-person-square me-2"></i> Profile Trainer</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-clipboard-data me-2"></i> Kelola Kelas</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-bar-chart-line me-2"></i> Laporan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark"><i class="bi bi-question-circle me-2"></i> Bantuan & FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main id="mainContent" class="flex-fill p-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

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
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('d-none');
            mainContent.classList.toggle('ms-0'); // Menghilangkan margin jika sidebar ditutup
        });
    </script>
</body>
</html>