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
                            <a href="/Data_pekerja" id="active--link">
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
                        <header>Tambah Data Pekerja</header>


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('Data_pekerja.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Nama Pekerja</label>
                                    <input type="text" id="nama_pekerja" class="form-control"
                                        placeholder="Nama Pekerja" name="nama_pekerja" value="{{ old('nama_pekerja') }}"
                                        required>
                                </div>
                                <div class="column">
                                    <label for="judul">Role</label>
                                    <select id="role" class="form-control" name="role" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="Kepala Tukang">Kepala Tukang</option>
                                        <option value="Tukang">Tukang</option>
                                        <option value="Kuli">Kuli</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Alamat</label>
                                    <input type="text" id="alamat" class="form-control" placeholder="Masukan Alamat"
                                        name="alamat" value="{{ old('alamat') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Upah</label>
                                    <input type="text" id="upah" class="form-control" placeholder="Upah"
                                        name="upah" value="{{ old('upah') }}" required>
                                </div>
                                <div class="column">
                                    <label for="id_proyek">Lokasi Proyek</label>
                                    <select id="id_proyek" class="form-control" name="id_proyek">
                                        <option value="" disabled selected>Select Project Location</option>
                                        @foreach ($allProyeks as $proyek)
                                            <option value="{{ $proyek->id_proyek }}">{{ $proyek->lokasi_proyek }}
                                            </option>
                                        @endforeach
                                    </select>
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
                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        const upahInput = document.getElementById('upah');
                    
                        upahInput.addEventListener('input', function(e) {
                            let value = this.value;
                            value = value.replace(/\D/g, ''); // Remove all non-digit characters
                            value = Number(value).toLocaleString('id-ID'); // Format number with thousand separator
                            this.value = value;
                        });
                    
                        const form = upahInput.closest('form');
                        form.addEventListener('submit', function(e) {
                            // Remove thousand separators before submitting
                            upahInput.value = upahInput.value.replace(/\./g, '');
                        });
                    });
                    </script>
                    

</body>

</html>
