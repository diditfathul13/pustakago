<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling agar background terlihat jelas tanpa terhalang kotak putih besar */
    .katalog-container {
        padding-top: 30px;
        position: relative;
        z-index: 10;
    }

    /* Filter Category Pills */
    .filter-wrapper {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        padding: 15px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 30px;
    }

    .btn-filter {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.4);
        color: white;
        text-decoration: none;
        text-transform: uppercase;
    }

    .btn-filter:hover, .btn-filter.active {
        background: #38bdf8;
        border-color: #38bdf8;
        color: #0f172a;
        box-shadow: 0 5px 15px rgba(56, 189, 248, 0.4);
    }

    .book-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .cover-wrapper {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-category {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #0f172a;
        color: #38bdf8;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }

    .search-bar {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        color: white;
        border-radius: 50px;
        padding: 12px 25px;
    }

    .search-bar::placeholder { color: rgba(255, 255, 255, 0.6); }
    .search-bar:focus { 
        background: rgba(255, 255, 255, 0.25); 
        color: white; 
        border-color: #38bdf8;
        box-shadow: none;
    }
</style>

<div class="container katalog-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-white fw-bold mb-0">KOLEKSI BUKU</h2>
            <p class="text-white-50 small">Filter berdasarkan kategori atau cari judul favoritmu.</p>
        </div>
        <div class="d-flex gap-2">
            <?php if(session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku/print') ?>" target="_blank" class="btn btn-light rounded-pill px-3 shadow-sm"><i class="bi bi-printer"></i></a>
                <a href="<?= base_url('buku/create') ?>" class="btn btn-info rounded-pill px-4 shadow-sm fw-bold">+ TAMBAH</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-4 justify-content-center">
        <div class="col-md-8">
            <form action="" method="get">
                <div class="input-group">
                    <input type="text" name="cari" class="form-control search-bar" placeholder="Ketik judul buku atau penulis..." value="<?= $cari ?? '' ?>">
                    <button class="btn btn-info rounded-pill px-4 ms-2 fw-bold" type="submit"><i class="bi bi-search me-1"></i> CARI</button>
                </div>
            </form>
        </div>
    </div>

    <div class="filter-wrapper shadow-lg">
        <a href="<?= base_url('buku') ?>" class="btn-filter <?= !isset($_GET['kategori']) ? 'active' : '' ?>">SEMUA</a>
        <?php 
            // Daftar ENUM sesuai database
            $categories = ['Novel', 'Horor', 'Romance', 'Sains', 'Sejarah', 'Manajemen']; 
            foreach($categories as $cat): 
                $isActive = (isset($_GET['kategori']) && $_GET['kategori'] == $cat) ? 'active' : '';
        ?>
            <a href="<?= base_url('buku?kategori='.$cat) ?>" class="btn-filter <?= $isActive ?>"><?= $cat ?></a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php if(count($buku) > 0): foreach($buku as $b): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card">
                <div class="cover-wrapper">
                    <?php if($b['cover']): ?>
                        <img src="<?= base_url('uploads/'.$b['cover']) ?>" class="cover-img" alt="<?= $b['judul'] ?>">
                    <?php else: ?>
                        <div class="bg-secondary h-100 d-flex align-items-center justify-content-center text-white-50">No Cover</div>
                    <?php endif; ?>
                    <span class="badge-category"><?= $b['kategori'] ?></span>
                </div>

                <div class="card-body p-3">
                    <h6 class="fw-bold text-dark text-truncate mb-1" title="<?= $b['judul'] ?>"><?= $b['judul'] ?></h6>
                    <p class="text-muted small mb-2" style="font-size: 0.75rem;">Oleh: <span class="fw-bold"><?= $b['penulis'] ?></span></p>
                    
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-star-fill text-warning" style="font-size: 0.8rem;"></i>
                        <i class="bi bi-star-fill text-warning ms-1" style="font-size: 0.8rem;"></i>
                        <i class="bi bi-star-fill text-warning ms-1" style="font-size: 0.8rem;"></i>
                        <i class="bi bi-star-fill text-warning ms-1" style="font-size: 0.8rem;"></i>
                        <i class="bi bi-star-half text-warning ms-1" style="font-size: 0.8rem;"></i>
                        <span class="text-muted small ms-2" style="font-size: 0.7rem;">(4.5)</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-2 mb-3">
                        <div class="stok-text">
                            <small class="text-muted d-block" style="font-size: 0.65rem;">Stok Tersedia:</small>
                            <span class="<?= $b['tersedia'] > 0 ? 'text-success' : 'text-danger' ?> fw-bold">
                                <?= $b['tersedia'] ?> <small style="font-size: 0.7rem;">Buku</small>
                            </span>
                        </div>
                        <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-outline-dark btn-sm rounded-pill px-2 py-0" style="font-size: 0.7rem;">Detail</a>
                    </div>

                    <div class="d-grid gap-2">
                        <?php if(session()->get('role') == 'user'): ?>
                            <?php if($b['tersedia'] > 0): ?>
                                <a href="<?= base_url('peminjaman/ajukan/'.$b['id_buku']) ?>" class="btn btn-info rounded-pill fw-bold btn-sm py-2" onclick="return confirm('Pinjam buku ini?')">
                                    PINJAM SEKARANG
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary rounded-pill btn-sm disabled fw-bold">STOK HABIS</button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(session()->get('role') == 'admin'): ?>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-warning btn-sm text-white rounded-circle"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= base_url('buku/delete/'.$b['id_buku']) ?>" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('Hapus buku ini?')"><i class="bi bi-trash"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown display-1 text-white-50"></i>
                <h4 class="text-white mt-3">Buku tidak ditemukan...</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>