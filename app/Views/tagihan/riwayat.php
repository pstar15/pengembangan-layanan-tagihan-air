<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Riwayat Tagihan</title>
    <style>
        .container {
            width: 865px;
            margin-top: 110px;
        }
        .table-container {
            margin: 0 auto;
            margin-top: 80px;
            width: 100%;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        h2 {
            position: absolute;
            text-align: left;
            margin-top: 65px;
            margin-left: 0;
            color: #000;
        }
        h5 {
            color: #a3a3a3;
            text-align: center;
        }
        .styled-table thead {
            background-color: #2980b9;
            color: #fff;
            text-align: center;
        }
    </style>
</head>
<body class="animated">

    <!--

        PR tambahkan animasi agar tombol
        reset mucul setelah filter data terpilih,
        ubah posisi title halaman and geser pilih data / hapus title halaman,

    -->

    <!-- navbar -->
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

    <!-- sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li>
                <a href="<?= base_url('auth/dashboard') ?>" class="sidebar-link">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="<?= base_url('tagihan') ?>" class="sidebar-link">
                    <i class="fas fa-water"></i> Tagihan
                </a>
            </li>

            <li>
                <a href="/riwayat-tagihan" class="<?= uri_string() == 'riwayat-tagihan' ? 'active' : '' ?>">
                    Riwayat
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container">
            <h2>Riwayat Tagihan Air</h2>

            <!-- Alert Notifikasi -->
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

            <!-- Filter data tagihan -->
            <div class="btns-riwayat">
                <form action="<?= site_url('riwayat/filter') ?>" method="get" >
                    <input type="month" name="periode" class="form-control input-riwayat" value="<?= esc($periode ?? '') ?>">
                    <div>
                        <button type="submit" class="filter-datariwayat btn btn-primary">
                            <a href="#">
                                <i class="bi bi-funnel"></i>
                            </a>
                        </button>
                        <h5 style="position: absolute;margin-left: 190px;margin-top: 50px;">filter</h5>
                    </div>
                    <div>
                        <div class="reset-riwayat">
                            <a href="<?= site_url('riwayat') ?>" class="reset-datariwayat btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                        <h5 style="position: absolute;margin-left: 130px;margin-top: 50px;">resets</h5>
                    </div>
                </form>
                <div>
                    <div class="export-riwayat">
                        <a href="<?= site_url('riwayat/export/excel?periode=' . ($periode ?? '')) ?>" id="btnExportExcel" class="export btn btn-success">
                            <i class="bi bi-filetype-exe"></i>
                        </a>
                    </div>
                    <h5 style="position: absolute;margin-left: 65px;margin-top: 50px;">export</h5>
                </div>
            </div>

            <!-- button menu keloladata -->
            <div id="kontrol-aksi" class="btn-keloladata mb-3">
                <div class="pilih-data">
                    <button id="btnPilih" class="pilih btn btn-primary">
                        <a href="#" style="color: #fff;">Pilih</a>
                    </button>
                </div>
                <div class="semua-data">
                    <button id="btnSemua" class="semua btn btn-success d-none">
                        <a href="#">
                            <i class="bi bi-check-all"></i>
                        </a>
                    </button>
                </div>
                <div class="kembalikan-data">
                    <button id="btnKembalikan" class="kembalikan btn btn-warning" style="display: none;">
                        <a href="#" style="color: #1f5e8e;">
                            <i class="bi bi-folder-symlink"></i>
                        </a>
                    </button>
                </div>
                <div class="hapus-data">
                    <button id="btnHapus" class="hapus btn btn-danger d-none">
                        <a href="#" style="color: rgb(184, 40, 40);">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </button>
                </div>

                <div class="batal-data">
                    <button id="btnBatal" class="batal btn btn-danger d-none">
                        <a href="#" style="color: #fff;">Batal</a>
                    </button>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped styled-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Meter</th>
                                <th>Periode</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                                <th>Tanggal Simpan</th>
                                <th class="checkbox-col" style="display: none;">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= esc($r['nama_pelanggan']) ?></td>
                                <td><?= esc($r['nomor_meter']) ?></td>
                                <td><?= esc($r['periode']) ?></td>
                                <td><?= esc($r['jumlah_tagihan']) ?></td>
                                <td>
                                        <span class="badge <?= $r['status'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>">
                                            <?= $r['status'] ?>
                                        </span>
                                    </td>
                                <td><?= date('d-m-Y', strtotime($r['created_at'])) ?></td>
                                <td class="checkbox-col" style="display: none;">
                                    <input type="checkbox" class="checkbox-data" value="<?= $r['id'] ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <h5>Data Tagihan Air</h5>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>
<script src="<?= base_url('js/riwayat.js') ?>"></script>
<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnPilih = document.getElementById("btnPilih");
        const btnSemua = document.getElementById("btnSemua");
        const btnBatal = document.getElementById("btnBatal");
        const btnKembalikan = document.getElementById("btnKembalikan");
        const btnHapus = document.getElementById("btnHapus");
        const checkboxCols = document.querySelectorAll(".checkbox-col");
        const checkboxItems = document.querySelectorAll(".checkbox-data");

        btnSemua.style.display = "none";
        btnBatal.style.display = "none";
        btnKembalikan.style.display = "none";
        btnHapus.style.display = "none";
        checkboxCols.forEach(col => col.style.display = "none");

        btnPilih.addEventListener("click", function () {
            checkboxCols.forEach(col => col.style.display = "table-cell");
            btnSemua.style.display = "inline-block";
            btnBatal.style.display = "inline-block";
            btnKembalikan.style.display = "inline-block";
            btnHapus.style.display = "inline-block";
            btnPilih.style.display = "none";
        });

        btnSemua.addEventListener("click", function () {
            checkboxItems.forEach(cb => cb.checked = true);
        });

        btnBatal.addEventListener("click", function () {
            checkboxCols.forEach(col => col.style.display = "none");
            checkboxItems.forEach(cb => cb.checked = false);
            btnSemua.style.display = "none";
            btnBatal.style.display = "none";
            btnKembalikan.style.display = "none";
            btnHapus.style.display = "none";
            btnPilih.style.display = "inline-block";
        });


        btnKembalikan.addEventListener("click", function () {

            const selectedIds = Array.from(document.querySelectorAll(".checkbox-data:checked"))
                                    .map(cb => cb.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Pilih minimal satu data untuk dikembalikan.',
                });
                return;
            }

            // Tampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Yakin ingin mengembalikan data ini?',
                text: "Data akan dikembalikan ke tabel tagihan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kembalikan!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('riwayat/kembalikan') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dikembalikan.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Terjadi kesalahan saat mengembalikan data.'
                            });
                        }
                    });
                }
            });
        });
        btnHapus.addEventListener("click", function () {
            const selectedIds = Array.from(document.querySelectorAll(".checkbox-data:checked"))
                            .map(cb => cb.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada data terpilih!',
                    text: 'Pilih minimal satu data untuk dihapus.',
                });
                return;
            }

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('riwayat/hapus') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Gagal menghapus data.'
                            });
                        }
                    });
                }
            });
        });
        btnExport.addEventListener("click", function () {
            const tanggal = document.getElementById("tanggal")?.value || "";
            const bulan = document.getElementById("bulan")?.value || "";

            Swal.fire({
                title: 'Export Data?',
                text: tanggal || bulan ? 
                    `Data akan difilter berdasarkan ${tanggal ? 'tanggal ' + tanggal : 'bulan ' + bulan}` : 
                    'Semua data akan di-export.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Export Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("inputTanggal").value = tanggal;
                    document.getElementById("inputBulan").value = bulan;
                    document.getElementById("exportForm").submit();
                }
            });
        });
        btnExportExcel.addEventListener("click", function () {
            Swal.fire({
                title: 'Export ke Excel?',
                text: 'Data riwayat akan di-export sebagai Excel.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Export',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const periode = document.getElementById('filterPeriode')?.value || '';
                    window.location.href = "<?= site_url('riwayat/export/excel') ?>?periode=" + encodeURIComponent(periode);
                }
            });
        })
    });
</script>

</body>
</html>