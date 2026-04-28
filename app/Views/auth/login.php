<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PustakaGO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 360px; /* Diperkecil lebarnya */
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header-compact {
            background: #0f172a;
            padding: 25px 15px; /* Padding dikurangi */
            color: white;
            text-align: center;
        }

        .header-compact i {
            font-size: 2.5rem; /* Ikon dikecilkan */
            color: #38bdf8;
            display: block;
            margin-bottom: 5px;
        }

        .header-compact h5 { /* Font size diturunkan dari h4 ke h5 */
            font-weight: 800;
            letter-spacing: 2px;
            margin: 0;
            text-transform: uppercase;
        }

        .card-body {
            padding: 25px 30px; /* Padding konten lebih rapat */
        }

        .form-label {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            text-align: center;
        }

        .btn-login {
            background: #38bdf8;
            color: #0f172a;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 800;
            width: 100%;
            margin-top: 5px;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .btn-login:hover {
            background: #0ea5e9;
            transform: translateY(-1px);
        }

        .divider {
            margin: 15px 0;
            border-top: 1px solid #e2e8f0;
        }

        .footer-tools {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }

        .btn-register {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .btn-restore {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
            padding: 6px;
            border-radius: 8px;
            font-size: 0.7rem;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="header-compact">
            <i class="bi bi-book-half"></i>
            <h5>PUSTAKAGO</h5>
            <small class="opacity-50 fw-bold" style="font-size: 10px;">DIGITAL LIBRARY</small>
        </div>

        <div class="card-body">
            <?php if (session()->getFlashdata('error') || session()->getFlashdata('salahpw')): ?>
                <div class="alert alert-danger p-2 mb-3 border-0 small text-center" style="font-size: 0.75rem;">
                    <?= session()->getFlashdata('error') ?: session()->getFlashdata('salahpw') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/proses-login') ?>" method="post">
                <div class="mb-2">
                    <label class="form-label text-uppercase">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-login shadow-sm">
                    Sign In <i class="bi bi-arrow-right-short"></i>
                </button>
            </form>

            <div class="divider"></div>

            <div class="footer-tools">
                <a href="<?= base_url('users/create') ?>" class="btn-register">
                    Belum punya akun? <span class="text-primary">Daftar</span>
                </a>
                
                <a href="<?= base_url('restore') ?>" class="btn-restore">
                    <i class="bi bi-database-fill-gear"></i> Restore Database
                </a>
            </div>
        </div>
    </div>

</body>
</html>