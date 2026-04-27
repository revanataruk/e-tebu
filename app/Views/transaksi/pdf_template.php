<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #28a745; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #555; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi E-Tebu</h2>
    <div class="subtitle">Periode: <?= $musimAktif['nama_musim'] ?></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($transaksi as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                <td><?= $t['keterangan'] ?></td>
                <td><?= $t['nama_kategori'] ?></td>
                <td><?= $t['jenis_pembayaran'] ?></td>
                <td><?= $t['status_lunas'] == 1 ? 'Lunas' : 'Belum' ?></td>
                <td class="text-right">
                    <?= $t['tipe_akun'] == 'Pemasukan' ? '+' : '-' ?> <?= number_format($t['nominal'], 0, ',', '.') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>