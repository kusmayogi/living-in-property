<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
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
            <div class="picon profile" onclick="toggleDropdown()">
                <img src="{{ asset('frontend/assets/img/') }}" alt="">
                <div id="dropdownContent" class="dropdown-content">
                    <a href="#">Edit Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
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
    </section>
        <div class="main--content">
            <div class="overview">
                <div class="title">
                    <h2>Edit Absensi {{ $lokasi_proyek }}</h2>
                </div>
                <div class="container">
                    <form action="{{ route('absensi.search') }}" method="GET">
                        <input type="hidden" name="id_proyek" value="{{ $id_proyek }}">
                        <label for="tanggal">Pilih Tanggal:</label>
                        <select name="tanggal" id="tanggal">
                            @foreach ($daftarTanggal as $tanggal)
                                <option value="{{ $tanggal }}">{{ $tanggal }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Cari</button>
                    </form>
                    @if ($absensis->isEmpty())
                        <p>Tidak ada data absensi untuk tanggal ini.</p>
                    @else
                        <table id="result-table">
                            <thead>
                                <tr>
                                    <th>Nama Pekerja</th>
                                    <th>Status Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensis as $absensi)
                                    <tr>
                                        <td>{{ $absensi->pekerja->nama_pekerja }}</td>
                                        <td>{{ $absensi->status_absensi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
                <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
                <script>
                    document.getElementById('searchForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Mencegah formulir untuk memuat ulang halaman

                        var form = this;
                        var formData = new FormData(form);

                        // Kirim permintaan AJAX
                        fetch(form.action, {
                                method: form.method,
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                // Masukkan hasil dari AJAX ke dalam elemen dengan ID 'result-table'
                                document.getElementById('result-table').innerHTML = data;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                </script>

</body>

</html>
