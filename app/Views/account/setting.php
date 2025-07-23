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

        .profile-icon {
            font-size: 100px;
            margin: 0 auto;
            color: #000;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-name {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .form-set input {
            position: inherit;
            justify-content: center;
            align-items: center;
            margin-left: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            color: #000;
        }

        .label-input {
            flex: 1;
            position: relative;
            justify-content: center;
            align-items: center;
            color: #000;
            margin-left: 10px;
        }

        .button-edit-account a {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px auto;
            width: 80%;
            padding: 12px 24px;
            border-radius: 10px;
            background-color: #007BFF;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .button-edit-account a:hover {
            background-color: #0064cf;
            transform: scale(1.05);
        }

        .button-set-acount-aplikasi  a {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px auto;
            width: 40%;
            padding: 12px 24px;
            border-radius: 10px;
            background-color: #007BFF;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .button-set-acount-aplikasi  a:hover {
            background-color: #0064cf;
            transform: scale(1.05);
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
                <div class="profile-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="profile-name">
                    <p>Identitas Akun</p>
                </div>
                <div class="container-form-setting">
                    <div class="form-set">
                        <label for="username" class="label-input">Username</label>
                        <input type="username" name="username" required value="<?= session()->get('username') ?>" readonly>
                    </div>
                    <div class="form-set">
                        <label for="email" class="label-input">Email</label>
                        <input type="email" name="email" required value="<?= session()->get('email') ?>" readonly>
                    </div>
                    <div class="button-edit-account">
                        <a href="<?= base_url('account/setting_account') ?>">
                            Edit Akun
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="button-set-acount-aplikasi">
                <a href="<?= base_url('/account_app') ?>" class="button-edit-account-aplikasi">
                    Daftar Account Aplikasi
                </a>
            </div>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>

</body>
</html>