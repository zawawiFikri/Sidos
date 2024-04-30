@extends('layouts.main')

@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Ijazah</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/ijazah" style="font-size: 14px;">Ijazah</a></li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_ijazah">+ Upload
                File</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="tabel-ijazah">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 10%; font-size: 12px;">ID Ijazah</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">File Ijazah</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama Institusi</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Program Studi</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Gelar</th>
                        <th scope="col" style="width: 13%; font-size: 12px;">Tanggal Lulus</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Status</th>
                        <th scope="col" style="width: 25%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataIjazah as $data)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $data->id}}</td>
                        <td><i class="fas fa-file-pdf"></i> {{ Str::after($data->file, '_') }}</td>
                        <td> {{ $data->institusi}}</td>
                        <td> {{ $data->program_study}}</td>
                        <td class="text-center"> {{ $data->gelar}}</td>
                        <td> {{ $data->tgl_lulus}}</td>
                        <td class="text-center">
                            <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>
                            <a href="{{ route('view_pdf_ijazah', ['id' => $data->id]) }}" class="btn btn-primary btn-sm"
                                target="_blank">View</a>
                            <a href="{{ route('download_pdf_ijazah', ['id' => $data->id]) }}"
                                class="btn btn-danger btn-sm">Download</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tambah_ijazah" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('create_ijazah') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="No_ijazah" class="col-sm-2 col-form-label">No. Ijazah</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id" id="id" placeholder="Nomer Ijazah"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="institusi" class="col-sm-2 col-form-label">Nama Institusi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="institusi" id="institusi"
                                    placeholder="Nama Institusi" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="program_study" class="col-sm-2 col-form-label">Program Study</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="program_study" id="program_study"
                                    placeholder="Nama Program Study" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gelar" class="col-sm-2 col-form-label">Gelar</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="gelar" id="gelar" placeholder="Nama Gelar"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_lulus" class="col-sm-2 col-form-label">Tanggal Lulus</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tgl_lulus" id="tgl_lulus" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File Ijazah</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File Ijazah" required>
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

<script>
    $(document).ready(function () {
        $('#tabel-ijazah').DataTable({
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