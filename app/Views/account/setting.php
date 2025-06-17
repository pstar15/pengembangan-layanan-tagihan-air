<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Account Setting</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f2f5f9;
        transition: transform 0.3s ease;
        animation: fadeIn 0.5s ease;
    }

    .container {
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        margin-top: 90px;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
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
        width: 778px;
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
</style>
</head>
<body>

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
                <a href="<?= base_url('/auth/dashboard') ?>" class="sidebar-link">
                    <i class="bi bi-columns-gap"></i>
                    <span style="margin-left: 10px;">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('tagihan') ?>" class="sidebar-link">
                    <i class="bi bi-droplet-half"></i>
                    <span style="margin-left: 10px;">Tagihan</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('riwayat-tagihan') ?>" class="sidebar-link">
                    <i class="bi bi-journal"></i>
                    <span style="margin-left: 10px;">Riwayat</span>
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

            <form action="<?= base_url('/account/update-username') ?>" method="post">
                <label for="username">Ganti Username</label>
                <input type="username" name="username" required value="<?= session()->get('username') ?>">
                <button type="submit">Simpan Username</button>
            </form>

            <hr style="margin: 30px 0;">

            <form action="<?= base_url('/account/update-email') ?>" method="post">
                <label for="email">Ganti Email</label>
                <input type="email" name="email" required value="<?= session()->get('email') ?>">
                <button type="submit">Simpan Email</button>
            </form>

            <hr style="margin: 30px 0;">

            <form action="<?= base_url('/account/update-password') ?>" method="post">
                <div class="input-group mb-3">
                    <label for="currentPassword">Password Lama:</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Password Lama" id="currentPassword" style="width: 778px;">
                    <span class="input-group-text" onclick="togglePassword('currentPassword', this)">
                        <i class="bi bi-eye-slash"></i>
                    </span>
                </div>
                <div class="input-group mb-3">
                    <label for="newPassword">Password Baru:</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Password Baru" id="newPassword" style="width: 778px;">
                    <span class="input-group-text" onclick="togglePassword('newPassword', this)">
                        <i class="bi bi-eye-slash"></i>
                    </span>
                </div>
                <div class="input-group mb-3">
                    <label for="confirmPassword">Confirmasi Password:</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" id="confirmPassword" style="width: 778px;">
                    <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                        <i class="bi bi-eye-slash"></i>
                    </span>
                </div>

                <button type="submit">Simpan Password</button>
            </form>
        </div>
    </div>

    <script src="/js/script.js"></script>
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