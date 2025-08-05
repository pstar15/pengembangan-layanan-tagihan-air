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
    <link rel="stylesheet" href="<?= base_url('css/table_tagihan.css') ?>">
    <title>Tagihan | Tagihan Air</title>
    <style>
        .container {
            width: 100%;
            margin-top: 60px;
        }
        h2 {
            position: absolute;
            text-align: left;
            margin-top: 18px;
            margin-left: 0;
            color: #000;
            user-select: none;
            white-space: nowrap;
        }
        .no-copy {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .akun-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .akun-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-size: 14px;
            gap: 10px;
        }

        .akun-text {
            flex: 1;
            text-align: left;
            word-break: break-word;
        }

        .akun-checkbox {
            width: 10px;
            height: 10px;
        }

        #list-akun {
            padding-bottom: 15px;
        }

        /* Tombol SweetAlert rapi */
        .swal2-html-container button {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
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
            <div class="toolbar-wrapper">
                <div class="toolbar-buttons">

                    <!-- Tombol Tambah -->
                    <div class="button-add-group">
                        <a href="<?= base_url('/tagihan/create') ?>" class="btn-addtagihan">
                            <i class="bi bi-plus" style="font-size: 1rem;"></i>
                            <span style="font-size: 12px;">Add</span>
                        </a>
                        <div class="label-add-hover">Tambah Data</div>
                    </div>

                    <!-- Tombol Export Opsi -->
                    <div class="export-menu-wrapper">
                        <button class="btn-export-custom" onclick="toggleExportMenu()">
                            Export &nbsp<i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="export-menu" id="exportMenu">
                            <a href="<?= base_url('tagihan/exportExcel') ?>"><i class="bi bi-file-earmark-excel"></i> Export ke Excel</a>
                            <a href="<?= base_url('tagihan/exportWord') ?>"><i class="bi bi-file-earmark-word"></i> Export ke Word</a>
                            <a href="<?= base_url('tagihan/exportPDF') ?>" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Export ke PDF</a>
                        </div>
                        <div class="label-export-hover">Export Data</div>
                    </div>

                    <form method="get" action="<?= base_url('tagihan') ?>" class="filter-form">
                        <div class="Filter-Status">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Pilih Status</option>
                                <option value="Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                                <option value="Belum Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Belum Lunas') ? 'selected' : '' ?>>Belum Lunas</option>
                            </select>
                            <div class="label-Fstatus-hover">Filter Status</div>
                        </div>
                    </form>

                    <form method="get" action="<?= base_url('tagihan') ?>" id="filterForm" class="search-form">
                        <div class="form-search">
                            <input type="text" id="keywordInput" name="keyword" placeholder="Cari nama / nomor meter..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                            <div class="label-FSearch-hover">Ketik Nama/Nomor Meter</div>
                        </div>
                        <div class="button-search">
                            <button type="submit" id="filterBtn">
                                <i class="bi bi-search" id="filterIcon"></i>
                            </button>
                            <div class="label-cari-hover">Cari</div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="resultContainer" class="table-container">
                <table border="1" cellpadding="10" cellspacing="0" width="100%" class="tagihan-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No.Meter</th>
                            <th>Jumlah Meter</th>
                            <th>Periode</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tagihan)) : ?>
                            <?php foreach ($tagihan as $row): ?>
                                <tr>
                                    <td class="nama-tagiihan"><?= esc($row['nama_pelanggan']) ?></td>
                                    <td class="alamat-tagiihan"><?= esc($row['alamat']) ?></td>
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
                                        <div class="action-buttons">
                                            <a href="<?= base_url('tagihan/edit/' . $row['id']) ?>" class="btn btn-edit">Edit</a>

                                            <form id="formDeleteTagihan_<?= $row['id'] ?>" action="<?= base_url('tagihan/delete/' . $row['id']) ?>" method="post" class="form-delete-tagihan">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-delete btn-konfirmasi-hapus" data-id="<?= $row['id'] ?>">Hapus</button>
                                            </form>

                                            <button class="btn btn-kirim" data-id="<?= $row['id'] ?>" title="Kirim">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" style="text-align:center;">Data tidak tersedia</td></tr>
                        <?php endif ?>
                    </tbody>
                </table>
                <div id="modal-kirim-data" style="display: none;">
                    <form id="formKirimData">
                        <div id="list-akun" style="margin-bottom: 15px;">
                            <?php foreach ($akun_android as $akun): ?>
                                <div class="akun-item">
                                    <span class="akun-text"><?= esc($akun['username']) ?> (<?= esc($akun['email']) ?>)</span>
                                    <input type="checkbox" class="akun-checkbox" name="user_ids[]" value="<?= $akun['id'] ?>" style="display: none;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="button-group">
                            <button type="button" id="pilihSemua" class="btn btn-secondary">Pilih Semua</button>
                            <button type="button" id="batalPilih" class="btn btn-warning" style="display: none;">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/script.js') ?>" defer></script>
<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: <?= json_encode(session()->getFlashdata('success')) ?>,
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php elseif (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: <?= json_encode(session()->getFlashdata('error')) ?>,
            showConfirmButton: true
        });
    </script>
<?php endif; ?>
<script>
    document.querySelectorAll('.btn-konfirmasi-hapus').forEach(function(button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const tagihanId = this.getAttribute('data-id');
            const form = document.getElementById('formDeleteTagihan_' + tagihanId);

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Pastikan data sudah sesuai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    document.querySelectorAll('.btn-kirim').forEach(button => {
        button.addEventListener('click', function () {
            const tagihanId = this.getAttribute('data-id');
            const templateHTML = document.getElementById('modal-kirim-data').innerHTML;

            Swal.fire({
                title: 'Pilih Akun Tujuan',
                html: templateHTML,
                showConfirmButton: false,
                didOpen: () => {
                    const container = Swal.getHtmlContainer();
                    const form = container.querySelector('#formKirimData');
                    const checkboxes = container.querySelectorAll('.akun-checkbox');
                    const btnPilih = container.querySelector('#pilihSemua');
                    const btnBatal = container.querySelector('#batalPilih');

                    // Checkbox disembunyikan default — hanya muncul setelah klik "Pilih Semua"
                    checkboxes.forEach(cb => cb.style.display = 'none');

                    btnPilih.addEventListener('click', () => {
                        checkboxes.forEach(cb => {
                            cb.checked = true;
                            cb.style.display = 'inline-block';
                        });
                        btnPilih.style.display = 'none';
                        btnBatal.style.display = 'inline-block';
                    });

                    btnBatal.addEventListener('click', () => {
                        checkboxes.forEach(cb => {
                            cb.checked = false;
                            cb.style.display = 'none';
                        });
                        btnPilih.style.display = 'inline-block';
                        btnBatal.style.display = 'none';
                    });

                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const selected = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);

                        if (selected.length === 0) {
                            Swal.fire('Peringatan', 'Silakan pilih setidaknya satu akun!', 'warning');
                            return;
                        }

                        Swal.fire({
                            title: 'Konfirmasi',
                            text: 'Apakah Anda yakin ingin mengirim data ini ke akun terpilih?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Kirim!',
                            cancelButtonText: 'Batal'
                        }).then(result => {
                            if (result.isConfirmed) {
                                fetch(`<?= base_url('Tagihan/kirimMultiUser') ?>`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                                    },
                                    body: JSON.stringify({
                                        tagihan_id: tagihanId,
                                        user_ids: selected
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Sukses', data.message, 'success').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal', data.message, 'error');
                                    }
                                });
                            }
                        });
                    });
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menu = document.getElementById("exportMenu");
        const button = document.querySelector(".btn-export-custom");

        button.addEventListener("click", function(e) {
            e.stopPropagation();
            menu.classList.toggle("show");
        });

        document.addEventListener("click", function(e) {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove("show");
            }
        });
    });
</script>
</body>
</html>