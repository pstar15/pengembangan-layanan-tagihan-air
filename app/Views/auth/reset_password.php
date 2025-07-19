<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Reset Password | Aplikasi Tagihan Air</title>
    <style>
        body {
            background: linear-gradient(135deg, #006dccff, #4facfe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-card {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-control:focus {
            border-color: #4facfe;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .toggle-password {
            cursor: pointer;
            background: none;
            border: none;
            position: absolute;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="form-title">Reset Password Baru</div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/resetProcess') ?>" method="post">
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password baru" required>
                <span class="input-group-text toggle-password" type="button" data-target="#password">
                    <i class="bi bi-eye-slash" style="background: none; border: none; position: absolute; margin-left: 300px; margin-top: -46px;"></i>
                </span>
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Konfirmasi password" required>
                <span class="input-group-text toggle-password" type="button" data-target="#confirm_password">
                    <i class="bi bi-eye-slash" style="background: none; border: none; position: absolute; margin-left: 300px; margin-top: -46px;"></i>
                </span>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="<?= base_url('/login') ?>" class="text-decoration-none">← Kembali ke Login</a>
        </div>
    </div>

<script src="/js/script.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll(".toggle-password");

        toggles.forEach(function (toggle) {
            toggle.addEventListener("click", function () {
                const targetSelector = toggle.getAttribute("data-target");
                const input = document.querySelector(targetSelector);
                const icon = toggle.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("bi-eye-slash", "bi-eye");
                } else {
                    input.type = "password";
                    icon.classList.replace("bi-eye", "bi-eye-slash");
                }
            });
        });
    });
</script>
</body>
</html>