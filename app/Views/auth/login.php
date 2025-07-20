<!DOCTYPE html>
<html>
<head>
    <title>Login | Aplikasi Tagihan Air</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            background: linear-gradient(135deg, #006dccff, #4facfe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4facfe;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .register-link {
            font-size: 0.9rem;
        }

        .bi-eye-slash {
            position: absolute;
            margin: 0 auto;
            margin-top: -45px;
            margin-left: 190px;
            color: #000;
        }
        .bi-eye {
            position: absolute;
            margin: 0 auto;
            margin-top: -45px;
            margin-left: 190px;
            color: #000;
        }

        .toggle-password {
            position: absolute;
            right: 0;
            margin-top: 7px;
            margin-right: 220px;
            transform: translateY(-50%);
            cursor: pointer;
        }

    </style>
</head>
<body class="animated">
    <!--
        PR tetapkan email saat mendapatkan pesan error password,
        and tambahkan icon eye and eye-slash dari bootstrap
    -->

    <!-- alert -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success custom-alert" id="alertBox">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger custom-alert" id="alertBox">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-white p-4">
                    <div class="card-body">

                        <div class="logo-img">
                            <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="Logo-Bumdes">
                        </div>

                        <h3 class="text-left mb-4">Login</h3>

                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('/login') ?>" method="post">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= old('email') ?>">
                            </div>
                            <div class="mb-3 position-relative input-password-login">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <span class="toggle-password" type="button">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" name="remember" value="1" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3 register-link">
                            Belum punya akun? <a href="<?= base_url('/register') ?>">Register</a>
                        </div>

                        <div class="text-center">
                            <a href="<?= base_url('/forgot') ?>" class="btn btn-link text-decoration-none">
                                <i class="bi bi-shield-lock-fill me-1"></i> Lupa Password?
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <?php if (isset($reset_token)): ?>
                <div class="notification-wrapper">
                    <div class="notification-icon" id="notificationIcon" title="Pesan Reset">
                        <i class="bi bi-chat-square-text"></i>
                    </div>

                    <div class="notification-popup" id="notificationPopup">
                        <p><strong>🔐 Reset Password</strong></p>
                        <a href="<?= base_url('/auth/reset-password/' . $reset_token) ?>">
                            Klik di sini untuk atur ulang password Anda.
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

<script src="<?= base_url('js/script.js') ?>" defer></script>
</body>
</html>
