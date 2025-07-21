<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Accout App | Tagihan Air</title>
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

    <h2>Edit Akun</h2>

    <form method="post" action="/account_app/update/<?= $akun['id'] ?>">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= esc($akun['username']) ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= esc($akun['email']) ?>"><br><br>

        <label>Status Online:</label><br>
        <select name="is_online">
            <option value="1" <?= $akun['is_online'] ? 'selected' : '' ?>>Online</option>
            <option value="0" <?= !$akun['is_online'] ? 'selected' : '' ?>>Offline</option>
        </select><br><br>

        <label>Password Lama:</label><br>
        <input type="password" name="password_lama"><br><br>

        <label>Password Baru:</label><br>
        <input type="password" name="password_baru"><br><br>

        <label>Konfirmasi Password Baru:</label><br>
        <input type="password" name="konfirmasi_password"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>