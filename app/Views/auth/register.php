<!DOCTYPE html>
<html>
<head>
    <title>Register | Aplikasi Tagihan Air</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            background: linear-gradient(135deg, #006dccff, #4facfe);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #4facfe;
            box-shadow: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .toggle-password {
            cursor: pointer;
        }

        .login-link {
            font-size: 0.9rem;
        }

        .input-group-text {
            background: none;
            border: none;
        }

        .bi-eye-slash {
            position: absolute;
            margin: 0 auto;
            margin-top: -55px;
            margin-left: 150px;
            color: #000;
        }
        .bi-eye {
            position: absolute;
            margin: 0 auto;
            margin-top: -55px;
            margin-left: 150px;
            color: #000;
        }

    </style>
</head>
<body class="animated">
    <!--
        PR add form input confirmasi password
        and icon eye and eye-slash
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
        <div class="row justify-content-center ">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-white p-4">
                    <div class="card-body">

                        <div class="logo-img">
                            <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="Logo-Bumdes">
                        </div>

                        <h3 class="text-left mb-4">Register</h3>

                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('/register') ?>" method="post">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= old('username') ?>">
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= old('email') ?>">
                            </div>

                            <div class="mb-3 position-relative">
                                <input type="password" class="form-control password-register" id="password" name="password" placeholder="Password" required>
                                <span class="input-group-text toggle-password" data-target="#password" style="background: none; border: none; position: absolute; margin-top: -5px; margin-left: 90px;">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>

                            <div class="mb-3 position-relative">
                                <input type="password" class="form-control password-register" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                                <span class="input-group-text toggle-password" data-target="#confirm_password" style="background: none; border: none; position: absolute; margin-top: -5px; margin-left: 90px;">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success">Register</button>
                            </div>
                        </form>

                        <div class="text-center login-link">
                            Sudah punya akun? <a href="<?= base_url('/login') ?>">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/js/animation.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButtons = document.querySelectorAll(".toggle-password");

        toggleButtons.forEach((btn) => {
            btn.addEventListener("click", function () {
            const input = document.querySelector(this.getAttribute("data-target"));
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
            });
        });

        document.querySelector("form").classList.add("fade-in");
    });
</script>
</body>
</html>
