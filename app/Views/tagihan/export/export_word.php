<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Word | Tagihan Air BUMDesa</title>
</head>
<body>
    <h2>Data Tagihan</h2>
    <div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No.Meter</th>
                    <th>Jumlah Meter</th>
                    <th>Periode</th>
                    <th>Total Tagihan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($row['nama_pelanggan']) ?></td>
                        <td><?= esc($row['alamat']) ?></td>
                        <td><?= esc($row['nomor_meter']) ?></td>
                        <td><?= esc($row['jumlah_meter']) ?></td>
                        <td><?= esc($row['periode']) ?></td>
                        <td><?= esc($row['jumlah_tagihan']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>