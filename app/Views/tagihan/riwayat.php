<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Riwayat | Tagihan Air</title>
    <style>
        .container {
            width: 100%;
            margin-top: 80px;
        }
        .table-container {
            margin: 0 auto;
            margin-top: 40px;
            width: 100%;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        h2 {
            position: absolute;
            text-align: left;
            margin-top: 22px;
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
        .btn-keloladata {
            display: flex;
            position: inherit;
            margin: 0 auto;
            margin-left:250px;
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
<body class="animated">

    <!--

        PR tambahkan animasi agar tombol
        reset mucul setelah filter data terpilih,
        ubah posisi title halaman and geser pilih data / hapus title halaman,

    -->

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
                <a href="/riwayat-tagihan" class="<?= uri_string() == 'riwayat-tagihan' ? 'active' : '' ?>">
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

            <h2>Riwayat Tagihan Air</h2>
            <!-- Filter data tagihan -->
            <div class="btns-riwayat">
                <form action="<?= site_url('/riwayat-tagihan') ?>" method="get">
                    <div class="btn-filter-riwayat">
                        <button type="submit" class="filter-datariwayat btn btn-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <h5 class="label-filter-hover">Filter</h5>
                    </div>
                    <div class="btn-reset-riwayat" id="resetBtn" style="display: none;">
                        <button  class="reset-riwayat" >
                            <i class="bi bi-arrow-clockwise reset-riwayat"></i>
                        </button>
                        <h5 class="label-reset-hover">Resets</h5>
                    </div>
                    <div class="from-input-riwayat">
                        <div class="form-filter-riwayat">
                            <input type="month" id="filterInput" name="periode" class="input-riwayat" value="<?= esc($periode ?? '') ?>">
                        </div>
                        <h5 class="label-Finput-hover">Pilih Periode Tagihan</h5>
                    </div>
                </form>
            </div>
            <div class="btn-export-riwayat">
                <div id="exportBtn" class="export-riwayat">
                    <a href="<?= site_url('riwayat/export/excel?periode=' . ($periode ?? '')) ?>" id="btnExportExcel" class="export btn btn-success">
                        <i class="bi bi-filetype-exe"></i>
                    </a>
                </div>
                <h5 class="label-export-hover">export</h5>
            </div>

            <!-- button menu keloladata -->
            <div id="kontrol-aksi" class="btn-keloladata mb-3">
                <div class="btn-pilih-riwayat">
                    <div class="pilih-data">
                        <button id="btnPilih" class="pilih btn btn-primary">
                            <a href="#" style="color: #fff;">Pilih</a>
                        </button>
                    </div>
                    <h5 class="label-pilih-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Pilih Data</h5>
                </div>
                <div class="btn-batal-riwayat">
                    <div class="batal-data">
                        <button id="btnBatal" class="batal btn btn-danger d-none">
                            <a href="#" style="color: #fff;">Batal</a>
                        </button>
                    </div>
                    <h5 class="label-batal-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Batal</h5>
                </div>
                <div class="btn-kembalikan-riwayat">
                    <div class="kembalikan-data">
                        <button id="btnKembalikan" class="kembalikan btn btn-warning" style="display: none;">
                            <a href="#" style="color: #1f5e8e;">
                                <i class="bi bi-folder-symlink"></i>
                            </a>
                        </button>
                    </div>
                    <h5 class="label-kembalikan-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Return</h5>
                </div>
                <div class="btn-hapus-riwayat">
                    <div class="hapus-data">
                        <button id="btnHapus" class="hapus btn btn-danger d-none">
                            <a href="#" style="color: rgb(184, 40, 40);">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </button>
                    </div>
                    <h5 class="label-hapus-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Hapus</h5>
                </div>
                <div class="btn-smeua-riwayat">
                    <div class="semua-data">
                        <button id="btnSemua" class="semua btn btn-success d-none">
                            <a href="#">
                                <i class="bi bi-check-all"></i>
                            </a>
                        </button>
                    </div>
                    <h5 class="label-semua-hover" style="position: absolute;margin-top: -3px;margin-left: 6px;">Semua</h5>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped styled-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No.Meter</th>
                                <th>Jumlah Meter</th>
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
                                <td class="nama-col"><?= esc($r['nama_pelanggan']) ?></td>
                                <td class="alamat-col"><?= esc($r['alamat']) ?></td>
                                <td><?= esc($r['nomor_meter']) ?></td>
                                <td><?= esc($r['jumlah_meter']) ?></td>
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
    document.addEventListener('DOMContentLoaded', function () {
        const filterInput = document.getElementById('filterInput');
        const resetBtn = document.getElementById('resetBtn');

        if (filterInput.value !== '') {
            resetBtn.style.display = 'inline-block';
        }
    });
</script>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterInput = document.getElementById("filterInput");
        const resetBtn = document.getElementById("resetBtn");
        const exportBtn = document.getElementById("exportBtn");

        function toggleButtons() {
            const show = filterInput.value !== "";
            resetBtn.style.display = show ? "inline-block" : "none";
            exportBtn.style.display = show ? "inline-block" : "none";
        }

        filterInput.addEventListener("input", toggleButtons);

        resetBtn.addEventListener("click", function () {
            filterInput.value = "";
            toggleButtons();
        });

        // Sembunyikan tombol di awal
        toggleButtons();
    });
</script>


</body>
</html>