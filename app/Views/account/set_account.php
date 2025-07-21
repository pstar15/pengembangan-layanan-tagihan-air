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

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    label {
        font-weight: bold;
        color: #000;
    }

    input[type="username"],
    input[type="email"] {
        width: 98%;
        padding: 10px;
        margin-top: 6px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    input:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 5px rgba(74, 144, 226, 0.4);
    }

    button {
        background-color: #4a90e2;
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #357ab8;
    }

    .message {
        padding: 10px;
        margin-bottom: 16px;
        border-radius: 8px;
        animation: slideIn 0.5s ease;
        opacity: 1;
    }

    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.8s ease-in-out forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
    .input-group-text {
        justify-content: right;
        align-items: right;
        display: flex;
        margin: 0 auto;
        margin-left: 0;
        margin-right: 10px;
    }
    .logout:hover {
        color:rgb(255, 0, 0);
    }

    .menu-toggle {
        width: 35px;
        height: 20px;
        cursor: pointer;
        font-size: 20px;
        margin-left: 10px;
        color: #b4b4b4;
        padding: 3px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .menu-toggle:hover {
        color: #d3d3d3;
        border: 2px solid #d3d3d3;
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
            <h2>Pengaturan Akun</h2>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="message error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
                <div class="message success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success_email')): ?>
                <div class="message success"><?= session()->getFlashdata('success_email') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success_pass')): ?>
                <div class="message success"><?= session()->getFlashdata('success_pass') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error_pass')): ?>
                <div class="message error"><?= session()->getFlashdata('error_pass') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success_username')): ?>
                <div class="message success"><?= session()->getFlashdata('success_username') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error_password')) : ?>
                <div class="message error"><?= session()->getFlashdata('error_password') ?></div>
            <?php elseif (session()->getFlashdata('success_password')) : ?>
                <div class="message success"><?= session()->getFlashdata('success_password') ?></div>
            <?php endif; ?>

            <div style="margin-top: 40px;">
                <form action="<?= base_url('/account/update-username') ?>" method="post">
                    <label for="username">Username</label>
                    <input type="username" name="username" required value="<?= session()->get('username') ?>">
                    <button type="submit">Update</button>
                </form>

                <hr style="margin: 30px 0;">

                <form action="<?= base_url('/account/update-email') ?>" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email" required value="<?= session()->get('email') ?>">
                    <button type="submit">Update</button>
                </form>

                <hr style="margin: 30px 0;">

                <form action="<?= base_url('/account/update-password') ?>" method="post">
                    <div class="input-group mb-3">
                        <label for="currentPassword">Password Lama:</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Password Lama" id="currentPassword" style="width: 98%;">
                        <span class="input-group-text" onclick="togglePassword('currentPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <label for="newPassword">Password Baru:</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Password Baru" id="newPassword" style="width: 98%;">
                        <span class="input-group-text" onclick="togglePassword('newPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <label for="confirmPassword">Confirmasi Password:</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" id="confirmPassword" style="width: 98%;">
                        <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>

                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>
<script>
    setTimeout(function() {
        const alerts = document.querySelectorAll('.message');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const icon = el.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = "password";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
</body>
</html>