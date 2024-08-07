<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/berita.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet" >
    <style>
        .btn-primary {
            margin-top: 10px;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        .centered-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
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
</head>

<body>
    <section class="header">
        <div class="logo">
            <i class="ri-menu-line icon icon-0 menu"></i>
            @if (auth()->check() && auth()->user())
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
        <div class="main--content">
            <div class="overview">
                <div class="title">
                    <h2 title="section--title">Absensi</h2>
                </div>
                <form id="absensiForm" action="{{ route('report.post', ['id_proyek' => $id_proyek]) }}" method="post">
                    @csrf
                    <input type="hidden" name="id_proyek" value="{{ $id_proyek }}">
                    <table id="absensiTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah Kasbon</th>
                                <th>Absensi</th>
                                <th>Gaji</th>
                                <th>Potongan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        @foreach ($pekerja ?? [] as $pegawai)
                            @if ($pegawai)
                                <tr class="absensi-row" data-pekerja="{{ $pegawai->id_pekerja }}">
                                    <td>{{ $pegawai->nama_pekerja }}</td>
                                    <td>
                                        {{ $pegawai->jumlah_kasbon ?? '' }}
                                        <input type="hidden" name="jumlah_kasbon[]" class="jumlah-kasbon" value="{{ $pegawai->jumlah_kasbon ?? '' }}">
                                    </td>
                                    <td class="absensi">
                                        <?php
                                        $idPekerja = $pegawai->id_pekerja;
                                        $totalKehadiran = DB::table('absensis')
                                            ->where('id_pekerja', $idPekerja)
                                            ->where('id_proyek', $id_proyek)
                                            ->sum(DB::raw('CASE WHEN status_absensi = "masuk" THEN 1 WHEN status_absensi = "setengah hari" THEN 0.5 ELSE 0 END'));
                                        echo "$totalKehadiran";
                                        ?>
                                    </td>
                                    <td class="gaji" data-gaji="{{ $pegawai->upah }}">
                                        <?php
                                        $upah = $pegawai->upah;
                                        $gajiTotal = $totalKehadiran * $upah;
                                        echo $gajiTotal;
                                        ?>
                                    </td>
                                    <td>
                                        @if ($pegawai->jumlah_kasbon != 0)
                                            <input type="text" name="potongan[]" class="potongan" data-pekerja="{{ $pegawai->id_pekerja }}" value="{{ old('potongan') !== null ? old('potongan') : '' }}">
                                        @endif
                                    </td>
                                    <td class="total-gaji"></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    <div class="button-container"></div>
                    <button type="submit" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Format angka dengan titik ribuan
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Fungsi untuk menghitung total gaji
            function hitungTotalGaji(row) {
                var totalKehadiran = parseFloat($(row).find('.absensi').text());
                var gajiPerHari = parseFloat($(row).find('.gaji').data('gaji'));
                var potongan = parseFloat($(row).find('.potongan').val().replace(/\./g, '')) || 0;

                var totalGaji = (totalKehadiran * gajiPerHari) - potongan;
                $(row).find('.total-gaji').text(formatNumber(totalGaji.toFixed(2)));
            }

            // Event listener untuk menghandle input pada potongan
            $('.potongan').on('input', function() {
                var inputVal = $(this).val().replace(/\./g, '');
                $(this).val(formatNumber(inputVal));
                hitungTotalGaji($(this).closest('tr'));
            });

            // Event listener untuk tombol submit
            $('#submitBtn').on('click', function(e) {
                e.preventDefault(); // Hindari default behavior dari tombol submit

                // Hitung total gaji sebelum mengirim formulir
                $('.absensi-row').each(function() {
                    hitungTotalGaji($(this));
                });

                // Kirim formulir
                $('#absensiForm').submit();
            });
        });
    </script>
</body>

</html>