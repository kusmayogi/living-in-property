<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Mingguan</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styledashboard.css') }}">
</head>
<body>
    <div class="container">
        <h1>Rekap Absensi Mingguan</h1>
        <h3>Minggu ke-{{ $weekNumber }} Tahun {{ $year }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Pekerja</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                    <th>Total Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapAbsensi as $rekap)
                    <tr>
                        <td>{{ $rekap['nama_pekerja'] }}</td>
                        <td>{{ $rekap['senin'] }}</td>
                        <td>{{ $rekap['selasa'] }}</td>
                        <td>{{ $rekap['rabu'] }}</td>
                        <td>{{ $rekap['kamis'] }}</td>
                        <td>{{ $rekap['jumat'] }}</td>
                        <td>{{ $rekap['sabtu'] }}</td>
                        <td>{{ $rekap['total_poin'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
