<!DOCTYPE html>
<html>
<head>
    <title>Print Laporan Buku</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 10px; text-align: center; }
        h2 { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <h2>LAPORAN DATA BUKU PUSTAKAGO</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($buku as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b['isbn'] ?></td>
                <td><?= $b['judul'] ?></td>
                <td><?= $b['kategori'] ?></td>
                <td><?= $b['jumlah'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>