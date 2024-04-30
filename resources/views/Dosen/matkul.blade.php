@extends('layouts.main')

@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Pengajaran</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/dataAjar" style="font-size: 14px;">Data Pengajaran</a></li>
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
            <table class="table table-bordered" id="tabel-data">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama Matkul</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">SKS</th>
                        <th scope="col" style="width: 10%; font-size: 12px;">Tahun Ajar</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama Kelas</th>
                        <th scope="col" style="width: 20%; font-size: 12px;">File Nilai</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Status</th>
                        <th scope="col" style="width: 20%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataAjar as $data)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $data->matkul}}</td>
                        <td class="text-center"> {{ $data->sks}}</td>
                        <td> {{ $data->thn_ajar}}</td>
                        <td> {{ $data->kelas}}</td>
                        <td><i class="fas fa-file-pdf"></i> {{ Str::after($data->file, '_') }}</td>
                        <td class="text-center">
                            <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>
                            <a href="{{ route('view_pdf_dataAjar', ['id' => $data->id]) }}"
                                class="btn btn-primary btn-sm" target="_blank">View</a>
                            <a href="{{ route('download_pdf_dataAjar', ['id' => $data->id]) }}"
                                class="btn btn-danger btn-sm">Download</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                    <form class="form-horizontal" action="{{ route('create_dataAjar') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="Matkul" class="col-sm-2 col-form-label">Nama Matkul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="matkul" id="matkul" placeholder="Nama Matkul"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sks" class="col-sm-2 col-form-label">SKS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="sks" id="sks" placeholder="Jumlah SKS"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelas" class="col-sm-2 col-form-label">Nama Kelas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thn_ajar" class="col-sm-2 col-form-label">Tahun Ajar</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="thn_ajar" id="thn_ajar"
                                    placeholder="Tahun Ajar" required>
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
<script>
  $(document).ready(function () {
    $('#tabel-data').DataTable({
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