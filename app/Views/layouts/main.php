<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PustakaGO | Digital Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nav-bg: rgba(15, 23, 42, 0.95);
            --accent-color: #38bdf8;
        }

        body {
            background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: white;
        }

        /* Overlay agar background tidak terlalu terang */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .navbar-custom {
            background: var(--nav-bg) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--accent-color) !important;
            letter-spacing: 1px;
        }

        .profile-nav-wrapper {
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 15px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Hilangkan Card Putih yang Menghalangi */
        .content-wrapper {
            padding-top: 20px;
            padding-bottom: 50px;
            animation: fadeIn 0.6s ease-out;
        }

        /* Animasi */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-book-half me-2"></i>PUSTAKAGO
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('dashboard*') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                            <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('buku*') ? 'active' : '' ?>" href="<?= base_url('buku') ?>">
                            <i class="bi bi-journal-text me-1"></i> Buku
                        </a>
                    </li>

                    <?php if (session()->get('role') == 'user') : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('peminjaman/riwayat*')) ? 'active' : '' ?>" href="<?= base_url('peminjaman/riwayat') ?>">
                                <i class="bi bi-clock-history me-1"></i> Riwayat Pinjam
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array(strtolower(session('role')), ['admin', 'petugas'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('peminjaman*') ? 'active' : '' ?>" href="<?= base_url('peminjaman') ?>">
                                <i class="bi bi-arrow-left-right me-1"></i> Peminjaman
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (strtolower(session('role')) == 'admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('users*') ? 'active' : '' ?>" href="<?= base_url('users') ?>">
                                <i class="bi bi-people me-1"></i> Users
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown profile-nav-wrapper">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-0" href="#" id="profileDrop" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?= session('nama') ?>&background=38bdf8&color=fff&bold=true" class="rounded-circle me-2" style="width:30px;">
                            <div class="d-none d-sm-block text-start">
                                <span class="d-block small fw-bold text-white"><?= session('nama') ?></span>
                                <span class="badge bg-info text-dark shadow-sm" style="font-size: 9px;"><?= strtoupper(session('role')) ?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <a href="<?= base_url('/backup') ?>" class="btn btn-success">Backup Database</a>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger fw-bold" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container content-wrapper">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>