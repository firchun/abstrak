@extends('layouts.app_home')

@section('content')
    <section class="section" id="syarat">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12">
                    <div class="section-title">
                        <p class="text-primary text-uppercase fw-bold mb-3">Tentang UPT</p>
                        <h1>UPT bahasa Universitas Musamus</h1>
                    </div>
                </div>
                <div class="col-md-4">
                    <img loading="lazy" decoding="async" src="{{ asset('img/perpus.jpeg') }}" alt="banner image"
                        class="w-100 shadow-md " style="border-radius:20px;">
                </div>
                <div class="col-md-8">
                    <div class="content mb-0 mt-4">
                        <p>"UPT Bahasa Universitas Musamus Merauke merupakan pusat pengembangan dan peningkatan
                            kemampuan bahasa bagi mahasiswa dan mahasiswi, dengan tujuan membekali mereka dengan
                            keterampilan berbahasa yang memadai untuk menghadapi tantangan akademik dan profesional di
                            era global."
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
