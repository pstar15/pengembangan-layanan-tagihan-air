<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <title>Register | Aplikasi Tagihan Air BUMDesa</title>
    <style>
        body {
            background: linear-gradient(135deg, #006dccff, #4facfe);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-register {
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
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

        .toggle-password {
            position: absolute;
            right: 0;
            margin-top: 1px;
            margin-right: 170px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body class="animated">
    
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-5 col-lg-4">
                <div class="card-register bg-white p-4">
                    <div class="card-body">

                        <div class="logo-img">
                            <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="Logo-Bumdes">
                        </div>

                        <h3 class="text-left mb-4 text-black">Register</h3>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>


                        <form action="<?= base_url('/auth/registerGoogleProcess') ?>" method="post">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= old('username') ?>">
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="password" name="password" class="form-control password-register" id="password" placeholder="Password" required>
                                <span class="input-group-text toggle-password" data-target="#password">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="password" name="confirm_password" class="form-control password-register" id="confirm_password" placeholder="Konfirmasi Password" required>
                                <span class="input-group-text toggle-password" data-target="#confirm_password">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success">Register</button>
                            </div>
                        </form>


                        <div class="text-center login-link text-black">
                            Sudah punya akun? <a href="<?= base_url('/login') ?>">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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