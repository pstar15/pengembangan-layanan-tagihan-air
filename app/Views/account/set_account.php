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

    .message {
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 5px;
        font-weight: 500;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }


    .container-edit-akun {
        margin: 30px auto;
        padding: 24px;
        max-width: 500px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .edit-akun h2 {
        text-align: center;
        font-size: 20px;
        margin-bottom: 24px;
        color: #333;
    }

    form {
        margin-bottom: 30px;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
        color: #222;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: border 0.3s ease;
        background-color: #fff;
        box-sizing: border-box;
    }

    input:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
    }

    button {
        width: 100%;
        background-color: #4a90e2;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
        box-sizing: border-box;
    }

    button:hover {
        background-color: #357ab8;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper input {
        width: 100%;
        padding: 10px 40px 10px 14px; /* padding kanan diperbesar */
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .toggle-icon {
        position: absolute;
        right: 12px;
        cursor: pointer;
        color: #888;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .toggle-icon:hover {
        color: #000;
    }


    hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 30px 0;
    }

    /* Responsive Behavior - Optional */
    @media (max-width: 600px) {
        .container-edit-akun {
            padding: 20px;
        }

        input,
        button {
            font-size: 14px;
        }
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

            
            <div class="container-edit-akun">
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

                <div class="edit-akun">
                    <h2>Pengaturan Akun</h2>

                    <form action="<?= base_url('/account/update-username') ?>" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" required value="<?= session()->get('username') ?>">
                        </div>
                        <button type="submit">Update</button>
                    </form>

                    <hr>

                    <form action="<?= base_url('/account/update-email') ?>" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" required value="<?= session()->get('email') ?>">
                        </div>
                        <button type="submit">Update</button>
                    </form>

                    <hr>

                    <form action="<?= base_url('/account/update-password') ?>" method="post">
                        <div class="form-group password-group">
                            <label for="currentPassword">Password Lama:</label>
                            <div class="input-wrapper">
                                <input type="password" name="current_password" placeholder="Password Lama" id="currentPassword">
                                <span onclick="togglePassword('currentPassword', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group password-group">
                            <label for="newPassword">Password Baru:</label>
                            <div class="input-wrapper">
                                <input type="password" name="new_password" placeholder="Password Baru" id="newPassword">
                                <span onclick="togglePassword('newPassword', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group password-group">
                            <label for="confirmPassword">Konfirmasi Password:</label>
                            <div class="input-wrapper">
                                <input type="password" name="confirm_password" placeholder="Konfirmasi Password" id="confirmPassword">
                                <span onclick="togglePassword('confirmPassword', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit">Update</button>
                        <a href="<?= base_url('account/setting') ?>" class="btn-kembali">← Kembali ke identitas akun</a>
                    </form>
                </div>
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