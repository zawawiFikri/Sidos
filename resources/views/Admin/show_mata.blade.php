@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Matkul</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                            <li class="breadcrumb-item"><a href="/berkas" style="font-size: 14px;">Data Berkas</a>
                    <li class="breadcrumb-item"><a href="javascript:history.go(-1);"
                            style="font-size: 14px;">Data Matkul</a></li>

                    <li class="breadcrumb-item"><a href="{{ route('show-mataa', ['id' => $dataMata->id]) }}"
                            style="font-size: 14px;">Detail</a>

                    </li>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            Mata Kuliah {{ $dataMata->matkul}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="mb-3">
                        <label for="no_surat" class="form-label">Nomor Matkul : {{ $dataMata->id }}</label> <br>
                        <label for="kategori_id" class="form-label">Mata Kuliah : {{ $dataMata->matkul}}</label><br>
                        <label for="judul_arsip" class="form-label">SKS : {{ $dataMata->sks }}</label><br>
                        <label for="judul_arsip" class="form-label">Kelas : {{ $dataMata->kelas }}</label><br>
                        <label for="updated_at" class="form-label">Tahun Ajar : {{ $dataMata->thn_ajar}}</label><br>
                        <label for="status" class="form-label">
                            Status:
                            @if($dataMata->status == 1)
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
                        <iframe src="{{ asset('storage/file_nilai/' . $dataMata->file) }}" width="100%"
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
                        data-bs-target="#edit_mata_{{ $dataMata->id }}">Edit</button>
                    @if($dataMata->status == 0)
                    <form action="{{ route('check_mata', ['id' => $dataMata->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-primary">Verifikasi</button>
                    </form>
                    @else
                    <form action="{{ route('check_mata', ['id' => $dataMata->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-danger">Batalkan Verifikasi</button>
                    </form>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="edit_mata_{{ $dataMata->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Ijazah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_data_mata', ['id' => $dataMata->id]) }}" class="form-horizontal"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="Matkul" class="col-sm-2 col-form-label">Nama Matkul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="matkul" id="matkul" placeholder="Nama Matkul"
                                    required value="{{ $dataMata->matkul }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sks" class="col-sm-2 col-form-label">SKS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="sks" id="sks" placeholder="Jumlah SKS"
                                    required  value="{{ $dataMata->sks }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelas" class="col-sm-2 col-form-label">Nama Kelas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas"
                                    required  value="{{ $dataMata->kelas }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thn_ajar" class="col-sm-2 col-form-label">Tahun Ajar</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="thn_ajar" id="thn_ajar"
                                    placeholder="Tahun Ajar" required  value="{{ $dataMata->thn_ajar }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File"value="{{ $dataMata->file }}">
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