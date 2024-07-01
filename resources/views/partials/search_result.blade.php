<!-- resources/views/partials/search_result.blade.php -->
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
                    <a href="/absensi" id="active--link">
                        <span class="icon icon-2"><i class="ri-bar-chart-grouped-line"></i></span>
                        <span class="sidebar--item">Absensi</span>
                    </a>
                </li>
                @guest
                @else
                    @if (auth()->user()->role === 'Admin')
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
                <div class="title">
                    <h2>Edit Absensi </h2>
                </div>
                <div class="container">
                    @if ($absensis->isEmpty())
                        <p>Tidak ada data absensi untuk tanggal ini.</p>
                    @else
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Pekerja</th>
                                <th>Tanggal</th>
                                <th>Status Absensi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensis as $absensi)
                            <tr>
                                <td>{{ $absensi->pekerja->nama_pekerja }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <form method="POST" action="/ubah-status-absensi/{{ $absensi->id_absensi }}">
                                        @method('PUT')
                                        @csrf
                                        <select name="new_status">
                                            @foreach (['Masuk', 'setengah hari', 'tidak masuk'] as $option)
                                                <option value="{{ $option }}" {{ $option === $absensi->status_absensi ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td><button type="submit">Ubah</button>
                                </form></td>
                            </tr>
                        @endforeach                        
                        </tbody>
                    </table>
                    
                    <script>
                        function ubahStatusAbsensi(idAbsensi) {
                            // Lakukan sesuatu dengan ID absensi yang dipilih, misalnya mengarahkan pengguna ke halaman ubah status absensi
                            window.location.href = '/ubah-status-absensi/' + idAbsensi;
                        }
                    </script>                                                  
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
