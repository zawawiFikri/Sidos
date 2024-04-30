@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Jabatan</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                            <li class="breadcrumb-item"><a href="/berkas" style="font-size: 14px;">Data Berkas</a>
                    <li class="breadcrumb-item"><a href="javascript:history.go(-1);"
                            style="font-size: 14px;">Data Jabatan</a></li>

                    <li class="breadcrumb-item"><a href="{{ route('show-jbtt', ['id' => $dataJbt->id]) }}"
                            style="font-size: 14px;">Detail</a>

                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            Jabatan {{ $dataJbt->nama_jabatan}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="mb-3">
                        <label for="no_surat" class="form-label">Nomor Surat : {{ $dataJbt->id }}</label> <br>
                        <label for="kategori_id" class="form-label">Jabatan : {{ $dataJbt->nama_jabatan}}</label><br>
                        <label for="status" class="form-label">
                            Status:
                            @if($dataJbt->status == 1)
                            Terverifikasi
                            @else
                            Belum Terverifikasi
                            @endif
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-lg-12">
                    <div class="mb-3">
                        <iframe src="{{ asset('storage/file_jabatan/' . $dataJbt->file) }}" width="100%"
                            height="600px"></iframe>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-start pb-3">
                <div class="btn-group d-gap gap-2">
                    <a href="javascript:history.go(-1);" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit_jbt_{{ $dataJbt->id }}">Edit</button>
                    @if($dataJbt->status == 0)
                    <form action="{{ route('check_jbt', ['id' => $dataJbt->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-primary">Verifikasi</button>
                    </form>
                    @else
                    <form action="{{ route('check_jbt', ['id' => $dataJbt->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-danger">Batalkan Verifikasi</button>
                    </form>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="edit_jbt_{{ $dataJbt->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_data_jbt', ['id' => $dataJbt->id]) }}" class="form-horizontal"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="nama_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan"
                                    placeholder="Nama Jabatan" required value="{{ $dataJbt->nama_jabatan }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File">
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