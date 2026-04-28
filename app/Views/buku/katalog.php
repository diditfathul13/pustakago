<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php 
    // Ambil role sekali saja biar gak ngetik session panjang-panjang
    $userRole = strtolower(session()->get('role') ?? ''); 
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6 text-white">
        <h2 class="fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Katalog Koleksi
        </h2>
        <p class="opacity-75 mb-2">Cari dan temukan buku favoritmu di PustakaGO</p>
        
        <?php if ($userRole == 'admin' || $userRole == 'petugas') : ?>
            <a href="<?= base_url('buku/create') ?>" class="btn btn-success shadow-sm rounded-pill">
                <i class="bi bi-plus-circle me-1"></i> Tambah Buku Baru
            </a>
        <?php endif; ?>
    </div>
    
    <div class="col-md-6 mt-3 mt-md-0">
        <form action="" method="get">
            <div class="input-group shadow-lg">
                <input type="text" name="cari" class="form-control border-0" placeholder="Ketik judul, penulis atau kategori..." value="<?= esc($cari) ?>">
                <button class="btn btn-primary px-4" type="submit">Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($buku)): ?>
        <div class="col-12 text-center my-5 text-white">
            <i class="bi bi-search" style="font-size: 3rem;"></i>
            <p class="mt-3">Buku tidak ditemukan...</p>
        </div>
    <?php endif; ?>

    <?php foreach ($buku as $b) : ?>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow card-hover overflow-hidden" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
            <div class="position-relative">
                <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?: 'default.jpg')) ?>" 
                     class="card-img-top" style="height: 300px; object-fit: cover;">
                <span class="badge position-absolute top-0 end-0 m-2 bg-primary shadow"><?= $b['kategori'] ?></span>
            </div>
            
            <div class="card-body d-flex flex-column">
                <h6 class="fw-bold mb-1 text-truncate" title="<?= $b['judul'] ?>"><?= $b['judul'] ?></h6>
                <p class="text-muted small mb-3">Penulis: <?= $b['penulis'] ?></p>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-start">
                        <small class="text-muted d-block">Tersedia:</small>
                       <span class="fw-bold <?= ($b['tersedia'] > 0) ? 'text-success' : 'text-danger' ?>">
    <?= ($b['tersedia'] ?? 0) ?> 
</span> 
                    </div>
                    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-sm btn-outline-info rounded-pill">Detail</a>
                </div>

                <div class="mt-auto">
                    <?php if ($userRole == 'user' || $userRole == 'member') : ?>
                        <?php if ($b['tersedia'] > 0) : ?>
                            <a href="<?= base_url('peminjaman/ajukan/' . $b['id_buku']) ?>" class="btn btn-primary w-100 rounded-pill">
                                <i class="bi bi-hand-index-thumb me-1"></i> Pinjam Buku
                            </a>
                        <?php else : ?>
                            <button class="btn btn-secondary w-100 rounded-pill disabled">Stok Habis</button>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($userRole == 'admin' || $userRole == 'petugas') : ?>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-sm btn-warning text-white flex-fill rounded-pill">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>" class="btn btn-sm btn-danger flex-fill rounded-pill" onclick="return confirm('Hapus buku ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                       
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .card-hover { transition: 0.3s; }
    .card-hover:hover { 
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
    }
    .btn-sm { font-size: 0.8rem; }
</style>

<?= $this->endSection() ?>