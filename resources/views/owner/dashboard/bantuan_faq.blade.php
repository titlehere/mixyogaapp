@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1 class="mb-4">Bantuan & FAQ</h1>
    <div class="accordion" id="faqAccordion">
        <!-- Pertanyaan 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                    Bagaimana cara menambahkan kelas yoga baru?
                </button>
            </h2>
            <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat menambahkan kelas yoga baru melalui menu "Kelas & Penjadwalan" di dashboard. Klik tombol "Tambah Kelas" dan isi semua informasi yang diperlukan.
                </div>
            </div>
        </div>
        <!-- Pertanyaan 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                    Bagaimana cara mengelola data trainer?
                </button>
            </h2>
            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat mengelola data trainer melalui menu "Data Trainer". Di sana, Anda dapat menambah, mengedit, atau menghapus data trainer.
                </div>
            </div>
        </div>
        <!-- Tambahkan lebih banyak pertanyaan sesuai kebutuhan -->
    </div>
</div>
@endsection