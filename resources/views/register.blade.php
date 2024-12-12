@extends('layouts.main')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <!-- Display Error or Success Messages -->
    @if ($errors->any())
        <div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-lg font-bold text-red-500 mb-4">Validation Errors</h2>
                <ul class="list-disc list-inside text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-lg font-bold text-red-500 mb-4">Error</h2>
                <p class="text-red-500">{{ session('error') }}</p>
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

    <!-- Toggle Buttons -->
    <div class="flex justify-center mb-4">
        <button id="btnMember" class="bg-blue-500 text-white px-4 py-2 mr-2 rounded">Member</button>
        <button id="btnOwner" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Owner Studio</button>
    </div>

    <!-- Form Member -->
    <div id="formMember" class="hidden">
        <form action="{{ route('register.member') }}" method="POST">
            @csrf
            <input type="text" name="username" class="w-full border p-2 mb-4" placeholder="Username" required>
            <input type="email" name="email" class="w-full border p-2 mb-4" placeholder="Email (example@email.com)" required>
            <input type="text" name="phone" class="w-full border p-2 mb-4" placeholder="No HP (ex: 081234567890)" required>
            
            <div class="relative">
                <input type="password" id="memberPassword" name="password" class="w-full border p-2 mb-4" placeholder="Password" required>
                <button type="button" onclick="togglePassword('memberPassword')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:underline">Show</button>
            </div>

            <div class="relative">
                <input type="password" id="memberPasswordConfirm" name="password_confirmation" class="w-full border p-2 mb-4" placeholder="Confirm Password" required>
                <button type="button" onclick="togglePassword('memberPasswordConfirm')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:underline">Show</button>
            </div>

            <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded">Sign Up</button>
        </form>
    </div>

    <!-- Form Owner -->
    <div id="formOwner" class="hidden">
        <form action="{{ route('register.owner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 class="text-lg font-bold mb-2">Owner Details</h2>
            <input type="text" name="username" class="w-full border p-2 mb-4" placeholder="Username" required>
            <input type="email" name="email" class="w-full border p-2 mb-4" placeholder="Email (example@email.com)" required>
            <input type="text" name="phone" class="w-full border p-2 mb-4" placeholder="No HP (ex: 081234567890)" required>
            
            <div class="relative">
                <input type="password" id="ownerPassword" name="password" class="w-full border p-2 mb-4" placeholder="Password" required>
                <button type="button" onclick="togglePassword('ownerPassword')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:underline">Show</button>
            </div>

            <div class="relative">
                <input type="password" id="ownerPasswordConfirm" name="password_confirmation" class="w-full border p-2 mb-4" placeholder="Confirm Password" required>
                <button type="button" onclick="togglePassword('ownerPasswordConfirm')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:underline">Show</button>
            </div>

            <h2 class="text-lg font-bold mb-2">Studio Details</h2>
            <input type="text" name="studio_name" class="w-full border p-2 mb-4" placeholder="Nama Studio" required>
            <input type="text" name="studio_address" class="w-full border p-2 mb-4" placeholder="Alamat Studio" required>
            <input type="file" name="studio_logo" class="w-full border p-2 mb-4" accept="image/png,image/jpg,image/jpeg" required>

            <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded">Sign Up</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('btnMember').addEventListener('click', function () {
        document.getElementById('formMember').classList.remove('hidden');
        document.getElementById('formOwner').classList.add('hidden');
    });

    document.getElementById('btnOwner').addEventListener('click', function () {
        document.getElementById('formOwner').classList.remove('hidden');
        document.getElementById('formMember').classList.add('hidden');
    });

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