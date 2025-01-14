<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Laporan Studio</h1>

    <!-- Tabel Laporan -->
    <h3>Periode Laporan</h3>
    <table>
        <thead>
            <tr>
                <th>Periode Laporan</th>
                <th>Total Pendapatan</th>
                <th>Jumlah Transaksi</th>
                <th>Jumlah Pembatalan</th>
                <th>Pendapatan Hilang</th>
                <th>Status Laporan</th>
            </tr>
        </thead>
        <tbody>
            @if (is_iterable($laporanPeriode) && count($laporanPeriode) > 0)
                @foreach ($laporanPeriode as $laporan)
                    <tr>
                        <td>{{ $laporan->periode ?? 'Tidak Tersedia' }}</td>
                        <td>Rp {{ number_format($laporan->total_pendapatan ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $laporan->jumlah_transaksi ?? 0 }}</td>
                        <td>{{ $laporan->jumlah_pembatalan ?? 0 }}</td>
                        <td>Rp {{ number_format($laporan->pendapatan_hilang ?? 0, 0, ',', '.') }}</td>
                        <td>{{ ($laporan->jumlah_pembatalan ?? 0) > 0 ? 'Gagal' : 'Sukses' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data laporan untuk periode ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Pendapatan Per Kelas -->
    <h3>Pendapatan Per Kelas</h3>
    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @if (is_iterable($pendapatanPerKelas) && count($pendapatanPerKelas) > 0)
                @foreach ($pendapatanPerKelas as $kelas)
                    <tr>
                        <td>{{ $kelas->kelas_name ?? 'Tidak Tersedia' }}</td>
                        <td>Rp {{ number_format($kelas->jadwals->sum('pembayarans_sum_payment_nominal') ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data pendapatan per kelas.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Rating dan Komentar Member -->
    <h3>Rating dan Komentar Member</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kelas</th>
                <th>Member</th>
                <th>Rating</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @if (is_iterable($reviews) && count($reviews) > 0)
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($review->review_date)->format('d-m-Y') }}</td>
                        <td>{{ $review->jadwal->kelas->kelas_name ?? 'Tidak Tersedia' }}</td>
                        <td>{{ $review->member->member_name ?? 'Tidak Tersedia' }}</td>
                        <td>{{ $review->review_rating ?? '-' }}</td>
                        <td>{{ $review->review_komen ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Belum ada rating dan komentar dari member.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tombol Cetak -->
    <button onclick="window.print()" class="btn btn-primary">Print</button>
</body>
</html>