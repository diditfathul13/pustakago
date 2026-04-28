<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <a href="<?= base_url('buku') ?>" class="btn btn-secondary mb-3 shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>

    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px; background: rgba(255,255,255,0.9);">
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
                <img src="<?= base_url('uploads/buku/' . ($buku['cover'] ?: 'default.jpg')) ?>" 
                     class="img-fluid rounded shadow-lg" 
                     alt="<?= $buku['judul'] ?>"
                     style="max-height: 450px; object-fit: cover;">
            </div>

            <div class="col-md-8">
                <div class="card-body p-5">
                    <h1 class="fw-bold text-primary mb-1"><?= $buku['judul'] ?></h1>
                    <p class="text-muted fs-5 mb-4">Karya: <span class="text-dark fw-semibold"><?= $buku['penulis'] ?></span></p>
                    
                    <hr class="mb-4">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="text-muted d-block small">ISBN</label>
                            <p class="fw-bold fs-5"><?= $buku['isbn'] ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted d-block small">Kategori</label>
                            <span class="badge bg-info fs-6 px-3 rounded-pill"><?= $buku['kategori'] ?></span>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted d-block small">Stok Total</label>
                            <p class="fw-bold"><?= $buku['jumlah'] ?> Unit</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted d-block small">Status Ketersediaan</label>
                            <p class="fw-bold <?= ($buku['tersedia'] > 0) ? 'text-success' : 'text-danger' ?>">
                                <?= ($buku['tersedia'] ?? 0) ?> Unit Tersedia
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="text-muted d-block small">Deskripsi / Sinopsis</label>
                        <p class="text-secondary mt-2" style="text-align: justify; line-height: 1.6;">
                            <?= ($buku['deskripsi']) ?: 'Tidak ada deskripsi untuk buku ini.' ?>
                        </p>
                    </div>

                    <div class="mt-5 d-flex gap-2">
                        <?php if (session()->get('role') == 'Admin') : ?>
                            <a href="<?= base_url('buku/edit/' . $buku['id_buku']) ?>" class="btn btn-warning text-white px-4">
                                <i class="bi bi-pencil-square"></i> Edit Data
                            </a>
                        <?php endif; ?>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>