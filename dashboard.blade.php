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
<style>
    .charts-card {
        width: 100%;
        max-width: 980px; /* Atur lebar sesuai kebutuhan */
        height: 280px; /* Atur tinggi sesuai kebutuhan */
        background-color: #f0f0f0;
        /* border: 1px solid #ccc; */
        border-radius: 5px;
        /* padding: 10px; */
    }
    .charts {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    #myChart {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
<body>

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
                    <img src="{{ asset('frontend/assets/img/Watermark.png') }}" alt="">
                </div>
            </div>

    </section>

     <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">  
                <li>
                    <a href="/dashboard"  id="active--link">
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
                    <a href="/keuangan">
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
                   <h2 title="section--title">Dashboard</h2>
                </div>
                <div class="cards">
                  <div class="card card-1">
                    <div class="card--data">
                        <div class="card--content">
                            <h5 class="card--title">Proyek On Progress</h5>
                            <h1>{{ $jumlahProyekOnProgress }}</h1>
                        </div>
                    </div>
                    <div class="card--stats">
                        <span><i class=""></i></span>
                    </div>
                  </div>
                  <div class="card card-2">
                    <div class="card--data">
                        <div class="card--content">
                            <h5 class="card--title">Jumlah Pekerja</h5>
                            <h1>{{ $jumlahPekerja }}</h1>
                        </div>
                        <i class="ri-bar-chart-fill card--icon--lg"></i>
                    </div>
                    <div class="card--stats">
                        <span><i class=""></i></span>
                    </div>
                  </div><div class="card card-3">
                    <div class="card--data">
                        <div class="card--content">
                            <h5 class="card--title">Pendapatan</h5>
                            <h1>{{ number_format(\App\Http\Controllers\keuangancontroller::getTotalPemasukan(), 0, ',', '.') }}</h1>
                        </div>
                    </div>
                    <div class="card--stats">
                        <span><i class=""></i></span>
                    </div>
                  </div><div class="card card-4">
                    <div class="card--data">
                        <div class="card--content">
                            <h5 class="card--title">Pengeluaran</h5>
                            <h1>{{ number_format(\App\Http\Controllers\keuangancontroller::getTotalPengeluaran(), 0, ',', '.') }}</h1>
                        </div>
                    </div>
                    <div class="card--stats">
                        <span><i class=""></i></span>
                    </div>
                  </div>
                </div>
            </div>
            <div class="charts">

                <div class="charts-card" >
                  <p class="chart-title">Grafik Keuangan</p>
                  <canvas id="myChart"  ></canvas>
                </div>
        </div>
           
        </section>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
     <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
</body>
</html>