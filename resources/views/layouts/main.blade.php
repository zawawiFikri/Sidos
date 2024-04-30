<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Si Data Dosen TE</title>
    <link rel="shortcut icon" href="{{ asset('images/503066270.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/simple-calendar/simple-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Add these lines to the head section -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.7/css/dataTables.bootstrap4.min.css">

    <!-- Add these lines just before the closing </body> tag -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.7/js/dataTables.bootstrap4.min.js"></script>

    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <script src="{{ asset('assets/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="#" class="logo">
                    <h4>SIDOS</h4>
                </a>
                <a href="#" class="logo logo-small">
                    <img src="{{ asset('images/503066270.png') }}" alt="Logo" width="30" height="30">
                </a>

            </div>
            <div class="menu-toggle">
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars"></i>
                </a>

            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            @if (auth()->user()->isDosen())
                            @if(auth()->user()->dosen->foto_profil)
                            <img class="rounded-circle"
                                src="{{ asset('storage/foto_profil_dosen/' . auth()->user()->dosen->foto_profil) }}"
                                width="31" alt="Nama" style="object-fit: cover; object-position: center top;">
                            @else
                            <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.png') }}"
                                width="31" alt="Nama">
                            @endif
                            @endif
                            @if (auth()->user()->isAdmin())
                            @if(auth()->user()->admin->foto_profil)
                            <img class="rounded-circle"
                                src="{{ asset('storage/foto_profil_admin/' . auth()->user()->admin->foto_profil) }}"
                                width="31" alt="Nama" style="object-fit: cover; object-position: center top;">
                            @else
                            <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.png') }}"
                                width="31" alt="Nama">
                            @endif
                            @endif
                            <div class="user-text">
                                <h6>
                                    <?php
                                    $nama = auth()->user()->name;
                                    echo $nama;
                                ?>
                                </h6>
                                <p class="text-muted mb-0">
                                    <?php
                                    $role = auth()->user()->role_id;
                                    if($role==1){
                                        echo "Admin";
                                    }else{
                                        echo "Dosen";
                                    };
                                ?>
                                </p>
                            </div>
                        </span>
                    </a>

                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                @if (auth()->user()->isDosen())
                                @if(auth()->user()->dosen->foto_profil)
                                <img src="{{ asset('storage/foto_profil_dosen/' . auth()->user()->dosen->foto_profil) }}"
                                    alt="Nama" class="avatar-img rounded-circle" style="object-position: center top;">
                                @else
                                <img src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="Nama"
                                    class="avatar-img rounded-circle">
                                @endif
                                @endif
                                @if (auth()->user()->isAdmin())
                                @if(auth()->user()->admin->foto_profil)
                                <img src="{{ asset('storage/foto_profil_admin/' . auth()->user()->admin->foto_profil) }}"
                                    alt="Nama" class="avatar-img rounded-circle" style="object-position: center top;">
                                @else
                                <img src="{{ asset('assets/img/profiles/avatar-01.png') }}" alt="Nama"
                                    class="avatar-img rounded-circle">
                                @endif
                                @endif
                            </div>
                            <div class="user-text">
                                <h6>
                                    <?php
                                    $nama = auth()->user()->name;
                                    echo $nama;
                                ?>
                                </h6>
                                <p class="text-muted mb-0">
                                    <?php
                                    $role = auth()->user()->role_id;
                                    if($role==1){
                                        echo "Admin";
                                    }else{
                                        echo "Dosen";
                                    };
                                ?>
                                </p>
                            </div>
                        </div>
                        @if (auth()->user()->isDosen())
                        <a class="dropdown-item {{ request()->routeIs('edit_profil') ? 'active' : '' }}"
                            href="/edit_profil">Edit Profil</a>
                        @endif
                        @if (auth()->user()->isAdmin())
                        <a class="dropdown-item {{ request()->routeIs('edit_profill') ? 'active' : '' }}"
                            href="/edit_profill">Edit Profil</a>
                        @endif
                        {{-- <form method="POST" action="{{ route('api.logout') }}" id="logout">
                            @csrf
                            <button></button>
                            <a class="dropdown-item" href="{{ route('api.logout') }}">Logout</a>
                        </form> --}}
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    @yield('content')
                </div>
            </div>
        </div>


    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/simple-calendar/jquery.simple-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/calander.js') }}"></script>
    <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('script')
</body>
<footer>
    <p>Copyright © 2023 SiDos</p>
</footer>

</html>