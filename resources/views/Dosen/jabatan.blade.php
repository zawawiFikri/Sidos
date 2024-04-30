@extends('layouts.main')

@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Jabatan Fungsional</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/jabatan" style="font-size: 14px;">Jabatan Fungsional</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_data">+ Upload
                File</button>
        </div>
        <div class="card-body">
            @foreach ($dataJabatan as $data)
            <div class="card border d-inline-block" style="max-width: 450px; margin-right: 20px; padding-right: 55px;">
                <div class="row g-0">
                    <div class="col-md-5 border-end">
                        <img src="{{ asset('assets/img/user_tie.png') }}" class="img-fluid rounded-start" alt=""
                            style="height: 100%; max-width: 100%; object-fit: contain;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->nama_jabatan}}</h5>
                            <p class="card-text">Nomor Surat Penugasan : {{ $data->id }}</p>
                            <p class="card-text"><i class="fas fa-file-pdf"></i> {{ Str::after($data->file, '_') }}
                            <p>
                                <a href="{{ route('view_pdf_jabatan', ['id' => $data->id]) }}"
                                    class="btn btn-primary btn-sm" target="_blank">View</a>
                                <a href="{{ route('download_pdf_jabatan', ['id' => $data->id]) }}"
                                    class="btn btn-danger btn-sm">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="tambah_data" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('create_jabatan') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="id_jabatan" class="col-sm-2 col-form-label">No. Surat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id" id="id" placeholder="Nomer Surat Penugasan"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan"
                                    placeholder="Nama Jabatan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection