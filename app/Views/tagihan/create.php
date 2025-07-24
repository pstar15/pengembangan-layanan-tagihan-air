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
    <title>Tambah Data | Tagihan Air</title>
    <style>
        .container-create {
            width: 100%;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        .form-tagihan {
            width: 100%;
            margin-top: 80px;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        .logout:hover {
            color:rgb(255, 0, 0);
        }
    </style>
</head>
<body>

    <!--

        PR 

    -->

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

    <!-- navbar -->
    <div class="navbar">
        <span class="menu-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </span>
        <div class="nav-title">
            <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="copyright-bumdesa" class="nav-logo">
            <span oncontextmenu="return false;" class="navbar-title no-copy">Tagihan Air BUMDesa</span>
        </div>
        <div oncontextmenu="return false;" class="navbar-spacer no-copy">
            <?= session()->get('username'); ?>
        </div>
        <div class="profile-dropdown">
            <button class="profile-button" id="notifikasiBtn">
                <i class="bi bi-bell"></i>
                <?php if (!empty($notifikasi_baru) && $notifikasi_baru > 0): ?>
                    <span class="dot"></span>
                <?php endif; ?>
            </button>

            <div class="dropdown-menu notifikasi-dropdown">
                <div class="dropdown-header">
                    <strong>Notifikasi</strong>
                </div>

                <?php if (!empty($notifikasi)) : ?>
                    <?php foreach ($notifikasi as $notif) : ?>
                        <div class="dropdown-item">
                            <div class="notif-title"><?= esc($notif['judul']) ?></div>
                            <div class="notif-desc"><?= esc($notif['deskripsi']) ?></div>
                            <div class="notif-time"><?= date('d/m/Y H:i:s', strtotime($notif['waktu'])) ?></div>
                        </div>
                        <hr class="notif-divider">
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="dropdown-item text-muted">Tidak ada notifikasi</div>
                <?php endif; ?>

                <div class="dropdown-footer">
                    <a href="/notifikasi">Lihat semua</a>
                </div>
            </div>
        </div>
    </div>

    <!-- sidebar -->
    <div class="sidebar active" id="sidebar">
        <ul>
            <li>
                <a href="<?= base_url('auth/dashboard') ?>" class="sidebar-link">
                    <i class="bi bi-columns-gap" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('/tagihan') ?>" class="sidebar-link">
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
        <div class="container-create">
            <div class="form-tagihan">
                <div class="img-create-tagihan">
                    <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="logo-BUMDesa">
                </div>
                <h3 style="text-align: center; color: #000; margin-top: 20px;">Tambah Data Tagihan</h3>
                <hr>
                <form id="formAddTagihan" action="<?= base_url('/tagihan/store') ?>" method="post" style="margin-top: 20px;">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_pelanggan" value="<?= old('nama_pelanggan', $data['nama_pelanggan'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="<?= old('alamat', $data['alamat'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>No.Meter</label>
                        <input type="text" name="nomor_meter" value="<?= old('nomor_meter', $data['nomor_meter'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Meter</label>
                        <input type="number" name="jumlah_meter" pattern="\d{8}" maxlength="8" title="Harus 8 digit angka" value="<?= old('jumlah_meter', $data['jumlah_meter'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Periode</label>
                        <input type="month" name="periode" value="<?= old('periode', $data['periode'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Total Tagihan</label>
                        <input type="number" name="jumlah_tagihan" value="<?= old('jumlah_tagihan', $data['jumlah_tagihan'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" style="margin-top: 10px;">
                            <option value="Lunas" <?= (old('status', $data['status'] ?? '') == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                            <option value="Belum Lunas" <?= (old('status', $data['status'] ?? '') == 'Belum Lunas') ? 'selected' : '' ?>>Belum Lunas</option>
                            <option value="Tidak Ada" <?= (old('status', $data['status'] ?? '') == 'Tidak Ada') ? 'selected' : '' ?>>Tidak Ada</option>
                        </select>
                    </div>
                    <hr style="margin-top: 20px;">
                    <button type="submit" id="btnAddTagihan" class="btn-simpan">Simpan</button>
                </form>
                <a href="<?= base_url('/tagihan') ?>" class="btn-kembali">← Kembali ke Daftar Tagihan</a>
            </div>
        </div>
    </div>

    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('js/script.js') ?>" defer></script>

    <script>
        document.getElementById('btnAddTagihan').addEventListener('click', function(e) {
            e.preventDefault(); // Cegah submit form langsung

            Swal.fire({
                title: 'Yakin ingin menambahkan data tagihan?',
                text: "Pastikan data sudah benar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika konfirmasi OK
                    document.getElementById('formAddTagihan').submit();
                }
            });
        });
    </script>
</body>
</html>