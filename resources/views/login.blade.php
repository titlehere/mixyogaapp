@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <!-- Display Errors or Success Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h4 class="fw-bold">Login Error</h4>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <h4 class="fw-bold">Success</h4>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Login Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Welcome Back!</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <button type="button" onclick="togglePassword('password')" class="btn btn-link position-absolute top-0 end-0 mt-2 me-2">Show</button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Log In</button>
                    </form>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="mt-3 text-center">
                <p>Don't have an account? <a href="{{ route('register') }}" class="text-primary">Sign Up</a></p>
            </div>
        </div>
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