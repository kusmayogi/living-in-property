<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PPID</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/berita.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
</head>
<style>
    .btn-primary {
        margin-top: 10px;
        /* Atur jarak atas */
        margin-right: 10px;
        /* Atur jarak kanan */
        margin-bottom: 20px;
        /* Atur jarak bawah */
        /* margin-left: auto;  */
        /* Atur jarak kiri */
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
                    @if (auth()->user()->role === 'Admin')
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
                    @if (auth()->user()->role === 'Admin')
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
                <!-- <h1>Edit Berita</h1> -->
                <div class="title">
                    <div class="container">
                        <header>Formulir Edit Data Proyek</header>

                        <form action="{{ route('proyek.update', $proyeks->id_proyek) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <form>
                                <div class="row">
                                    <div class="column">
                                        <label for="judul">Nama Pemilik</label>
                                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                            value="{{ $proyeks->nama_pemilik }}" required>
                                    </div>
                                    <div class="column">
                                        <label for="judul">Lokasi Proyek</label>
                                        <input type="text" class="form-control" id="lokasi_proyek"
                                            name="lokasi_proyek" value="{{ $proyeks->lokasi_proyek }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column">
                                        <label for="tanggal_dimulai">Tanggal Dimulai</label>
                                        <input type="text" class="form-control" id="tanggal_dimulai"
                                            name="tanggal_dimulai" value="{{ $proyeks->tanggal_dimulai }}" required>
                                    </div>
                                    <div class="column">
                                        <label for="judul">Nilai Proyek</label>
                                        <input type="text" class="form-control" id="nilai_proyek"
                                            name="nilai_proyek" value="{{ $proyeks->nilai_proyek }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column">
                                        <label for="tanggal_publikasi">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="" hidden>{{ $proyeks->status }}</option>
                                            <option value="Dimulai">Dimulai</option>
                                            <option value="Progress">Progress</option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="column">
                                        <label for="user_id">Pilih User</label>
                                        <select class="form-control" id="id" name="id" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $proyeks->id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column">
                                        <label for="isi_berita">keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" required>{{ $proyeks->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column">
                                        <button type="submit" id="btnSimpan" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                    </div>
                    </form>
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
