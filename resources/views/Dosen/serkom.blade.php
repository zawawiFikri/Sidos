@extends('layouts.main')

@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Sertifikat Kompetensi</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/serkom" style="font-size: 14px;">Sertifikat Kompetensi</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah_serkom">+ Upload
                File</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="tabel-serkom">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 10%; font-size: 12px;">No. Serkom</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Judul File</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Bidang Kompetensi</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Penerbit</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Tanggal Terbit</th>
                        <th scope="col" style="width: 5%; font-size: 12px;">Status</th>
                        <th scope="col" style="width: 20%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataSerkom as $data)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $data->id}}</td>
                        <td><i class="fas fa-file-pdf"></i> {{ Str::after($data->file, '_') }}</td>
                        <td> {{ $data->bidang }}</td>
                        <td> {{ $data->penerbit }}</td>
                        <td> {{ $data->tgl_terbit }}</td>
                        <td class="text-center">
                            <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>
                            <a href="{{ route('view_pdf_serkom', ['id' => $data->id]) }}" class="btn btn-primary btn-sm"
                                target="_blank">View</a>
                            <a href="{{ route('download_pdf_serkom', ['id' => $data->id]) }}"
                                class="btn btn-danger btn-sm">Download</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tambah_serkom" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('create_serkom') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="No_serkom" class="col-sm-2 col-form-label">No. Serkom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id" id="id"
                                    placeholder="Nomer Sertifikat Kompetensi" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bidang" class="col-sm-2 col-form-label">Bidang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bidang" id="bidang"
                                    placeholder="Bidang keahlian" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="penerbit" id="penerbit"
                                    placeholder="Lembaga Penerbit" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_terbit" class="col-sm-2 col-form-label">Tanggal Terbit</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit"
                                    placeholder="Tanggal Terbit Sertifikat" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File Serkom</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".pdf" name="file" id="file"
                                    placeholder="Piih File Serkom" required>
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