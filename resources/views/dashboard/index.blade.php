@extends('layouts.main')

@section('content')
@if (auth()->user()->isAdmin())
<div class="page-content">
    <div class="col-sm-12">
        <div class="page-sub-header">
            <h3 class="page-title" style="color: green;">
                <?php
                        $nama = auth()->user()->name;
                        echo $nama;
                ?> / Admin
            </h3>
        </div>
        <div class="card mb-4">
            <div class="card-header" style="max-height: 35px; padding-top: 5px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                                href="/dashboard" style="font-size: 14px;">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard" style="font-size: 14px;">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
            @include('layouts.alert-flash-message')
        <div class="page-sub-header">
            <h3 class="page-title">Selamat Datang</h3>
        </div>
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/kediri.jpeg') }}"
                        class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">SIDOS</h5>
                        <p class="card-text">adalah Sistem Informasi berupa Website yang dibuat khusus untuk dosen dalam
                            melakukan pemberkasan data dosen
                            tetap program studi di Prodi D4 Teknik Elektronika Polinema PSDKU di Kota Kediri
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 5px;">
            <div class="card-header">
                <h5>Pengumuman Terbaru</h5>
            </div>
            <div class="card-body">
                <h3>Pengumuman Jadwal Upload Serkom</h3>
                <a>Berikut adalah Jadwal Upload Sertifikat Kompetensi</a>
                <ul style="list-style: circle; margin-left: 20px;">
                    <li>Batch 1 : 15 – 20 November 2023</li>
                    <li>Batch 2 : 2 – 15 Desember 2023</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@if (auth()->user()->isDosen())
<div class="page-content">
    <div class="col-sm-12">
        <div class="page-sub-header">
            <h3 class="page-title" style="color: green;">
                <?php
                        $nama = auth()->user()->name;
                        echo $nama;
                    ?> / Dosen
            </h3>
        </div>
        <div class="card mb-4">
            <div class="card-header" style="max-height: 35px; padding-top: 5px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                                href="/dashboard" style="font-size: 14px;">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard" style="font-size: 14px;">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
            @include('layouts.alert-flash-message')
        <div class="page-sub-header">
            <h3 class="page-title">Selamat Datang</h3>
        </div>
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/kediri.jpeg') }}"
                        class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">SIDOS</h5>
                        <p class="card-text">adalah Sistem Informasi berupa Website yang dibuat khusus untuk dosen dalam
                            melakukan pemberkasan data dosen
                            tetap program studi di Prodi D4 Teknik Elektronika Polinema PSDKU di Kota Kediri
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 5px;">
            <div class="card-header">
                <h5>Pengumuman Terbaru</h5>
            </div>
            <div class="card-body">
                <h3>Pengumuman Jadwal Upload Serkom</h3>
                <a>Berikut adalah Jadwal Upload Sertifikat Kompetensi</a>
                <ul style="list-style: circle; margin-left: 20px;">
                    <li>Batch 1 : 15 – 20 November 2023</li>
                    <li>Batch 2 : 2 – 15 Desember 2023</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection