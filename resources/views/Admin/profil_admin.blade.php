@extends('layouts.main')

@section('content')
@include('layouts.alert-flash-message')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            @if($admin->foto_profil)
            <img class="profile-user-img img-fluid"
              style="margin-left: 17px; margin-top: 30px; border-radius: 50%; width: 150px; height: 150px; object-fit: cover; object-position: center top;"
              src="{{ asset('storage/foto_profil_admin/' . $admin->foto_profil) }}" alt="User profile picture">
            @else
            <img class="profile-user-img img-fluid img-circle" style="margin-left: 20px; margin-top: 30px;"
              src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="User profile picture">
            @endif
          </div>
          <h5 class="profile-username text-center">
            <?php
                            $nama = auth()->user()->name;
                            echo $nama;
                        ?>
          </h5>

          <p class="text-muted text-center">Admin</p>
          <div class="text-center">
            <ul class="list-group list-unbordered mb-3">
              <li class="list-group-item">
                <a>{{ $admin->nidn }}</a>
              </li>
              <li class="list-group-item">
                <a style="font-size: 14px;">{{ $user->email }}</a>
              </li>
            </ul>
            <button class="btn btn-outline-primary btn-block" data-bs-toggle="modal" data-bs-target="#editfoto">Ganti
              Foto</button>
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
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editdata">Edit
                Profil</button>
            </li>
          </ul>
        </div>
        <div class="card-body" style="padding-top: 5px;">
          <div class="tab-content">

            <!-- /.tab-pane -->
            <div class="active tab-pane">
              <form class="form-horizontal">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="form-group row">
                  <label for="NIDN" class="col-sm-2 col-form-label">NIDN</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nidn" placeholder="NIDN" value="{{ $admin->nidn }}"
                      disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="Nama Lengkap"
                      value="{{ $user->name }}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-10">
                    <select class="form-select" disabled>
                      <option selected disabled>Pilih Jenis Kelamin</option>
                      <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                      </option>
                      <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="tgl_lahir" placeholder="Tanggal Lahir"
                      value="{{ $user->tgl_lahir }}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="alamat" placeholder="Alamat Lengkap"
                      disabled>{{ $user->alamat }}</textarea>
                  </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- tab-modal-edit -->
    <div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="POST"
              action="{{ route('update_profil_admin', ['user' => $user->id]) }}">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="form-group row">
                <label for="NIDN" class="col-sm-2 col-form-label">NIDN</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nidn" id="nidn" placeholder="NIDN"
                    value="{{ $admin->nidn }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap"
                    value="{{ $user->name }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                  <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir"
                    value="{{ $user->tgl_lahir }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="alamat" id="alamat"
                    placeholder="Alamat Lengkap">{{ $user->alamat }}</textarea>
                </div>
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- tab-modal-edit-foto -->
    <div class="modal fade" id="editfoto" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Foto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="POST" action="{{ route('update_fotoo') }}"
              enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="form-group row" style="margin-bottom:5px;">
                <label for="foto_profil" class="col-sm-2 col-form-label">Foto Profil</label>
                <div class="col-sm-10">
                  @if($admin->foto_profil)
                  <img src="{{ asset('storage/foto_profil_admin/' . $admin->foto_profil) }}" alt="Foto Profil"
                    class="img-fluid img-thumbnail" style="max-width: 40%; max-height: 40%;">
                  @else
                  <img src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="Default Foto Profil"
                    class="img-fluid img-thumbnail">
                  @endif
                  <input type="file" class="form-control" style="margin-bottom:15px; margin-top: 20px;"
                    name="foto_profil" id="foto_profil">
                  <a style="color: red; opacity: 0.6;">*Tolong Upload Foto dengan format formal</a>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection