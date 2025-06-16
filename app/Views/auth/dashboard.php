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
            margin: 0 auto;
            margin-top: 80px;
            width: 100%;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }
        .table-container:hover {
            transform: scale(1.1);
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 100%;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }

    </style>
</head>
<body class="animated">

    <!--

    PR modified chart grafik and chart curva

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
                <a href="/auth/dashboard" class="<?= uri_string() == 'auth/dashboard' ? 'active' : '' ?>">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="<?= base_url('tagihan') ?>" class="sidebar-link">
                    <i class="fas fa-water"></i> Tagihan
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
            <div class="card-container">
                <div>
                    <div class="card total">
                        <h3>Total Tagihan</h3>
                        <p class="card-text"><?= $total_tagihan ?></p>
                    </div>
                    <h5>card total tagihan</h5>
                </div>
                <div>
                    <div class="card lunas">
                        <h3>Tagihan Lunas</h3>
                        <p class="card-text"><?= $total_lunas ?></p>
                    </div>
                    <h5>card total tagihan lunas</h5>
                </div>
                <div>
                    <div class="card belum-lunas">
                        <h3>Total Belum Lunas</h3>
                        <p class="card-text"><?= $total_belum_lunas ?></p>
                    </div>
                    <h5>card total tagihan belum lunas</h5>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-grafik">
                    <!-- Chart Grafik (Bar) -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Jumlah Tagihan per Periode (Bar)</h5>
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="chart-curva">
                    <!-- Chart Kurva (Line) -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Kurva Jumlah Tagihan per Periode</h5>
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="table-container">
                <div class="table-responsive" style="box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);">
                    <table class="table table-bordered table-striped styled-table">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor Meter</th>
                                <th>Periode</th>
                                <th>Jumlah Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tagihan)) : ?>
                                <?php foreach ($tagihan as $i => $row) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row['nama_pelanggan']) ?></td>
                                        <td><?= esc($row['nomor_meter']) ?></td>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/script.js"></script>
    <script src="/js/curva.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = <?= $periode ?>;
        const data = <?= $total ?>;

        // Chart Bar
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Tagihan',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Bar Chart: Jumlah Tagihan' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Tagihan' }
                    },
                    x: {
                        title: { display: true, text: 'Periode' }
                    }
                }
            }
        });

        // Chart Line
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Tagihan',
                    data: data,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Line Chart: Kurva Jumlah Tagihan' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Tagihan' }
                    },
                    x: {
                        title: { display: true, text: 'Periode' }
                    }
                }
            }
        });
    </script>

</body>
</html>
