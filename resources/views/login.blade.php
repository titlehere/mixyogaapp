@extends('layouts.main')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <!-- Display Errors or Success Messages -->
    @if ($errors->any())
        <div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-lg font-bold text-red-500 mb-4">Login Error</h2>
                <ul class="list-disc list-inside text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-lg font-bold text-green-500 mb-4">Success</h2>
                <p>{{ session('success') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    @endif

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold">Welcome Back!</h1>
    </div>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="email" name="email" class="w-full border p-2 mb-4" placeholder="Email Address" required>
        
        <div class="relative">
            <input type="password" id="password" name="password" class="w-full border p-2 mb-4" placeholder="Password" required>
            <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:underline">Show</button>
        </div>

        {{-- <div class="flex justify-between items-center mb-4">
            <a href="https://wa.me/1234567890?text=Tolong,%20saya%20lupa%20password." target="_blank" class="text-blue-500 hover:underline">Contact if Forgot Password</a>
        </div> --}}
        <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded">Log In</button>
    </form>

    <div class="mt-4 text-center">
        <span>Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign Up</a></span>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            event.target.textContent = "Hide";
        } else {
            field.type = "password";
            event.target.textContent = "Show";
        }
    }
</script>
@endsection