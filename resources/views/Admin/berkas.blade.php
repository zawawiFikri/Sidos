@extends('layouts.main')
@section('content')
<div class="container">
    <h3 style="color: green; margin-bottom: 5px;">Data Berkas</h3>
    <div class="card mb-4">
        <div class="card-header" style="max-height: 35px; padding-top: 5px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home" style="padding-right: 5px;"></i><a
                            href="/dashboard" style="font-size: 14px;">Home</a></li>
                    <li class="breadcrumb-item"><a href="/berkas" style="font-size: 14px;">Data Berkas</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert-flash-message')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle" id="tabel-dosen">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%; font-size: 12px;" class="text-center">No.</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Dosen</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Jabatan</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Lulusan</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Mengajar</th>
                        <th scope="col" style="width: 10%; font-size: 12px;" class="text-center">Keahlian</th>
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
                            <hr>
                            <label for="">{{ $data->user->name }}</label>

                        </td>
                        <td class="text-center">
                            @if ($data->jabatan->isNotEmpty())
                            @foreach ($data->jabatan as $jabatan)
                            {{ $jabatan->nama_jabatan }},
                            @endforeach
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($data->ijazah->isNotEmpty())
                            @foreach ($data->ijazah as $ijazah)
                            {{ $ijazah->program_study}},
                            @endforeach
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($data->data_ajar->isNotEmpty())
                            @foreach ($data->data_ajar as $data_ajar)
                            {{ $data_ajar->matkul}},
                            @endforeach
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($data->serkom->isNotEmpty())
                            @foreach ($data->serkom as $serkom)
                            {{ $serkom->bidang}},
                            @endforeach
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('show-serkom', ['id' => $data->id]) }}" class="btn btn-outline-primary btn-sm mb-2">Serkom</a>
                                    <a href="{{ route('show-ijasah', ['id' => $data->id]) }}" class="btn btn-outline-primary btn-sm">Ijazah</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('show-mata', ['id' => $data->id]) }}" class="btn btn-outline-primary btn-sm mb-2">Matkul</a>
                                    <a href="{{ route('show-jbt', ['id' => $data->id]) }}" class="btn btn-outline-primary btn-sm">Jabatan</a>
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
<script>
    $(document).ready(function () {
        $('#tabel-dosen').DataTable({
            "paging": true,
            "pageLength": 2,
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