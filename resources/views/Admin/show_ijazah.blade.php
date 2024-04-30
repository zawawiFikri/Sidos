@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Ijazah</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                            <li class="breadcrumb-item"><a href="/berkas" style="font-size: 14px;">Data Berkas</a>
                    <li class="breadcrumb-item"><a href="javascript:history.go(-1);"
                            style="font-size: 14px;">Data Ijazah</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('show-ijasahh', ['id' => $dataIjazah->id]) }}"
                            style="font-size: 14px;">Detail</a>

                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            Lulusan {{ $dataIjazah->program_study}} - {{ $dataIjazah->institusi}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="mb-3">
                        <label for="no_surat" class="form-label">Nomor Ijazah : {{ $dataIjazah->id }}</label> <br>
                        <label for="kategori_id" class="form-label">Lulusan : {{ $dataIjazah->program_study}} - {{
                            $dataIjazah->institusi}}</label><br>
                        <label for="judul_arsip" class="form-label">Gelar : {{ $dataIjazah->gelar }}</label><br>
                        <label for="updated_at" class="form-label">Tanggal Lulus : {{
                            $dataIjazah->tgl_lulus}}</label><br>
                        <label for="status" class="form-label">
                            Status:
                            @if($dataIjazah->status == 1)
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
                        <iframe src="{{ asset('storage/file_ijazah/' . $dataIjazah->file) }}" width="100%"
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
                        data-bs-target="#edit_ijasah_{{ $dataIjazah->id }}">Edit</button>
                    @if($dataIjazah->status == 0)
                    <form action="{{ route('check_ijasah', ['id' => $dataIjazah->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-primary">Verifikasi</button>
                    </form>
                    @else
                    <form action="{{ route('check_ijasah', ['id' => $dataIjazah->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-danger">Batalkan Verifikasi</button>
                    </form>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="edit_ijasah_{{ $dataIjazah->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Ijazah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_data_ijasah', ['id' => $dataIjazah->id]) }}" class="form-horizontal"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="institusi" class="col-sm-2 col-form-label">Nama Institusi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="institusi" id="institusi"
                                        placeholder="Nama Institusi" required value="{{$dataIjazah->institusi}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="program_study" class="col-sm-2 col-form-label">Program Study</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="program_study" id="program_study"
                                        placeholder="Nama Program Study" required value="{{$dataIjazah->program_study}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gelar" class="col-sm-2 col-form-label">Gelar</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="gelar" id="gelar"
                                        placeholder="Nama Gelar" required value="{{$dataIjazah->gelar}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lulus" class="col-sm-2 col-form-label">Tanggal Lulus</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tgl_lulus" id="tgl_lulus" required value="{{$dataIjazah->tgl_lulus}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-sm-2 col-form-label">File Ijazah</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                        placeholder="Piih File Ijazah" value="{{$dataIjazah->file}}">
                                </div>
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