@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data User</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/userss" style="font-size: 14px;">Data User</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_user">+ Tambah
                User</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center" id="tabel-serkom">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 10%; font-size: 12px;">NIDN</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Gender</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Tanggal Lahir</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Email</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Level</th>
                        <th scope="col" style="width: 12%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataUser as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nik }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->jenis_kelamin }}</td>
                        <td>{{ $data->tgl_lahir }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->roles->role_name }}</td>
                        <td class="d-flex justify-content-between">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit_user_{{ $data->id }}">Edit</button>
                            <form action="{{route('delete_user', ['id' => $data->id])}}" method="post">@csrf
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-container">
            </div>

        </div>

    </div>


    @foreach ($dataUser as $data)
    <div class="modal fade" id="edit_user_{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_data_user', ['id' => $data->id]) }}" class="form-horizontal"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK User"
                                        required value="{{$data->nik}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Nama User" value="{{$data->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ $data->jenis_kelamin == 'Laki-laki' ? 'selected' :
                                            '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ $data->jenis_kelamin == 'Perempuan' ? 'selected' :
                                            '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                        placeholder="Tanggal Lahir" value="{{$data->tgl_lahir}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                                        value="{{$data->email}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alamat" id="alamat"
                                        placeholder="Alamat Lengkap"
                                        value="{{$data->alamat}}">{{$data->alamat}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="password" id="password"
                                        placeholder="Ganti Password Baru *opsional">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Role" class="col-sm-2 col-form-label">Level *</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="role_id" id="role_id">
                                        <option selected>Pilih Level User</option>
                                        <option value="1" {{ $data->role_id == '1' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="2" {{ $data->role_id == '2' ? 'selected' : '' }}>Dosen
                                        </option>
                                    </select>
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
                    <form class="form-horizontal" action="{{ route('create_user') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK User"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama User"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki
                                    </option>
                                    <option value="Perempuan">Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                    placeholder="Tanggal Lahir" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="alamat" id="alamat"
                                    placeholder="Alamat Lengkap"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password" id="password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Role" class="col-sm-2 col-form-label">Level</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="role_id" id="role_id">
                                    <option selected>Pilih Level User</option>
                                    @foreach ($dataLevel as $data)
                                    <option value="{{ $data->id }}">{{ $data->role_name }}</option>
                                    @endforeach
                                </select>
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
        $('#tabel-serkom').DataTable({
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