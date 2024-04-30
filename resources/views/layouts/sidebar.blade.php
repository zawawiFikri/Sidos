@if (auth()->user()->isDosen())
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class = "{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-folder-plus"></i>
                        <span> Berkas</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="/serkom" class = "{{ request()->routeIs('serkom') ? 'active' : '' }}">Sertifikat Kompetensi</a></li>
                        <li><a href="/ijazah" class="{{ request()->routeIs('ijazah') ? 'active' : '' }}">Ijazah</a></li>
                        <li><a href="/matkul" class="{{ request()->routeIs('dataAjar') ? 'active' : '' }}">Matkul Diampu</a></li>
                    </ul>
                </li>
                <li class = "{{ request()->routeIs('jabatan') ? 'active' : '' }}">
                    <a href="/jabatan"><i class="fas fa-user-tie mr-1"></i> <span>Jabatan</span></a>
                </li>
                <li class = "{{ request()->routeIs('request') ? 'active' : '' }}">
                    <a href="/request"><i class="fas fa-comments"></i> <span>Request</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var currentPath = window.location.pathname;

        $('.submenu ul li').each(function () {
            var menuLink = $(this).find('a').attr('href');

            if (currentPath.includes(menuLink)) {
                $(this).addClass('open');
                $(this).parents('.submenu').addClass('open');
            }
        });
    });
</script>
@endif

@if (auth()->user()->isAdmin())
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class = "{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class = "{{ request()->routeIs('userss') ? 'active' : '' }}">
                    <a href="/userss"><i class="fas fa-user-tie mr-1"></i> <span>Data User</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-book"></i>
                        <span> Data Dosen</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="/dosen" class = "{{ request()->routeIs('dosen') ? 'active' : '' }}">Data Dosen</a></li>
                        <li><a href="/berkas" class="{{ request()->routeIs('berkas') ? 'active' : '' }}">Data Berkas</a></li>
                    </ul>
                </li>
                <li class = "{{ request()->routeIs('requests') ? 'active' : '' }}">
                    <a href="/requests"><i class="fas fa-comments"></i> <span>Request</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif

