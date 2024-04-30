@extends('layouts.main')

@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Request</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/request" style="font-size: 14px;">Request</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_request">+ Upload
                Request</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center" id="tabel-request">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama Dosen</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Jenis Request</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Tanggal Request</th>
                        <th class="text-center" scope="col" style="width: 5%; font-size: 12px;">Status</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataRequest as $data)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration }}</td>
                        <td> {{ auth()->user()->name }}</td>
                        <td> {{ $data->jenis_req }}</td>
                        <td> {{ $data->created_at }}</td>
                        <td class="text-center">
                            <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#view_request_{{ $data->id }}">Detail</button>
                            <form action="{{ route('hapus', ['id' => $data->id]) }}" method="post">@csrf
                                <button class="btn btn-danger btn-sm">Bersihkan</button>
                            </form>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tambah_request" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('create_request') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="jenis_req" class="col-sm-2 col-form-label">Jenis Request</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="jenis_req" name="jenis_req" required>
                                    <option selected disabled value="Default">Pilih Jenis Request</option>
                                    <option value="Hapus Data Berkas">Hapus Data Berkas</option>
                                    <option value="Edit Data Berkas">Edit Data Berkas</option>
                                    <option value="Upload Data Berkas">Upload Data Berkas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isi_req" class="col-sm-2 col-form-label">Isi Request</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="isi_req" id="isi_req"
                                    placeholder="Keterangan Isi Request" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label" id="fileContainer">File request</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Pilih File request">
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
    @foreach ($dataRequest as $data)
    <div class="modal fade" id="view_request_{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="isi_req" class="col-sm-2 col-form-label">Isi Request</label>
                                <label for="isi_req" name="isi_req" class="col-sm-10 col-form-label">{{ $data->isi_req
                                    }}</label>
                            </div>
                            @if($data->file)
                            <div class="form-group row">
                                <label for="file" class="col-sm-2 col-form-label">File request</label>
                                <div class="col-sm-10">
                                    <a href="{{ route('view_pdf_request', ['id' => $data->id]) }}" target="_blank">{{
                                        $data->file }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <label for="file" class="col-sm-12 col-form-label">
                            <?php
               if ($data->status == 1) {
                echo 'Status : Sukses';
            } else {
                echo 'Status : Tidak ada';
            }
            ?>
                        </label>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    #file {
        display: none;
    }

    #fileContainer {
        display: none;
    }
</style>

<script>
    document.getElementById('jenis_req').addEventListener('change', function () {
        var fileContainer = document.getElementById('fileContainer');
        var file = document.getElementById('file');

        if (this.value === 'Upload Data Berkas') {
            fileContainer.style.display = 'block';
            file.style.display = 'block';
        } else {
            fileContainer.style.display = 'none';
            file.style.display = 'none';
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('#tabel-request').DataTable({
            "paging": true,
            "pageLength": 5,
            "searching": true,
            "ordering": false,
            "info": false,
            "language": {
                "search": "Mencari",
                "lengthMenu": "Tampil _MENU_ entri",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection