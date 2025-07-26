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

        .title-username .name {
            width: 100%;
            text-align: center;
            color: #000000;
        }

        .form-setting {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .profile-name {
            text-align: left;
            font-size: 20px;
            color: #000;
            user-select: none;
            white-space: nowrap;
        }

        .container-form-setting {
            position: relative;
            justify-content: center;
            align-items: center;
            user-select: none;
            white-space: nowrap;
        }

        .form-setting .form-set {
            margin-bottom: 15px;
        }

        .form-set {
            position: relative;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .label-title {
            position: inherit;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            top: 10px;
            font-size: 20px;
            border-radius: 8px;
            color: #8f8f8fff;
        }

        .form-set .input {
            position: inherit;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }

        .input {
            color: #8f8f8fff;
        }

        .label-input {
            flex: 1;
            position: relative;
            justify-content: center;
            align-items: center;
            color: #000;
            margin-left: 10px;
            top: 10px;
        }

        .button-edit-account {
            display: flex;
            justify-content: flex-end;
            margin: 0 auto;
            margin-right: 0;
        }

        .button-edit-account a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            padding: 6px 10px;
            max-width: 120px;
            height: 15px;
            border-radius: 10px;
            font-size: 11px;
            text-align: center;
            color: #a8a8a8ff;
            border: 1px solid #a8a8a8ff;
            transition: background-color 0.3s, transform 0.2s;
            transform: scale(1.05);
            white-space: nowrap;
        }

        .button-edit-account a:hover {
            color: #727272ff;
            border: 1px solid #727272ff;
            transform: scale(1.01);
        }

        .button-setting  a {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px auto;
            max-width: 100%;
            padding: 12px 20px;
            border-radius: 10px;
            border: 1px solid #a8a8a8ff;
            background-color: none;
            color: #a8a8a8ff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .button-setting  a:hover {
            background-color: #0064cf;
            color: #ffffff;
            transform: scale(1.01);
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
            <div oncontextmenu="return false;" class="form-setting no-copy">
                <div class="profile-name">
                    <p>Identitas Akun</p>
                </div>
                <hr>
                <div class="container-form-setting">
                    <div class="form-set">
                        <span class="label-title">
                            Welcome, <?= session()->get('username') ?>
                        </span>
                    </div>
                    <div class="form-set">
                        <label for="email" class="label-input">Email</label>
                        <div class="input">
                            <?= session()->get('email') ?>
                        </div>
                    </div>
                    <div class="button-edit-account">
                        <a href="<?= base_url('account/setting_account') ?>">
                            Change Account
                        </a>
                    </div>
                </div>
                <hr style="margin-top: 20px;">
                <div class="button-setting">
                    <a href="<?= base_url('account/login-activity') ?>">
                        Aktifitas Login
                    </a>
                </div>
                <div class="button-setting">
                    <a href="<?= base_url('/account_app') ?>">
                        Account App
                    </a>
                </div>
            </div>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>

</body>
</html>