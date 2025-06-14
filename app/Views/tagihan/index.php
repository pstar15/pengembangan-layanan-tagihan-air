<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Daftar Tagihan Air</title>
    <style>
        .container {
            width: 870px;
        }
        .table-container {
            margin: 0 auto;
            margin-top: 10px;
            width: 100%;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        h2 {
            position: absolute;
            text-align: left;
            margin-top: 75px;
            margin-left: 0;
            color: #000;
        }
        h5 {
            color: #a3a3a3;
            text-align: center;
        }
        .toolbar-wrapper {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
    </style>
</head>
<body>
    <!--

        PR css button search data,add, Pilih Status, and simpan data
        (PR button simpan konfirmasi data tagihan ke riwayat tagihan
        Tombol Kirim ke Android and dropdown notifikasi pesan tagihan lunas dari pengguna),
        di dalam halaman add data tagihan, form data tagihan harus terisi sebelum klik simpan
        (tambahkan autentikasi agar tidak terjadi kesalahan),

    -->
    <div class="navbar">
        <span class="menu-toggle" id="sidebarToggle">&#9776;</span>
        <h1 class="navbar-title">My App</h1>
        <div class="navbar-spacer">
            <?= session()->get('username'); ?>
        </div>
        <div class="profile-dropdown">
            <button class="profile-button">
                <i class="bi bi-gear"></i>
            </button>
            <div class="dropdown-menu">
                <a href="/account/setting">Setting</a>
                <a href="/logout" class="logout">Logout</a>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <ul>
            <li>
                <a href="<?= base_url('auth/dashboard') ?>" class="sidebar-link">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/tagihan" class="<?= uri_string() == 'tagihan' ? 'active' : '' ?>">
                    Tagihan
                </a>
            </li>

            <li>
                <a href="<?= base_url('riwayat-tagihan') ?>" class="sidebar-link">
                    Riwayat
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container">

            <!-- aleerts -->
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

            <h2>Daftar Tagihan Air</h2>

            <!-- 
            <form action="" method="post" style="display:inline;" onsubmit="return confirm('Kirim data ke aplikasi Android?')">
                <input type="hidden" name="id" value="">
                <button type="submit" class="btn btn-success">Kirim</button>
            </form>
            -->

            <form method="get" action="<?= base_url('tagihan') ?>" class="search-form">
                <input type="text" name="keyword" placeholder="Cari nama / nomor meter..." />
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="toolbar-wrapper">
                <div>
                    <button class="btn-addtagihan">
                        <a href="<?= base_url('/tagihan/create') ?>">
                            <i class="bi bi-calendar2-plus"></i>
                        </a>
                    </button>
                    <h5 style="position: absolute;margin-top: 1px;margin-left: 6px;">add</h5>
                </div>

                <form method="get" action="<?= base_url('tagihan') ?>" class="filter-form">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">
                            Menu
                        </option>
                        <option value="Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Lunas') ? 'selected' : '' ?>>
                            Lunas
                        </option>
                        <option value="Belum Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Belum Lunas') ? 'selected' : '' ?>>
                            Belum Lunas
                        </option>
                    </select>
                </form>

                <!-- cadangan
                -->
                <a href="<?= site_url('tagihan/simpan-semua') ?>" class="btn-simpandata" 
                    onclick="return confirm('Yakin ingin menyimpan semua tagihan ke riwayat?')"
                    class="btn btn-primary">
                    Simpan Semua ke Riwayat
                </a>
            </div>

            <!-- Tabel data tagihan -->
            <div class="table-container">
                <table border="1" cellpadding="10" cellspacing="0" width="100%" class="styled-table">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nomor Meter</th>
                            <th>Periode</th>
                            <th>Jumlah Tagihan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tagihan)) : ?>
                            <?php foreach ($tagihan as $row): ?>
                                <tr>
                                    <td><?= esc($row['nama_pelanggan']) ?></td>
                                    <td><?= esc($row['nomor_meter']) ?></td>
                                    <td><?= esc($row['periode']) ?></td>
                                    <td><?= esc($row['jumlah_tagihan']) ?></td>
                                    <td>
                                        <span class="badge <?= $row['status'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('tagihan/edit/' . $row['id']) ?>" class="btn btn-edit">Edit</a>
                                        <a href="<?= base_url('tagihan/delete/' . $row['id']) ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" style="text-align:center;">Data tidak tersedia</td></tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <h5>Data Tagihan Air</h5>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>
<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= session()->getFlashdata('success') ?>'
    });
</script>
<?php elseif (session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= session()->getFlashdata('error') ?>'
    });
</script>
<?php endif; ?>

</body>
</html>