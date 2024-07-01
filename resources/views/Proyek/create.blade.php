<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/aspirasi.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
</head>
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
                <a href="/dashboard">
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
                        <a href="/proyek" id="active--link">
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
                   <!-- <h2 title="section--title">Formulir Pengajuan </h2> -->
                   <div class="container">
                    <header>Proyek Baru</header>
               
            
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
            
                    <form action="{{ route('proyek.store') }}" method="POST">
                        @csrf
                         <div class="row">
                             <div class="column">
                                 <label for="judul">Nama Pemilik</label>
                                 <input type="text" id="nama_pemilik" class="form-control" placeholder="Judul Berita"  name="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                             </div>
                             <div class="column">
                                <label for="judul">Lokasi Proyek</label>
                                <input type="text" id="lokasi_proyek" class="form-control" placeholder="Judul Berita"  name="lokasi_proyek" value="{{ old('lokasi_proyek') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <label for="tanggal_publikasi">Tanggal Dimulai</label>
                                <input type="datetime-local" class="form-control" id="tanggal_dimulai" placeholder="Tanggal Terbit"name="tanggal_dimulai" value="{{ old('tanggal_dimulai') }}" required>
                            </div>
                            <div class="column">
                                <label for="tanggal_publikasi">Tanggal Selesai</label>
                                <input type="datetime-local" class="form-control" id="tanggal_selesai" placeholder="Tanggal Terbit"name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" >
                            </div>
                        </div>
                             <div class="row">
                                    <div class="column">
                                        <label for="tanggal_publikasi">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            @isset($statusOptions)
                                                @foreach ($statusOptions as $statusOption)
                                                    <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>
                                                        {{ $statusOption }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>                                   
                                    </div>  
                                    <div class="column">
                                        <label for="judul">Nilai Proyek</label>
                                 <input type="text" id="nilai_proyek" class="form-control" placeholder="Judul Berita"  name="nilai_proyek" value="{{ old('nilai_proyek') }}" required>
                            
                                         </div>
                         </div>
                         <div class="row">
                            <div class="column">
                                <label for="judul">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" required>{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                             
                         <button type="submit" id="btnSimpan" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<script src="{{ asset('frontend/assets/js/formulir.js') }}"></script>
<script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnSimpan').addEventListener('click', function() {
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