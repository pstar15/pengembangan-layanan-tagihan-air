<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktifitas Login | Tagihan Air BUMDesa</title>
    <style>
        .login-activity-container {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', sans-serif;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-section h2 {
            font-size: 20px;
            margin: 0;
        }

        .btn-logout-all {
            padding: 8px 16px;
            border: 1px solid #d33;
            color: #d33;
            border-radius: 8px;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-logout-all:hover {
            background-color: #fdd;
        }

        .activity-table table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .activity-table th, .activity-table td {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px;
            text-align: left;
        }

        .status-sukses {
            color: green;
            font-weight: bold;
        }

        .status-gagal {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="main-content" id="mainContent">
        <div class="container">
            <div class="login-activity-container">
                <div class="header-section">
                    <h2>Aktivitas Login</h2>
                    <button class="btn-logout-all">Keluar dari Semua Perangkat</button>
                </div>

                <div class="activity-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>Alamat IP</th>
                                <th>Lokasi</th>
                                <th>Perangkat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat_login as $log) : ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i:s', strtotime($log['waktu'])) ?></td>
                                    <td><?= esc($log['ip_address']) ?></td>
                                    <td><?= esc($log['lokasi']) ?></td>
                                    <td><?= esc($log['perangkat']) ?></td>
                                    <td class="<?= $log['status'] == 'Sukses' ? 'status-sukses' : 'status-gagal' ?>">
                                        <?= esc($log['status']) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.querySelector('.btn-logout-all');

        logoutBtn.addEventListener('click', function () {
            if (confirm("Yakin ingin keluar dari semua perangkat?")) {
                window.location.href = "<?= base_url('/account/logout_all') ?>";
            }
        });
    });
</script>
</body>
</html>