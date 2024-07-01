<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
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
                <input type="text" id="searchInput" placeholder="Cari...">
                <button id="searchBtn"> <i class="ri-search-2-line"></i></button>
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
                    <h2 title="section--title">Tabel Data Proyek </h2>
                </div>
                <a href="{{ route('proyek.create') }}" class="ri-edit-line edit">Proyek Baru</a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Lokasi</th>
                                <th>Nama Pemilik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proyeks as $index => $proyek)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $proyek->lokasi_proyek }}</td>
                                    <td>{{ $proyek->nama_pemilik }}</td>
                                    <td>{{ $proyek->status }}</td>
                                    <td>
                                        <div class="button-container">
                                            <a href="{{ route('proyek.edit', $proyek->id_proyek) }}"
                                                class="ri-edit-line edit">Edit</a>
                                        </div>
                                        <div class="button-container">
                                            <form action="{{ route('proyek.destroy', $proyek->id_proyek) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ri-delete-bin-line delete"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data proyek ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const tableRows = document.querySelectorAll('tbody tr');

            searchBtn.addEventListener('click', function() {
                const searchTerm = searchInput.value.toLowerCase();

                tableRows.forEach(function(row) {
                    const namaPemilik = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();
                    const lokasi = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const status = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                    if (
                        namaPemilik.includes(searchTerm) ||
                        lokasi.includes(searchTerm) ||
                        status.includes(searchTerm)
                    ) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
</body>

</html>
