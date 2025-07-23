<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LOGO BROWSER -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-bumdes.png') ?>">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/table_dashboard.css') ?>">
    <title>Dashboard | Tagihan Air BUMDesa</title>
    <style>
        body {
            background-color: #f7f7f7ff;
        }
        h2 {
            text-align: left;
            margin-left: 10px;
        }
        h5 {
            color: #a3a3a3;
        }
        .container {
            margin-top: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .table-striped thead th {
            position: sticky;
            top: 0;
            z-index: 5;
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

    PR modified chart grafik and chart curva

    -->

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
                <a href="/auth/dashboard" class="<?= uri_string() == 'auth/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-columns-gap" style="font-size: 0.9rem;"></i>
                    <span class="sidebar-text" style="margin-left: 10px;">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('tagihan') ?>" class="sidebar-link">
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

            <!-- CARD TAGIHAN -->
            <div class="card-container">
                <div class="card-left">
                    <div class="card pendapatan">
                        <div class="card-icon cart-text-info">
                            <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-tagihan">
                                <i class="bi bi-currency-dollar"></i>
                            </a>
                            <hr>
                        </div>
                        <div class="card-text-pendapatan">
                            <p class="card-text" style="font-size: 25px;">Rp <?= number_format($totalTagihan, 0, ',', '.') ?></p>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <h3 style="margin-left: 20px;">Total Pendapatan</h3>
                        </div>
                        <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-card">
                            Detail
                        </a>
                    </div>
                </div>

                <div class="card-right">
                    <div class="card-row">
                        <div class="card card-content total-tagihan">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-tagihan">
                                    <i class="bi bi-database-fill"></i>
                                </a>
                            </div>
                            <h3>Total Data Tagihan</h3>
                            <p class="card-text"><?= $total_tagihan ?></p>
                        </div>
                        <div class="card card-content tagihan-lunas">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-tagihan">
                                    <i class="bi bi-database-fill-check"></i>
                                </a>
                            </div>
                            <h3>Tagihan Lunas</h3>
                            <p class="card-text"><?= $total_lunas ?></p>
                        </div>
                        <div class="card card-content tagihan-belum-lunas">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-tagihan">
                                    <i class="bi bi-database-fill-exclamation"></i>
                                </a>
                            </div>
                            <h3>Tagihan Belum Lunas</h3>
                            <p class="card-text"><?= $total_belum_lunas ?></p>
                        </div>
                    </div>
                    <div class="card-row">
                        <div class="card card-content total-akun">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-akun">
                                    <i class="bi bi-person-fill"></i>
                                </a>
                            </div>
                            <h3>Total Akun Aplikasi</h3>
                            <p class="card-text"><?= $totalAkun ?></p>
                        </div>
                        <div class="card card-content total-akun-aktif">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-akun">
                                    <i class="bi bi-person-fill-check"></i>
                                </a>
                            </div>
                            <h3>Total Akun Aktif</h3>
                            <p class="card-text"><?= $totalAktif ?></p>
                        </div>
                        <div class="card card-content total-akun-tidak-aktif">
                            <div class="cart-text-info">
                                <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-row-akun">
                                    <i class="bi bi-person-fill-exclamation"></i>
                                </a>
                            </div>
                            <h3>Total Akun Tidak Aktif</h3>
                            <p class="card-text"><?= $totalNonAktif ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--Chart-->
            <div class="chart-container">
                <div class="chart-wrapper">
                    <canvas id="chartKurva" class="chart-line"></canvas>
                </div>
            </div>

            <div class="table-wrapper">
                <div class="table-scroll">
                    <div class="table-box akun">
                        <table class="table-da-akun">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Terakhir Online</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($akun_android as $akun): ?>
                                    <tr>
                                        <td><?= esc($akun['username']) ?></td>
                                        <td><?= esc($akun['email']) ?></td>
                                        <td>
                                            <?php if ($akun['is_online']): ?>
                                                <span style="color:green;">Aktif</span>
                                            <?php else: ?>
                                                <span style="color:red;">Offline</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($akun['last_online']) ?: '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-box tagihan">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No.Meter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tagihan)) : ?>
                                    <?php foreach ($tagihan as $i => $row) : ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= esc($row['nama_pelanggan']) ?></td>
                                            <td><?= esc($row['alamat']) ?></td>
                                            <td><?= esc($row['nomor_meter']) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data tagihan</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?= base_url('js/script.js') ?>" defer></script>
<script>
    const ctxKurva = document.getElementById('chartKurva').getContext('2d');

    const chartKurva = new Chart(ctxKurva, {
        type: 'line',
        data: {
            labels: <?= $periode ?>,
            datasets: [{
                label: 'Jumlah Tagihan',
                data: <?= $total ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Kurva Pendapatan per Periode'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Pendapatamn Per Periode'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pendapatan'
                    }
                }
            }
        }
    });
</script>
<script>
    
</script>

</body>
</html>
