<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php 
    // Normalisasi role agar pengecekan konsisten
    $role = strtolower(session()->get('role') ?? ''); 
?>

<style>
    /* Background Perpustakaan Elegan */
    body {
        background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
    }

    /* Overlay untuk menjaga kontras teks */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.5); /* Menggunakan warna dasar dashboard */
        z-index: -1;
    }

    .dashboard-container { padding-top: 8vh; padding-bottom: 50px; }

    .dashboard-title {
        color: white;
        text-shadow: 2px 4px 15px rgba(0,0,0,0.5);
        margin-bottom: 70px;
    }

    /* Card Styling */
    .stat-card {
        border: none;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: rgba(255, 255, 255, 0.95) !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    .stat-card:hover {
        transform: translateY(-15px);
        background: #ffffff !important;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5) !important;
    }

    .card-icon {
        width: 75px; height: 75px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.3rem;
        margin: -38px auto 15px;
        background: #0f172a; /* Slate 900 dashboard style */
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .card-title-text {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-action {
        border-radius: 12px;
        font-weight: 800;
        padding: 12px;
        background: #0f172a;
        color: #38bdf8;
        border: none;
        transition: 0.3s;
        text-decoration: none;
        display: block;
        width: 100%;
        margin-top: 20px;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .btn-action:hover {
        background: #38bdf8;
        color: #0f172a;
        box-shadow: 0 8px 15px rgba(56, 189, 248, 0.3);
    }

    .section-divider {
        width: 60px; height: 4px; 
        background: #38bdf8; 
        margin: 15px auto;
        border-radius: 10px;
    }
</style>

<div class="container dashboard-container text-center">
    <div class="dashboard-title">
        <h1 class="fw-extrabold display-3 mb-0">PUSTAKAGO</h1>
        <div class="section-divider"></div>
        <p class="fs-6 fw-bold text-uppercase opacity-75" style="letter-spacing: 5px;">Modern Library System</p>
    </div>

    <div class="row g-5 justify-content-center">
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4 pt-0 text-center">
                    <div class="card-icon" style="color: #38bdf8;"><i class="bi bi-book-half"></i></div>
                    <div class="card-title-text">Koleksi</div>
                    <p class="text-muted small mt-2">Cari & Telusuri Buku</p>
                    <a href="<?= base_url('buku') ?>" class="btn-action">LIHAT BUKU</a>
                </div>
            </div>
        </div>

        <?php if ($role == 'user') : ?>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4 pt-0 text-center">
                    <div class="card-icon" style="color: #fbbf24;"><i class="bi bi-clock-history"></i></div>
                    <div class="card-title-text">Aktivitas</div>
                    <p class="text-muted small mt-2">Riwayat Peminjaman</p>
                    <a href="<?= base_url('riwayat') ?>" class="btn-action text-warning">RIWAYAT</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4 pt-0 text-center">
                    <div class="card-icon" style="color: #ec4899;"><i class="bi bi-person-badge"></i></div>
                    <div class="card-title-text">Profil</div>
                    <p class="text-muted small mt-2">Detail Akun Saya</p>
                    <a href="<?= base_url('profile') ?>" class="btn-action text-info">LIHAT PROFIL</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role == 'admin' || $role == 'petugas') : ?>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4 pt-0 text-center">
                    <div class="card-icon" style="color: #4ade80;"><i class="bi bi-arrow-repeat"></i></div>
                    <div class="card-title-text">Sirkulasi</div>
                    <p class="text-muted small mt-2">Kelola Pinjam & Kembali</p>
                    <a href="<?= base_url('peminjaman') ?>" class="btn-action text-success">KELOLA DATA</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role == 'admin') : ?>
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body p-4 pt-0 text-center">
                    <div class="card-icon" style="color: #c084fc;"><i class="bi bi-person-lock"></i></div>
                    <div class="card-title-text">Manajemen</div>
                    <p class="text-muted small mt-2">Data Akses Pengguna</p>
                    <a href="<?= base_url('users') ?>" class="btn-action text-purple" style="color: #c084fc !important;">USER DATA</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>