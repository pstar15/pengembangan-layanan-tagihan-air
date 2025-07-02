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
    <title>Edit Data Tagihan</title>
    <style>
        .container-edit-tagihan {
            width: 100%;
            margin-top: 80px;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        .form-tagihan {
            width: 100%;
        }
        .btn-updatetagihan{
            background-color: #2980b9;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .form-group input {
            margin-bottom: 0;
        }
        .logout:hover {
            color:rgb(255, 0, 0);
        }
    </style>
</head>
<body>

    <!--

        PR add SweetAlert button update

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
        <div class="container-edit-tagihan">
            <div class="form-tagihan">
                <h2>Edit Data Tagihan</h2>

                <form id="formUpdateTagihan" action="<?= base_url('/tagihan/update/' . $tagihan['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_pelanggan" value="<?= esc($tagihan['nama_pelanggan']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="<?= esc($tagihan['alamat']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label>No.Meter</label>
                        <input type="text" name="nomor_meter" value="<?= esc($tagihan['nomor_meter']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Meter</label>
                        <input type="number" name="jumlah_meter" value="<?= esc($tagihan['jumlah_meter']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label>Periode</label>
                        <input type="month" name="periode" value="<?= esc($tagihan['periode']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Tagihan</label>
                        <input type="number" name="jumlah_tagihan" value="<?= esc($tagihan['jumlah_tagihan']) ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label style="margin-bottom: 10px;">Status</label>
                        <select name="status">
                            <option value="Lunas" <?= $tagihan['status'] === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                            <option value="Belum Lunas" <?= $tagihan['status'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                            <option value="Tidak Ada" <?= $tagihan['status'] === 'Tidak Ada' ? 'selected' : '' ?>>Tidak Ada</option>
                        </select>
                    </div>

                    <button class="btn-updatetagihan" id="btnUpdatetagihan" type="submit">Update</button>
                </form>
                <a href="<?= base_url('/tagihan') ?>" class="btn-kembali">← Kembali ke Daftar Tagihan</a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/script.js') ?>" defer></script>
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('btnUpdatetagihan').addEventListener('click', function (e) {
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