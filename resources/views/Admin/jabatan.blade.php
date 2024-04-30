@extends('layouts.main')

@section('content')
<div class="container">
  <h3 style="color: green; margin-bottom: 5px;">Data Jabatan</h3>
  <div class="card mb-4">
    <div class="card-header" style="max-height: 35px; padding-top: 5px;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a href="/dashboard"
              style="font-size: 14px;">Home</a></li>
          </li>
          <li class="breadcrumb-item"><a href="/berkas" style="font-size: 14px;">Data Berkas</a>
          <li class="breadcrumb-item"><a href="{{ route('show-jbt', ['id' => $dataDosen->id]) }}"
              style="font-size: 14px;">Data Jabatan</a></li>
        </ol>
      </nav>
    </div>
  </div>
  @include('layouts.alert-flash-message')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              @if($dataDosen->foto_profil)
              <img class="profile-user-img img-fluid"
                style="margin-left: 17px; margin-top: 30px; border-radius: 50%; width: 150px; height: 150px; object-fit: cover; object-position: center top;"
                src="{{ asset('storage/foto_profil_dosen/' . $dataDosen->foto_profil) }}" alt="User profile picture">
              @else
              <img class="profile-user-img img-fluid img-circle" style="margin-left: 20px; margin-top: 30px;"
                src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="User profile picture">
              @endif
            </div>
            <h5 class="profile-username text-center">
              {{ $dataDosen->user->name }}
            </h5>

            <p class="text-muted text-center">Dosen</p>
            <div class="text-center">
              <ul class="list-group list-unbordered">
                <li class="list-group-item">
                  <a>{{ $dataDosen->nidn }}</a>
                </li>
                <li class="list-group-item">
                  <a style="font-size: 14px;">{{ $dataDosen->user->email }}</a>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-header ">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_jbt">+ Tambah
                  File</button>
              </li>
            </ul>
          </div>
          <div class="card-body" style="padding-top: 5px;">
            <div class="tab-content">
              <table class="table table-bordered align-middle" id="tabel-dosen">
                <thead class="table-light">
                  <tr>
                    <th scope="col" style="width: 8%; font-size: 12px;" class="text-center">No. Surat</th>
                    <th scope="col" style="width: 8%; font-size: 12px;" class="text-center">Nama Jabatan</th>
                    <th scope="col" style="width: 8%; font-size: 12px;" class="text-center">File</th>
                    <th scope="col" style="width: 8%; font-size: 12px;" class="text-center">Status</th>
                    <th scope="col" style="width: 15%; font-size: 12px;" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-group-divider">
                  @foreach ($dataJbt as $data)
                  <tr>
                    <td class="text-center">{{ $data->id}}</td>
                    <td class="text-center">{{ $data->nama_jabatan}}</td>
                    <td class="text-center"><i class="fas fa-file-pdf"></i> {{ Str::after($data->file, '_') }}</td>
                    <td class="text-center">
                      <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                    </td>
                    <td class="text-center d-flex justify-content-center">
                      <div class="row mt-2">
                        <div class="col">
                          <a href="{{ route('show-jbtt', ['id' => $data->id]) }}"
                            class="btn btn-primary btn-sm">Detail</a>
                        </div>
                        <div class="col">
                          <form action="{{route('delete_jbt', ['id' => $data->id])}}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </div>
                      </div>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="modal fade" id="tambah_jbt" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="{{ route('create_jbt', ['id' => $dataDosen->id]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
              <label for="id_jabatan" class="col-sm-2 col-form-label">No. Surat</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="id" id="id" placeholder="Nomer Surat Penugasan" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan"
                  required>
              </div>
            </div>
            <div class="form-group row">
              <label for="file" class="col-sm-2 col-form-label">File</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" accept=".pdf" name="file" id="file" placeholder="Piih File"
                  required>
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
    $('#tabel-dosen').DataTable({
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