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
            width: 100%;
            margin-top: -10px;
        }
        .table-container {
            margin: 0 auto;
            margin-top: -37px;
            width: 100%;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        h2 {
            position: absolute;
            text-align: left;
            margin-top: 105px;
            margin-left: 0;
            color: #000;
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
        .filter-form {
            display: flex;
            position: inherit;
            justify-content: right;
            align-items: right;
            margin: 0 auto;
            margin-left: 240px;
            margin-bottom: 10px;
            margin-top: 80px;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        .no-copy {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        .logout:hover {
            color:rgb(255, 0, 0);
        }

    </style>
</head>
<body>
    <!--

        PR css button search data,add, Pilih Status, and simpan data
        (PR button simpan konfirmasi data tagihan ke riwayat tagihan
        Tombol Kirim ke aplikasi and dropdown notifikasi pesan tagihan dari pengguna),
        di dalam halaman add data tagihan, form data tagihan harus terisi sebelum klik simpan
        (tambahkan autentikasi agar tidak terjadi kesalahan),

    -->

    <div class="navbar">
        <span class="menu-toggle" id="sidebarToggle">&#9776;</span>
        <h1 oncontextmenu="return false;" class="navbar-title no-copy">Tagihan Air</h1>
        <div oncontextmenu="return false;" class="navbar-spacer no-copy">
            <?= session()->get('username'); ?>
        </div>
        <div class="profile-dropdown">
            <button class="profile-button">
                <i class="bi bi-bell"></i>
            </button>
            <div class="dropdown-menu">
                <a href="/account/setting">
                    <i class="bi bi-person-fill"></i>
                    <span style="margin-left: 10px;">Account</span>
                </a>
                <a href="/logout" class="logout">
                    <i class="bi bi-box-arrow-in-left"></i>
                    <span style="margin-left: 10px;">Logout</span>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar active" id="sidebar">
        <ul>
            <li>
                <a href="<?= base_url('auth/dashboard') ?>" class="sidebar-link">
                    <i class="bi bi-columns-gap" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="/tagihan" class="<?= uri_string() == 'tagihan' ? 'active' : '' ?>">
                    <i class="bi bi-droplet-half" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Tagihan</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('riwayat-tagihan') ?>" class="sidebar-link">
                    <i class="bi bi-graph-up" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Riwayat</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('account/setting') ?>" class="sidebar-link">
                    <i class="bi bi-gear" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Setting</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('logout') ?>" class="sidebar-link logout">
                    <i class="bi bi-box-arrow-in-left" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container">

            <h2>Daftar Tagihan Air</h2>

            <!-- 
            <form action="" method="post" style="display:inline;" onsubmit="return confirm('Kirim data ke aplikasi Android?')">
                <input type="hidden" name="id" value="">
                <button type="submit" class="btn btn-success">Kirim</button>
            </form>
            -->

            
            <div class="toolbar-wrapper">
                <div class="toolbar-left">
                    <div class="button-add-group">
                        <button class="btn-addtagihan">
                            <a href="<?= base_url('/tagihan/create') ?>">
                                <i class="bi bi-folder-plus"></i>
                            </a>
                        </button>
                        <h5 class="label-add-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Tambah Data Tagihan</h5>
                    </div>
                    
                    <form method="get" action="<?= base_url('tagihan') ?>" class="filter-form ">
                        <div class="Filter-Status">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">
                                    Opsi
                                </option>
                                <option value="Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Lunas') ? 'selected' : '' ?>>
                                    Lunas
                                </option>
                                <option value="Belum Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Belum Lunas') ? 'selected' : '' ?>>
                                    Belum Lunas
                                </option>
                            </select>
                            <h5 class="label-Fstatus-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Filter Status</h5>
                        </div>
                    </form>
                    
                    <!-- cadangan-->
                    <div class="btn-simpandata">
                        <a href="<?= site_url('tagihan/simpan-semua') ?>"
                            onclick="return confirm('Yakin ingin menyimpan semua tagihan ke riwayat?')"
                            class="btn-simpan-tagihan btn btn-primary" style="color: #fff;">
                            Simpan Semua ke Riwayat
                        </a>
                    </div>

                    <div class="toolbar-rihght">
                        <form method="get" action="<?= base_url('tagihan') ?>" id="filterForm" class="search-form">
                            <div class="form-search">
                                <input type="text" id="keywordInput" name="keyword" placeholder="Cari nama / nomor meter..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                                <h5 class="label-FSearch-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Ketik Nama/Nomor Meter</h5>
                            </div>
                            <div class="button-search">
                                <button type="submit" id="filterBtn">
                                    <i class="bi bi-search" id="filterIcon"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel data tagihan -->
            <div id="resultContainer" class="table-container">
                <table border="1" cellpadding="10" cellspacing="0" width="100%" class="table styled-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No.Meter</th>
                            <th>Jumlah Meter</th>
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
                                    <td class="nama-col"><?= esc($row['nama_pelanggan']) ?></td>
                                    <td class="alamat-col"><?= esc($row['alamat']) ?></td>
                                    <td><?= esc($row['nomor_meter']) ?></td>
                                    <td><?= esc($row['jumlah_meter']) ?></td>
                                    <td><?= esc($row['periode']) ?></td>
                                    <td><?= esc($row['jumlah_tagihan']) ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Lunas'): ?>
                                            <span class="badge badge-success">Lunas</span>
                                        <?php elseif ($row['status'] == 'Belum Lunas'): ?>
                                            <span class="badge badge-warning">Belum Lunas</span>
                                        <?php elseif ($row['status'] == 'Tidak Ada' || empty($row['status'])): ?>
                                            <span class="badge badge-secondary">Tidak Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('tagihan/edit/' . $row['id']) ?>" class="btn btn-edit">Edit</a>
                                        <a href="<?= base_url('tagihan/delete/' . $row['id']) ?>" id="btnhapus" class="btn btn-delete">Hapus</a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script>
    document.getElementById('btnhapus').addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah submit otomatis

            Swal.fire({
                title: 'Yakin ingin menyimpan data ini?',
                text: "Pastikan data sudah sesuai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form secara manual setelah konfirmasi
                    document.getElementById('formUpdateTagihan').submit();
                }
            });
        });
</script>

</body>
</html>