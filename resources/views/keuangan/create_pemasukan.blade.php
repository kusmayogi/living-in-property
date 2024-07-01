<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/berita.css') }}">
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
                    @if (auth()->user()->role === 'Master' ||
                            auth()->user()->role === 'Manajer' ||
                            auth()->user()->role === 'Admin' ||
                            auth()->user()->role === 'Pengawas')
                        <li>
                            <a href="/keuangan" id="active--link">
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
                        <header>Pemasukan Baru</header>


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pemasukan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Nama Pembeli</label>
                                    <input type="text" id="nama_pembeli" class="form-control"
                                        placeholder="nama pembeli" name="nama_pembeli" value="{{ old('nama_pembeli') }}"
                                        required>
                                </div>
                                <div class="column">
                                    <label for="judul">Nominal</label>
                                    <input type="text" id="nominal" class="form-control"
                                        placeholder="Masukan Nominal Pembayaran" name="nominal"
                                        value="{{ old('nominal') }}" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Metode Pembayaran</label>
                                    <select id="metode_pembayaran" class="form-control" name="metode_pembayaran"
                                        required>
                                        <option value="" disabled selected>pilih metode pembayaran</option>
                                        <option value="cash"
                                            {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_bri' ? 'selected' : '' }}>Transfer
                                            BRI</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_mandiri' ? 'selected' : '' }}>
                                            Transfer Mandiri</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_bsi' ? 'selected' : '' }}>Transfer
                                            BSI</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_bca' ? 'selected' : '' }}>Transfer
                                            BCA</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_bni' ? 'selected' : '' }}>Transfer
                                            BNI</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_bank_jatim' ? 'selected' : '' }}>
                                            Transfer Bank Jatim</option>
                                        <option value="transfer"
                                            {{ old('metode_pembayaran') == 'transfer_btpn' ? 'selected' : '' }}>
                                            Transfer BTPN</option>
                                    </select>
                                </div>
                                <div class="column">
                                    <label for="tanggal_publikasi">Tanggal</label>
                                    <input type="datetime-local" class="form-control" id="tanggal_pembayaran"
                                        name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Lokasi</label>
                                    <input type="text" id="lokasi" class="form-control"
                                        placeholder="masukan jumlah pemasukan" name="lokasi"
                                        value="{{ old('lokasi') }}" required>
                                </div>
                                <div class="column">
                                    <label for="tanggal_publikasi">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan"
                                        placeholder="isikan keterangan" name="keterangan"
                                        value="{{ old('keterangan') }}" required>
                                </div>


                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="judul">Tujuan</label>
                                    <select id="tujuan_transfer" class="form-control" name="tujuan_transfer"
                                        required>
                                        <option value="" disabled selected>Isikan Tujuan</option>
                                        <option value="Teguh"
                                            {{ old('tujuan_transfer') == 'Teguh' ? 'selected' : '' }}>Teguh</option>
                                        <option value="Hj.kastinah"
                                            {{ old('tujuan_transfer') == 'Hj.kastinah' ? 'selected' : '' }}>Hj.kastinah
                                        </option>
                                        <option value="Sutrisno"
                                            {{ old('tujuan_transfer') == 'Sutrisno' ? 'selected' : '' }}>Sutrisno
                                        </option>
                                        <option value="Ilham"
                                            {{ old('tujuan_transfer') == 'Ilham' ? 'selected' : '' }}>Ilham</option>
                                        <option value="Ivan"
                                            {{ old('tujuan_transfer') == 'Ivan' ? 'selected' : '' }}>Ivan</option>
                                        <option value="Lainya"
                                            {{ old('tujuan_transfer') == 'Lainya' ? 'selected' : '' }}>Lainya</option>
                                </div>

                            </div>
                            <div class="row">

                            </div>
                            <!-- ... -->
                            <div class="form-foto">
                                <label for="foto" class="form-label">Foto</label>

                                @if ($pemasukans->foto ?? null)
                                    <img id="previewImage"
                                        src="{{ url('storage/app/public/foto_pemasukan/' . $pemasukans->foto) }}"
                                        alt="{{ $pemasukans->foto }}" style="max-width: 300px; max-height: 300px;">
                                @else
                                    <img id="previewImage"
                                        style="max-width: 300px; max-height: 300px; display: none;">
                                @endif

                                <input type="file" id="foto" name="foto" onchange="previewFile()"
                                    accept="image/*">

                                <script>
                                    function previewFile() {
                                        var input = document.getElementById('foto');
                                        var preview = document.getElementById('previewImage');

                                        var reader = new FileReader();

                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                        };

                                        if (input.files.length > 0) {
                                            reader.readAsDataURL(input.files[0]);
                                        } else {
                                            preview.style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                            <!-- ... -->



                            <div>
                                <button type="submit" id="btnSimpan" class="btn btn-primary">Simpan</button>
                            </div>
                    </div>
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
