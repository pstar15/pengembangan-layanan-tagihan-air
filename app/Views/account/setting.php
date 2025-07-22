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
            width: 50%;
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

        .profile-icon {
            font-size: 100px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .text-username {
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            font-weight: bold;
            margin-left: 10px;
            color: #000000;
        }

        .button-setting-account {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px auto;
            width: 40%;
            padding: 12px 24px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .button-setting-account:hover {
            background-color: #f0f0f0;
            transform: scale(1.02);
        }

        .text-setting {
            font-size: 16px;
            font-weight: 500;
            color: #000000;
            margin: 0;
        }

        .text-setting {
            text-align: left;
            font-size: 15px;
            font-weight: 500;
            margin-left: 10px;
            color: #000;
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
            <div class="title-username">
                <div oncontextmenu="return false;" class="name navbar-spacer no-copy">
                    <div class="profile-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="text-username">
                        hai, <?= session()->get('username'); ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="">
                <a href="<?= base_url('/account/setting_account') ?>" class="button-setting-account">
                    <h5 class="text-setting">Setting Account</h5>
                </a>

                <a href="<?= base_url('/account_app') ?>" class="button-setting-account">
                    <h5 class="text-setting">Account Aplikasi</h5>
                </a>
            </div>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>

</body>
</html>