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
    /* Dropdown Styles */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #fff;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        top: 100%;
        right: 0;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Additional styles for profile picture */
    .picon.profile {
        cursor: pointer;
        /* Change cursor to pointer on hover */
    }

    .picon.profile:hover .dropdown-content {
        display: block;
    }

    /*batas*/

    .charts-card {
        width: 100%;
        max-width: 980px;
        /* Atur lebar sesuai kebutuhan */
        height: 280px;
        /* Atur tinggi sesuai kebutuhan */
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profileDropdown = document.getElementById("profileDropdown");
            var dropdownContent = document.getElementById("dropdownContent");

            profileDropdown.addEventListener("click", function() {
                dropdownContent.classList.toggle("show");
            });

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('#profileDropdown')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        });
    </script>


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
                            <a href="/dashboard" id="active--link">
                                <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                                <span class="sidebar--item">Dashboard</span>
                            </a>
                        </li>
                    @endif
                @endguest
                @guest
                @else
                @if (auth()->user()->role === 'Master' || auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Pengawas')
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
                    </div>
                    <div class="card card-3">
                        <div class="card--data">
                            <div class="card--content">
                                <h5 class="card--title">Pendapatan</h5>
                                <h1>{{ number_format(\App\Http\Controllers\keuangancontroller::getTotalPemasukan(), 0, ',', '.') }}
                                </h1>
                            </div>
                        </div>
                        <div class="card--stats">
                            <span><i class=""></i></span>
                        </div>
                    </div>
                    <div class="card card-4">
                        <div class="card--data">
                            <div class="card--content">
                                <h5 class="card--title">Pengeluaran</h5>
                                <h1>{{ number_format(\App\Http\Controllers\keuangancontroller::getTotalPengeluaran(), 0, ',', '.') }}
                                </h1>
                            </div>
                        </div>
                        <div class="card--stats">
                            <span><i class=""></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="charts">

                <div class="charts-card">
                    <p class="chart-title">Grafik Keuangan</p>
                    <canvas id="myChart"></canvas>
                </div>
            </div>

    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="{{ asset('frontend/assets/js/dashboard.js') }}"></script>
    <script>
        function toggleDropdown() {
            console.log("Toggle dropdown called");
            var dropdown = document.getElementById("dropdownContent");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }


        window.onclick = function(event) {
            if (!event.target.matches('#profileDropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        }
    </script>

</body>

</html>
