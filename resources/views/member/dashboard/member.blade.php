@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Dashboard Member</h1>
    <p>Selamat datang di dashboard member, {{ session('user')->member_name }}!</p>
    <p>Email: {{ session('user')->member_email }}</p>
    <a href="{{ route('home') }}" class="text-blue-500 hover:underline">Kembali ke Halaman Utama</a>
</div>
@endsection