<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Account | Tagihan Air</title>
</head>
<body>

    <!-- alert -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success custom-alert" id="alertBox">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger custom-alert" id="alertBox">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <h2>Daftar Akun Aplikasi</h2>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Status Online</th>
                <th>Terakhir Online</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($akun as $a): ?>
            <tr>
                <td><?= esc($a['username']) ?></td>
                <td><?= esc($a['email']) ?></td>
                <td><?= $a['is_online'] ? 'Online' : 'Offline' ?></td>
                <td><?= $a['last_online'] ?></td>
                <td>
                    <a href="/account_app/edit/<?= $a['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="/account_app/delete/<?= $a['id'] ?>" class="btn btn-hapus" onclick="return confirm('Yakin hapus akun ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>