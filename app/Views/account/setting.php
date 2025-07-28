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
    <title>Account Setting | Tagihan Air</title>
    <style>
        .container {
            width: 100%;
            margin: 0 auto;
            margin-top: 60px;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
        }

        .container-form-setting {
            align-items: center;
            justify-content: center;
            position: relative;
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            font-family: sans-serif;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
            color: #000000;
        }

        .divider {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin: 10px 0 20px;
        }

        .form-identitas-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
        }

        .left-info {
            flex: 1;
            min-width: 250px;
        }

        .welcome-text {
            font-size: 16px;
            margin-bottom: 10px;
            color: #000000;
        }

        .email-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .label-email {
            font-size: 14px;
            color: #333;
        }

        .email-display {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 4px 8px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #666;
            width: 220px;
        }

        .btn-change-account a{
            width: 120px;
            font-size: 11px;
            padding: 5px 10px;
            margin-left: 185px;
            background-color: #e0e0e0;
            color: #555;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-change-account a:hover {
            background-color: #d5d5d5;
        }

        .right-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 160px;
        }

        .btn {
            text-align: center;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-account {
            border: 1px solid #a8a8a8;
            color: #666;
            background-color: transparent;
        }

        .btn-account:hover {
            border-color: #727272;
            color: #333;
        }

        .btn-activity {
            border: 1px solid #a8a8a8;
            color: #666;
            background-color: transparent;
        }

        .btn-activity:hover {
            border-color: #727272;
            color: #333;
        }

        .btn-delete-akun {
            border: 1px solid #a8a8a8;
            color: #666;
            background-color: transparent;
        }

        .btn-delete-akun:hover {
            border-color: #727272;
            color: #333;
        }

        .form-identitas-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
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
                <a href="/account/setting" class="<?= uri_string() == 'account/setting' ? 'active' : '' ?>">
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
            <div class="container-form-setting">
                <h4 class="section-title">Identitas Akun</h4>
                <hr class="divider">
                <div class="form-identitas-grid">
                    <div class="left-info">
                        <p class="welcome-text">Welcome, <strong><?= session()->get('username') ?></strong></p>

                        <div class="email-info">
                            <label for="email" class="label-email">Email:</label>
                            <input type="text" class="email-display" value="<?= session()->get('email') ?>" readonly>
                        </div>

                        <div  class="btn-change-account">
                            <a href="<?= base_url("account/setting_account") ?>">Change account</a>
                        </div>
                    </div>

                    <div class="right-actions">
                        <a href="<?= base_url('/account_app') ?>" class="btn btn-account">Account App</a>
                        <a href="<?= base_url('account/login-activity') ?>" class="btn btn-activity">Aktivitas Login</a>
                        <a href="<?= base_url('/account_app') ?>" class="btn btn-delete-akun">Hapus Akun</a>
                    </div>
                </div>

                <hr class="divider" style="margin-top: 20px;">
            </div>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>

</body>
</html>