<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <title>Reset Password | Aplikasi Tagihan Air</title>
    <style>
        body {
            background: linear-gradient(135deg, #006dccff, #4facfe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
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
            position: absolute;
            right: 0;
            margin-top: -27px;
            margin-right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="form-title text-black" style="text-align: left;">Reset Password Baru</div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/auth/resetProcess') ?>" method="post">
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password baru" required>
                <span class="input-group-text toggle-password" type="button" data-target="#password">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Konfirmasi password" required>
                <span class="input-group-text toggle-password" type="button" data-target="#confirm_password">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="<?= base_url('/login') ?>" class="text-decoration-none">← Kembali ke Login</a>
        </div>
    </div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
        const targetSelector = this.getAttribute('data-target');
        const targetInput = document.querySelector(targetSelector);
        const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
</body>
</html>