<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit PPID</title>
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('Afrontend/assets/css/berita.css') }}">
     
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
</head>
<style>
    .btn-primary {
        margin-top: 10px; /* Atur jarak atas */
        margin-right: 10px; /* Atur jarak kanan */
        margin-bottom: 20px; /* Atur jarak bawah */
        /* margin-left: auto;  */
        /* Atur jarak kiri */
    }
</style>
<body><section class="header">
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
                <img src="{{ asset('frontend/assets/img/Watermark.png') }}" alt="">
            </div>
        </div>

</section>

 <section class="main">
    <div class="sidebar">
        <ul class="sidebar--items">  
            <li>
                <a href="/dashboard"  >
                    <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                    <span class="sidebar--item">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/gaji">
                    <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                    <span class="sidebar--item">Laporan Gaji</span>
                </a>
            </li>
            <li>
                <a href="/keuangan" id="active--link">
                    <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                    <span class="sidebar--item">Keuangan</span>
                </a>
            </li>
            <li>
                <a href="/Data_pekerja">
                    <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                    <span class="sidebar--item">Data Pekerja</span>
                </a>
            </li>
            <li>
                <a href="/absensi">
                    <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                    <span class="sidebar--item">Absensi</span>
                </a>
            </li>
            @guest
            @else
                @if(auth()->user()->role === 'Admin')
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
                @if(auth()->user()->role === 'Admin')
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
                    <div class="container">
                        <header>Formulir Edit Data Proyek</header>

                        <form action="{{ route('pemasukan.update', $pemasukan->id_pemasukan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php
                                dd($pemasukan);
                            @endphp

                            @if ($pemasukan)
                                <!-- Your form fields and HTML -->
                            @else
                                <p>Data Pemasukan tidak ditemukan</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    
            </section>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
            <script src="{{ asset('frontend/assets/js/formulir.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnSimpan').addEventListener('click', function() {
        // Lakukan proses penyimpanan data ke database di sini
        // Setelah proses berhasil, tampilkan notifikasi menggunakan SweetAlert

        // Contoh notifikasi menggunakan SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil di edit',
            showConfirmButton: false,
            timer: 1500
        });
    });
</script>
       </body>
       </html>