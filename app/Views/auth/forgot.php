<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <title>Lupa Password | Aplikasi Tagihan Air</title>
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
        }
    </style>
</head>
<body>
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
    <div class="auth-card">
        <div class="form-title">Lupa Password</div>

        <form action="<?= base_url('auth/forgotProcess') ?>" method="post">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="<?= base_url('/login') ?>" class="text-decoration-none">← Kembali ke Login</a>
        </div>
    </div>

    <script src="/js/script.js"></script>
</body>
</html>