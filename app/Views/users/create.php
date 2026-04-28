<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | PustakaGO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            /* Background library yang sama dengan login agar serasi */
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        .card-register {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 0.5s ease-out;
        }

        .header-brand {
            background: #0f172a; /* Warna slate gelap dashboard & login */
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .header-brand i {
            font-size: 3rem;
            color: #38bdf8; /* Warna aksen biru PustakaGO */
            text-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }

        .header-brand h4 {
            font-weight: 800;
            letter-spacing: 2px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .form-label {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 11px 15px;
            border: 1.5px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .btn-submit {
            background: #38bdf8;
            color: #0f172a;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 800;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            background: #0ea5e9;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(56, 189, 248, 0.3);
        }

        .input-group-text {
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #64748b;
        }

        .has-icon .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-link a:hover {
            color: #38bdf8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="card-register">
        <div class="header-brand">
            <i class="bi bi-person-plus-fill"></i>
            <h4 class="mb-0">PUSTAKAGO</h4>
            <small class="opacity-50 fw-bold" style="font-size: 10px; letter-spacing: 1px;">DAFTAR MEMBER BARU</small>
        </div>

        <div class="card-body p-4">
            <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label text-uppercase">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama sesuai identitas" required autofocus>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-uppercase">Username</label>
                        <div class="input-group has-icon">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-uppercase">Role / Akses</label>
                        <select name="role" class="form-select" required>
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">user</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase">Password</label>
                    <div class="input-group has-icon">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Buat kata sandi" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase">Foto Profil <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-submit shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i> Konfirmasi Pendaftaran
                </button>

                <div class="back-link">
                    <a href="<?= base_url('/login') ?>">
                        <i class="bi bi-arrow-left me-1"></i> Sudah punya akun? Login
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>