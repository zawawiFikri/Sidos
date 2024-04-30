@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Dosen</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/dosen" style="font-size: 14px;">Data Dosen</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <h6>Tambahkan Data Sertifikat Dosen</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle" id="tabel-dosen">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;" class="text-center">No.</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Foto</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-center">Nama</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-center">Jabatan</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Gender</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Tanggal Lahir</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-center">Serdos</th>
                        <th scope="col" style="width: 12%; font-size: 12px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataDosen as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if($data->foto_profil)
                            <img src="{{ asset('storage/foto_profil_dosen/' . $data->foto_profil) }}" alt="Nama"
                                class="avatar-img rounded-circle" style="object-fit: cover; width: 70px; height: 70px;">
                            @else
                            <img src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="Nama"
                                class="avatar-img rounded-circle" style="object-fit: cover; width: 70px; height: 70px;">
                            @endif

                        </td>

                        <td class="text-center">{{ $data->user->name }}</td>
                        <td class="text-center">
                            @if ($data->jabatan->isNotEmpty())
                            @foreach ($data->jabatan as $jabatan)
                            {{ $jabatan->nama_jabatan }},
                            @endforeach
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center">{{ $data->user->jenis_kelamin }}</td>
                        <td class="text-center">{{ $data->user->tgl_lahir }}</td>
                        <td class="text-center">@if ($data->file)
                        
                            <a href="{{ route('view_pdf_serdos', ['id' => $data->id]) }}" target="_blank"><i class="fas fa-file-pdf"></i> {{
                                $data->serdos
                                }}.pdf</a>
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center d-flex justify-content-center">
                            <div class="col">
                                <div class="row mt-3">
                                    <div class="col">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit_dosen_{{ $data->id }}">Edit</button>
                                    </div>
                                    <div class="col">
                                        <form action="{{route('delete_dosen', ['id' => $data->id])}}" method="post">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @foreach ($dataDosen as $data)
    <div class="modal fade" id="edit_dosen_{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_data_dosen', ['id' => $data->id]) }}" class="form-horizontal"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nidn" id="nidn"
                                        placeholder="NIDN Dosen" required value="{{ $data->nidn }}">
                                </div>
                            </div>
                            @if($data->file)
                            <div class="form-group row">
                                <label for="file" class="col-sm-2 col-form-label">File Serdos</label>
                                <div class="col-sm-10">No.{{
                                    $data->serdos }}_
                                    <a href="{{ route('view_pdf_request', ['id' => $data->id]) }}" target="_blank">{{
                                        $data->file }}</a>
                                </div>
                            </div>                           
                            @endif
                            <div class="form-group row">
                                <label for="file" class="col-sm-2 col-form-label">Update File</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                        placeholder="Piih File">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="serdos" class="col-sm-2 col-form-label">No. Serdos</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="serdos" id="serdos"
                                        placeholder="Nomor Serdos" required value="{{  $data->serdos }}">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom:5px;">
                                <label for="foto_profil" class="col-sm-2 col-form-label">Foto Profil</label>
                                <div class="col-sm-10">
                                    @if($data->foto_profil)
                                    <img src="{{ asset('storage/foto_profil_dosen/' . $data->foto_profil) }}"
                                        alt="Foto Profil" class="img-fluid img-thumbnail"
                                        style="width: 80px; height: 100px;">
                                    @else
                                    <img src="{{ asset('assets/img/profiles/avatar-01.png') }}"
                                        alt="Default Foto Profil" class="img-fluid img-thumbnail">
                                    @endif
                                    <input type="file" class="form-control"
                                        style="margin-bottom:15px; margin-top: 20px;" name="foto_profil"
                                        id="foto_profil">
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
    @endforeach

    <div class="modal fade" id="tambah_user" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ url('create_data_dosen', ['id' => ':id']) }}" method="post"
                        enctype="multipart/form-data" id="createUserForm">
                        @csrf
                        <div class="form-group row">
                            <label for="nidn" class="col-sm-2 col-form-label">Nama Dosen</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="user_id" id="user_id" onchange="updateUserId()">
                                    <option value="0">-- Pilih Dosen --</option>
                                    @foreach ($dataDosen as $data)
                                    @if ($data->file === null)
                                    <option value="{{ $data->id }}">{{ $data->user->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nidn" id="nidn" placeholder="NIDN Dosen"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serdos" class="col-sm-2 col-form-label">No. Serdos</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="serdos" id="serdos"
                                    placeholder="Nomor Serdos" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto_profil" class="col-sm-2 col-form-label">Foto Profil</label>
                            <div class="col-sm-10">
                                <img src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="Default Foto Profil"
                                    class="img-fluid img-thumbnail">
                                <input type="file" class="form-control" style="margin-bottom:15px; margin-top: 20px;"
                                    name="foto_profil" id="foto_profil">
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
</div>
<script>
    
    function updateUserId() {
        var selectedUserId = document.getElementById("user_id").value;
        document.getElementById("createUserForm").action = "{{ url('create_data_dosen') }}/" + selectedUserId;
    }
    $(document).ready(function () {
        $('#tabel-dosen').DataTable({
            "paging": true,
            "pageLength": 3,
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