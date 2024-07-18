<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<section class="header">
    <div class="logo">
        <i class="ri-menu-line icon icon-0 menu"></i>
        <h2>Hallo <span>{{ auth()->user()->name }}!</span></h2>
    </div>
    <div class="search--notification--profile">
        <div class="">
            <!-- <input type="text" placeholder="Cari Pengajuan">
            <button> <i class="ri-search-2-line"></i></button> -->
        </div>
        <div class="notification--profile">
            <!-- <div class="picon bell">
                <i class="ri-notification-2-line"></i> -->
        </div>
        <div class="picon profile">
            <img src="{{ asset('frontend/assets/img/Watermark.png') }}" alt="Profile Picture" id="profilePic">
            <div class="dropdown-content" id="dropdown">
                <a href="{{ route('profile.edit') }}">Edit Profil</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="main">
    <div class="sidebar">
        <ul class="sidebar--items">
            @guest
            @else
                @if (auth()->user()->role === 'Master')
                    <li>
                        <a href="/dashboard">
                            <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                            <span class="sidebar--item">Dashboard</span>
                        </a>
                    </li>
                @endif
            @endguest
            @guest
            @else
                @if (auth()->user()->role === 'Master' ||
                        auth()->user()->role === 'Manajer' ||
                        auth()->user()->role === 'Admin' ||
                        auth()->user()->role === 'Pengawas')
                    <li>
                        <a href="/keuangan">
                            <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                            <span class="sidebar--item">Keuangan</span>
                        </a>
                    </li>
                @endif
            @endguest
            @guest
            @else
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                    <li>
                        <a href="/Data_pekerja">
                            <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                            <span class="sidebar--item">Data Pekerja</span>
                        </a>
                    </li>
                @endif
            @endguest
            @guest
            @else
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer' || auth()->user()->role === 'Pengawas')
                    <li>
                        <a href="/absensi">
                            <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                            <span class="sidebar--item">Absensi</span>
                        </a>
                    </li>
                @endif
            @endguest
            @guest
            @else
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                    <li>
                        <a href="/proyek">
                            <span class="icon icon-4"><i class="ri-database-line"></i></span>
                            <span class="sidebar--item" style="white-space: nowrap;">Proyek</span>
                        </a>
                    </li>
                @endif
            @endguest
            @guest
            @else
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer')
                    <li>
                        <a href="/users" id="active--link">
                            <span class="icon icon-4"><i class="ri-database-line"></i></span>
                            <span class="sidebar--item" style="white-space: nowrap;">Daftar Pegawai</span>
                        </a>
                    </li>
                @endif
            @endguest
        </ul>
        <ul class="sidebar--bottom-items">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="icon icon-4"> <i class="ri-login-box-line"></i></span>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </li>
        </ul>
    </div>
    <div class="main--content">
        <div class="overview">
            <div class="title">
                <!-- <h2 title="section--title">Formulir Pengajuan </h2> -->
                <div class="container">
                    <header>Daftar Akun Pegawai</header>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="column">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="column">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="" disabled>Select Role</option>
                                <option value="Master" {{ old('role') == 'Master' ? 'selected' : '' }}>Master</option>
                                <option value="Manajer" {{ old('role') == 'Manajer' ? 'selected' : '' }}>Manajer
                                </option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Pengawas" {{ old('role') == 'Pengawas' ? 'selected' : '' }}>Pengawas
                                </option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="column">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    value="{{ old('alamat') }}" required>
                            </div>
                            <div class="column">
                                <label for="no_telp">No Telpon</label>
                                <input type="text" name="no_telp" id="no_telp" class="form-control"
                                    value="{{ old('no_telp') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
        <script src="{{ asset('frontend/assets/js/formulir.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('btnSimpan').addEventListener('click', function() {
                // Lakukan proses penyimpanan data ke database di sini
                // Setelah proses berhasil, tampilkan notifikasi menggunakan SweetAlert

                // Contoh notifikasi menggunakan SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
        </body>

</html>