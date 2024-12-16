@extends('layouts.main')

@section('content')
<div class="container py-5">
    <!-- Toggle Buttons -->
    <div class="text-center mb-4">
        <button id="btnMember" class="btn btn-primary me-2">Member</button>
        <button id="btnOwner" class="btn btn-outline-primary">Owner Studio</button>
    </div>

    <!-- Form Member -->
    <div id="formMember">
        <form action="{{ route('register.member') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf
            <h3 class="mb-4 text-primary">Member Registration</h3>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email (example@email.com)" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="No HP (ex: 081234567890)" required>
            </div>
            <div class="mb-3">
                <label for="profile_photo" class="form-label">Foto Profil (optional)</label>
                <input type="file" name="profile_photo" class="form-control" accept="image/png, image/jpg, image/jpeg">
            </div>
            <div class="mb-3 position-relative">
                <input type="password" id="memberPassword" name="password" class="form-control" placeholder="Password" required>
                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-0 mt-1 me-2" onclick="togglePassword('memberPassword')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="mb-3 position-relative">
                <input type="password" id="memberPasswordConfirm" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-0 mt-1 me-2" onclick="togglePassword('memberPasswordConfirm')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
    </div>

    <!-- Form Owner -->
    <div id="formOwner" style="display: none;">
        <form action="{{ route('register.owner') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            @csrf
            <h3 class="mb-4 text-primary">Owner Registration</h3>
            <!-- Owner Details -->
            <h5 class="text-secondary mb-3">Owner Details</h5>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email (example@email.com)" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="No HP (ex: 081234567890)" required>
            </div>
            <div class="mb-3 position-relative">
                <input type="password" id="ownerPassword" name="password" class="form-control" placeholder="Password" required>
                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-0 mt-1 me-2" onclick="togglePassword('ownerPassword')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="mb-3 position-relative">
                <input type="password" id="ownerPasswordConfirm" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-0 mt-1 me-2" onclick="togglePassword('ownerPasswordConfirm')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <!-- Studio Details -->
            <h5 class="text-secondary mb-3">Studio Details</h5>
            <div class="mb-3">
                <input type="text" name="studio_name" class="form-control" placeholder="Nama Studio" required>
            </div>
            <div class="mb-3">
                <input type="text" name="studio_address" class="form-control" placeholder="Alamat Studio" required>
            </div>
            <div class="mb-3">
                <input type="file" name="studio_logo" class="form-control" accept="image/png,image/jpg,image/jpeg" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
    </div>
</div>

<!-- JavaScript for Toggle Password -->
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    document.getElementById('btnMember').addEventListener('click', function () {
        document.getElementById('formMember').style.display = 'block';
        document.getElementById('formOwner').style.display = 'none';
        this.classList.add('btn-primary');
        this.classList.remove('btn-outline-primary');
        document.getElementById('btnOwner').classList.add('btn-outline-primary');
        document.getElementById('btnOwner').classList.remove('btn-primary');
    });

    document.getElementById('btnOwner').addEventListener('click', function () {
        document.getElementById('formOwner').style.display = 'block';
        document.getElementById('formMember').style.display = 'none';
        this.classList.add('btn-primary');
        this.classList.remove('btn-outline-primary');
        document.getElementById('btnMember').classList.add('btn-outline-primary');
        document.getElementById('btnMember').classList.remove('btn-primary');
    });
</script>
@endsection