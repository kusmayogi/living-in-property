<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/berita.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
</head>
<style>
    .centered-card {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999; /* agar muncul di atas elemen lain */
    }

    .card {
        width: 300px;
        padding: 20px;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card h5 {
        margin-bottom: 10px;
    }

    .card p {
        margin-bottom: 20px;
    }

    .btn-primary {
        margin-top: 10px;
        margin-right: 10px;
        margin-bottom: 20px;
    }
</style>
<style>
    .btn-primary {
        margin-top: 10px;
        margin-right: 10px;
        margin-bottom: 20px;
    }
</style>
<body>
    <section class="header">
        <div class="logo">
            <i class="ri-menu-line icon icon-0 menu"></i>
            @if(auth()->check() && auth()->user())
                <h2>Hallo <span>{{ auth()->user()->name }}!</span></h2>
            @else
                <div class="centered-card">
                    <div class="card">
                        <h5>Session Expired</h5>
                        <p>Maaf, sesi Anda telah berakhir. Silakan login kembali.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    </div>
                </div>
            @endif
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
                    <img src="{{ asset('frontend/assets/img/Watermark.png') }}" alt="">
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
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
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
                            <a href="/absensi" id="active--link">
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
                            <a href="/users">
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
                    <h2 title="section--title">Absensi {{ $lokasi_proyek }}</h2>
                    <!-- Menambahkan elemen untuk tanggal -->
                    <div class="date-container">
                        <p>{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</p>
                    </div>
                </div>
                <div class="table">
                    <form action="/absensi/store" method="post">
                        @csrf
                        <input type="hidden" name="id_proyek" value="{{ $id_proyek }}">
                        <table id="absensiTable">
                            <thead>
                                <tr>
                                    <th>Nama Pekerja</th>
                                    <th>Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pekerja as $pegawai) 
                                    <tr class="absensi-row">
                                        <td>{{ $pegawai->nama_pekerja }}</td>
                                        <td>
                                            <input type="hidden" name="id_pekerja[]" value="{{ $pegawai->id_pekerja }}">
                                            <select name="status_absensi[]">
                                                <option value="Tidak Masuk">Tidak Masuk</option>
                                                <option value="Masuk">Masuk</option>
                                                <option value="Setengah Hari">Setengah Hari</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="button-section">
                            <button type="submit" class="btnSimpan" onclick="return confirm('PASTIKAN ABSENSI TELAH TERISI SESUAI DENGAN KEHADIRAN!')">Konfirmasi</button>
                            <a href="/report/{{ $id_proyek }}" class="ri-edit-line edit">Laporan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        });
    </script>
    @endif
    <style>.date-container {
        position: absolute;
        top: 0;
        right: 0;
        padding: 10px;
    }
    </style>
    <!-- Di bagian bawah halaman HTML -->
<script>
    // Ambil elemen tanggal
    const currentDateElement = document.getElementById('current-date');

    // Buat objek tanggal JavaScript baru
    const currentDate = new Date();

    // Ambil tanggal, bulan, dan tahun
    const date = currentDate.getDate();
    const month = currentDate.getMonth() + 1; // Penambahan 1 karena indeks bulan dimulai dari 0
    const year = currentDate.getFullYear();

    // Format tanggal sesuai kebutuhan Anda
    const formattedDate = `${date}/${month}/${year}`;

    // Tampilkan tanggal di dalam elemen tanggal
    currentDateElement.textContent = formattedDate;
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="{{ asset('frontend/assets/js/formulir.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
