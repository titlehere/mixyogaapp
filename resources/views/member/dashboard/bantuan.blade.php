@extends('layouts.member_main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Bantuan & FAQ</h2>

    <!-- Daftar FAQ -->
    <div class="accordion" id="faqAccordion">
        <!-- Pertanyaan 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                    Apa itu Mix Yoga?
                </button>
            </h2>
            <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Mix Yoga adalah platform online yang menyediakan informasi dan layanan untuk bergabung dengan berbagai studio yoga.
                </div>
            </div>
        </div>

        <!-- Pertanyaan 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                    Bagaimana cara mendaftar menjadi member?
                </button>
            </h2>
            <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat mendaftar melalui halaman registrasi pada menu utama. Isi formulir dengan data yang valid dan ikuti instruksi yang diberikan.
                </div>
            </div>
        </div>

        <!-- Pertanyaan 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                    Bagaimana cara menghubungi layanan pelanggan?
                </button>
            </h2>
            <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat menghubungi kami melalui email support@mixyoga.com atau WhatsApp di nomor +62 812 3456 7890.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection