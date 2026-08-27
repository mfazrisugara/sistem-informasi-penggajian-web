<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Penggajian</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{

            margin:0;
            padding:0;

            background:linear-gradient(135deg,#198754,#20c997);

            height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

            font-family:Arial, Helvetica, sans-serif;

        }

        .login-card{

            width:420px;

            background:#fff;

            border-radius:15px;

            padding:35px;

            box-shadow:0 10px 25px rgba(0,0,0,.2);

        }

        .logo{

            text-align:center;

            margin-bottom:25px;

        }

        .logo i{

            font-size:60px;

            color:#198754;

        }

        .logo h3{

            margin-top:15px;

            font-weight:bold;

        }

        .logo p{

            color:#777;

            margin-bottom:0;

        }

        .form-control{

            height:48px;

        }

        .btn-login{

            background:#198754;

            color:white;

            height:48px;

            font-weight:bold;

        }

        .btn-login:hover{

            background:#157347;

            color:white;

        }

        .footer{

            margin-top:20px;

            text-align:center;

            color:#777;

            font-size:13px;

        }

    </style>

</head>

<body>

<div class="login-card">

    <div class="logo">

        <i class="fas fa-wallet"></i>

        <h3>Sistem Penggajian</h3>

        <p>Payroll Management System</p>

    </div>

    <form action="proses_login.php" method="POST">

        <div class="mb-3">

            <label class="form-label">

                <i class="fas fa-user"></i>

                Username

            </label>

            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Masukkan Username"
                   required>

        </div>

        <div class="mb-4">

            <label class="form-label">

                <i class="fas fa-lock"></i>

                Password

            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Masukkan Password"
                   required>

        </div>

        <button type="submit" class="btn btn-login w-100">

            <i class="fas fa-right-to-bracket"></i>

            Login

        </button>

    </form>

    <div class="footer">

        © <?= date('Y'); ?> Sistem Informasi Penggajian

    </div>

</div>

</body>

</html>