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
            margin-left: 190px;
            margin-right: 0;
        }

        .bi-eye {
            margin-left: 190px;
            margin-right: 0;
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
                        <h3 class="text-center mb-4">Login</h3>

                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('/login') ?>" method="post">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= old('email') ?>">
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <span class="btn btn-outline-secondary toggle-password" type="button" style="background: none; border: none; position: absolute; margin-top: 5px; margin-left: 50px;">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" name="remember" value="1" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3 register-link">
                            Belum punya akun? <a href="<?= base_url('/register') ?>">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="/js/animation.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.querySelector(".toggle-password");
        const passwordInput = document.querySelector("#password");
        const icon = document.querySelector("#togglePasswordIcon");

        toggleBtn.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            icon.classList.toggle("bi-eye");
            icon.classList.toggle("bi-eye-slash");
        });
    });
</script>
</body>
</html>
