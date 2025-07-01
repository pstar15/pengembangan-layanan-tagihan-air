<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Dashboard</title>
    <style>
        body {
            background-color:rgb(255, 255, 255);
        }
        h2 {
            text-align: left;
            margin-left: 10px;
        }
        h5 {
            color: #a3a3a3;
        }
        .container {
            margin-top: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .table-container {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
            position: relative;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
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

    </style>
</head>
<body class="animated">

    <!--

    PR modified chart grafik and chart curva

    -->

    <div class="navbar">
        <span class="menu-toggle" id="sidebarToggle">&#9776;</span>
        <h1 oncontextmenu="return false;" class="navbar-title no-copy">My App</h1>
        <div oncontextmenu="return false;" class="navbar-spacer no-copy">
            <?= session()->get('username'); ?>
        </div>
        <div class="profile-dropdown">
            <button class="profile-button">
                <i class="bi bi-gear"></i>
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
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container">
            <div class="card-container">
                <div class="">
                    <div class="card total">
                        <h3>Total Semua Tagihan</h3>
                        <p class="card-text"><?= $total_tagihan ?></p>
                        <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-card">Detail</a>
                    </div>
                    <h5>card total tagihan</h5>
                </div>
                <div class="">
                    <div class="card lunas">
                        <h3 class="card-title">Tagihan Lunas</h3>
                        <p class="card-text"><?= $total_lunas ?></p>
                        <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-card">Detail</a>
                    </div>
                    <h5>card tagihan lunas</h5>
                </div>
                <div class="">
                    <div class="card belum-lunas">
                        <h3 class="card-title">Belum Lunas</h3>
                        <p class="card-text"><?= $total_belum_lunas ?></p>
                        <a href="<?= base_url('riwayat-tagihan') ?>" class="detail-card">Detail</a>
                    </div>
                    <h5>card tagihan belum lunas</h5>
                </div>
            </div>

            <!--Chart-->
            <div class="chart-container">
                <div class="chart-curva">
                    <div class="card-body">
                        <canvas id="chartKurva" class="chart-line"></canvas>
                        <h5 class="card-title">Chart Kurva</h5>
                    </div>
                </div>
                <div class="tabel-daftar-akun">
                    <table class="table-da-akun" cellpadding="8" cellspacing="0">
                        <div class="thead-da">
                            <tr class="table-tr-daftar-akun">
                                <th class="th-da">Username</th>
                                <th  class="th-da">Status</th>
                                <th  class="th-da">Terakhir Online</th>
                            </tr>
                        </div>
                        <div class="tbody-da">
                            <?php foreach ($akun_android as $akun): ?>
                                <tr class="table-tr-row-daftar-akun">
                                    <td  class="td-da"><?= esc($akun['username']) ?></td>
                                    <td  class="td-da">
                                        <?php if ($akun['is_online']): ?>
                                            <span style="color:green;">Online</span>
                                        <?php else: ?>
                                            <span style="color:red;">Offline</span>
                                        <?php endif; ?>
                                    </td>
                                    <td  class="td-da"><?= $akun['last_online'] ?? 'Belum Pernah Login' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </div>
                    </table>
                    <h5 style="position: absolute;margin-top: 460px;margin-left: 140px;">Daftar Akun</h5>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive" style="box-shadow: none;">
                    <table class="table table-bordered table-striped styled-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No.Meter</th>
                                <th>Jumlah Meter</th>
                                <th>Periode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tagihan)) : ?>
                                <?php foreach ($tagihan as $i => $row) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td class="nama-col"><?= esc($row['nama_pelanggan']) ?></td>
                                        <td class="alamat-col"><?= esc($row['alamat']) ?></td>
                                        <td><?= esc($row['nomor_meter']) ?></td>
                                        <td><?= esc($row['jumlah_meter']) ?></td>
                                        <td><?= esc($row['periode']) ?></td>
                                        <td>Rp <?= number_format($row['jumlah_tagihan'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge <?= $row['status'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data tagihan</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <h5>Data Tagihan Air</h5>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="/js/sidebar.js"></script>
<script src="/js/script.js"></script>
<script src="/js/curva.js"></script>
<script>
const ctxKurva = document.getElementById('chartKurva').getContext('2d');

const chartKurva = new Chart(ctxKurva, {
    type: 'line',
    data: {
        labels: <?= $periode ?>, // Pastikan variabel ini tersedia dari controller
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
                text: 'Kurva Tagihan per Periode'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Periode'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Tagihan'
                }
            }
        }
    }
});
</script>

</body>
</html>
