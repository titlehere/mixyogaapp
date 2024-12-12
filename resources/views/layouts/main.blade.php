<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mix Yoga' }}</title>
    <!-- Integrasi Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-md p-4 relative flex items-center">
        <!-- Sidebar Trigger di Kiri -->
        <div class="absolute left-4">
            <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
                <!-- Icon Tiga Garis -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    
        <!-- Logo di Tengah -->
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('public/images/logo-mix-yoga.jpg') }}" alt="Mix Yoga Logo" class="h-12">
        </div>

        <!-- Link Login & Register di Kanan -->
        <div class="absolute right-4 flex space-x-4">
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content') <!-- Tempat untuk isi halaman -->
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 p-4 text-center flex justify-between items-center">
        <a href="{{ route('privacy.policy') }}" class="text-blue-500 hover:underline">Privacy Policy</a>
        <a href="https://wa.me/6281234567890" class="text-blue-500 hover:underline" target="_blank">Contact</a>
    </footer>

</body>
</html>