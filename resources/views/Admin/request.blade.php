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
        <div class="card-body">
            <table class="table table-bordered" id="tabel-request">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%; font-size: 12px;">No.</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Nama Dosen</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Jenis Request</th>
                        <th scope="col" style="width: 15%; font-size: 12px;">Tanggal Request</th>
                        <th class="text-center" scope="col" style="width: 5%; font-size: 12px;">Status</th>
                        <th scope="col" style="width: 3%; font-size: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dataRequest as $data)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration }}</td>
                        <td> {{ $data->dosen->user->name }}</td>
                        <td> {{ $data->jenis_req }}</td>
                        <td> {{ $data->created_at }}</td>
                        <td class="text-center">
                            <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#view_request_{{ $data->id }}">Detail</button>
                                <form action="{{ route('delete_req', ['id' => $data->id]) }}" method="post">@csrf
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

    @foreach ($dataRequest as $data)
    <div class="modal fade" id="view_request_{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('check_requests', ['id' => $data->id]) }}" method="post">
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
                                <a href="{{ route('view_pdf_requests', ['id' => $data->id]) }}" target="_blank">{{
                                    $data->file }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-success" name="submit">Checklist</button>
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