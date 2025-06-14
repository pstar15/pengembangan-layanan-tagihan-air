<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            color: #000;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: #2A7B9B;
            background: radial-gradient(circle,rgba(42, 123, 155, 1) 0%, rgba(87, 147, 199, 1) 50%, rgba(127, 83, 237, 1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            animation: slideFadeIn 1s ease;
        }
        h2 {
            color: #000;
        }
        input, button {
            display: block;
            width:83%;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin: 10px 0;
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
        <h2>Register</h2>
        <form action="/register" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="input-group-text toggle-password" data-target="#password">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            <div class="input-group">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmasi Password" required>
                <span class="input-group-text toggle-password" data-target="#confirm_password">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="link-login-register">Sudah punya akun? <a href="/login">Login</a></p>
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

            // Optional: Animasi fade in
            document.querySelector("form").classList.add("fade-in");
        });
    </script>
</body>
</html>
