<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling utama agar tidak tertutup background */
    .sirkulasi-container {
        position: relative;
        z-index: 10;
        padding-top: 30px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        margin-top: 20px;
    }

    .modal { z-index: 1060 !important; }
    .modal-backdrop { z-index: 1050 !important; }

    .table thead th {
        background-color: #1e293b;
        color: #38bdf8;
        border: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 18px 15px;
        text-align: center;
    }

    .table thead th.text-start { text-align: left; }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .text-denda {
        font-weight: 800;
        color: #e11d48;
        font-size: 0.9rem;
    }

    .date-box {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 8px;
        background: #f1f5f9;
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
    }

    .date-box.return-late {
        background: #fee2e2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .btn-action-group {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .main-title {
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .modal-content {
        border-radius: 20px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }

    /* Styling Bukti Transfer */
    .img-bukti-admin {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #22c55e;
        transition: transform 0.2s;
        cursor: pointer;
    }
    .img-bukti-admin:hover {
        transform: scale(1.2);
    }
</style>

<div class="container sirkulasi-container">
    <div class="d-flex justify-content-between align-items-end mb-2 px-2">
        <div>
            <h2 class="main-title fw-bold mb-0"><i class="bi bi-arrow-left-right me-2"></i>Sirkulasi Peminjaman</h2>
            <p class="text-white-50 mb-0">Kelola data peminjaman dan verifikasi denda DANA</p>
        </div>
        <div class="text-end">
            <span class="badge bg-info p-2 px-4 rounded-pill shadow-lg border border-white border-opacity-25">Total: <?= count($pinjaman) ?> Data</span>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-3">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card glass-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 text-start" style="width: 20%;">Judul Buku</th>
                        <th class="text-start" style="width: 15%;">Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda (Rp 5000/hari)</th>
                        <th>Bukti bayar/ Tagih</th> 
                        <th>Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($pinjaman)): ?>
                        <tr><td colspan="8" class="text-center py-5 text-muted small italic">Belum ada data transaksi peminjaman.</td></tr>
                    <?php else: ?>
                        <?php foreach($pinjaman as $p): 
                            $is_late = false;
                            if ($p['status'] == 'dipinjam' && !empty($p['tanggal_kembali'])) {
                                if (new \DateTime(date('Y-m-d')) > new \DateTime($p['tanggal_kembali'])) $is_late = true;
                            }
                        ?>
                        <tr>
                            <td class="ps-4 text-start">
                                <span class="fw-bold d-block text-dark" style="font-size: 0.9rem; line-height: 1.2;"><?= $p['judul'] ?></span>
                                <small class="text-primary fw-semibold">ID: #<?= $p['id_pinjam'] ?></small>
                                <?php if(!empty($p['pesan_admin'])): ?>
                                    <div class="mt-1"><span class="badge bg-danger" style="font-size: 0.6rem;">Peringatan Terkirim</span></div>
                                <?php endif; ?>
                            </td>
                            <td class="text-start">
                                <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;"><?= $p['nama_peminjam'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="date-box"><?= date('d/m/y', strtotime($p['tanggal_pinjam'])) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="date-box <?= $is_late ? 'return-late' : '' ?>">
                                    <?= date('d/m/y', strtotime($p['tanggal_kembali'])) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if($p['status'] == 'pending'): ?>
                                    <span class="status-badge bg-warning text-dark">Antri</span>
                                <?php elseif($p['status'] == 'dipinjam'): ?>
                                    <span class="status-badge bg-success text-white">dipinjam</span>
                                <?php elseif($p['status'] == 'menunggu_kembali'): ?>
                                    <span class="status-badge bg-info text-white">kembali</span>
                                <?php elseif($p['status'] == 'kembali'): ?>
                                    <span class="status-badge bg-secondary text-white">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($p['denda'] > 0): ?>
                                    <span class="text-denda d-block">Rp <?= number_format($p['denda'], 0, ',', '.') ?></span>
                                    <span class="badge bg-<?= $p['status_bayar'] == 'lunas' ? 'success' : 'danger' ?>" style="font-size: 0.6rem;"><?= strtoupper($p['status_bayar']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small fw-bold">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if($p['status_bayar'] == 'proses'): ?>
                                    <a href="<?= base_url('uploads/bukti_bayar/'.$p['bukti_bayar']) ?>" target="_blank">
                                        <img src="<?= base_url('uploads/bukti_bayar/'.$p['bukti_bayar']) ?>" class="img-bukti-admin shadow-sm" title="Klik untuk lihat bukti transfer">
                                    </a>
                                <?php elseif($p['denda'] > 0 && $p['status_bayar'] == 'belum'): ?>
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm px-3" style="font-size: 0.7rem;" data-bs-toggle="modal" data-bs-target="#modalTagih<?= $p['id_pinjam'] ?>">
                                        <i class="bi bi-megaphone-fill"></i> Tagih
                                    </button>
                                <?php elseif($p['status_bayar'] == 'lunas'): ?>
                                    <span class="text-success fw-bold" style="font-size: 0.75rem;"><i class="bi bi-patch-check-fill"></i> LUNAS</span>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center pe-3">
                                <div class="btn-action-group">
                                    <?php if($p['status_bayar'] == 'proses'): ?>
                                        <a href="<?= base_url('peminjaman/verifikasi_bayar/'.$p['id_pinjam']) ?>" class="btn btn-success btn-sm shadow-sm" onclick="return confirm('Konfirmasi denda sudah masuk ke DANA?')">
                                            <i class="bi bi-check-all"></i> Konfirmasi
                                        </a>
                                    <?php endif; ?>

                                    <?php if($p['status'] == 'pending'): ?>
                                        <button class="btn btn-success btn-sm px-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalApprove<?= $p['id_pinjam'] ?>">Setuju</button>
                                    
                                    <?php elseif($p['status'] == 'menunggu_kembali'): ?>
                                        <?php if($p['denda'] > 0 && $p['status_bayar'] != 'lunas'): ?>
                                            <button class="btn btn-primary btn-sm px-2 fw-bold shadow-sm opacity-75" data-bs-toggle="modal" data-bs-target="#modalWarningDenda<?= $p['id_pinjam'] ?>">Terima</button>
                                        <?php else: ?>
                                            <a href="<?= base_url('peminjaman/konfirmasi_kembali/'.$p['id_pinjam']) ?>" class="btn btn-primary btn-sm px-2 fw-bold shadow-sm">Terima</a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <a href="<?= base_url('peminjaman/hapus/'.$p['id_pinjam']) ?>" class="btn btn-outline-danger btn-sm shadow-sm" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($pinjaman as $p): ?>
    <div class="modal fade" id="modalWarningDenda<?= $p['id_pinjam'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body p-5 text-center">
                    <div class="text-danger mb-3">
                        <i class="bi bi-exclamation-octagon-fill" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Denda Belum Lunas!</h4>
                    <p class="text-muted">Buku tidak dapat diterima karena <strong><?= $p['nama_peminjam'] ?></strong> belum melunasi denda sebesar <span class="text-danger fw-bold">Rp <?= number_format($p['denda'], 0, ',', '.') ?></span>.</p>
                    <hr>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger fw-bold py-2 rounded-pill" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalTagih<?= $p['id_pinjam'] ?>">
                            <i class="bi bi-megaphone me-2"></i>Tagih Denda Sekarang
                        </button>
                        <button type="button" class="btn btn-light fw-bold py-2 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTagih<?= $p['id_pinjam'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('peminjaman/tagih_denda/'.$p['id_pinjam']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header border-0 bg-danger text-white">
                        <h5 class="modal-title fw-bold">Kirim Peringatan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <label class="form-label fw-bold small text-dark">PESAN UNTUK USER</label>
                        <textarea name="pesan_admin" class="form-control" rows="4">Mohon maaf, buku belum bisa kami terima. Silakan lunasi denda Anda terlebih dahulu sebesar Rp <?= number_format($p['denda'], 0, ',', '.') ?> melalui menu Bayar DANA di riwayat peminjaman. Terima kasih.</textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold">Kirim Notifikasi Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if($p['status'] == 'pending'): ?>
    <div class="modal fade" id="modalApprove<?= $p['id_pinjam'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('peminjaman/approve/'.$p['id_pinjam']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header border-0 bg-dark text-white">
                        <h5 class="modal-title fw-bold">Approve Pinjaman</h5>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">TANGGAL PINJAM</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">DEADLINE KEMBALI</label>
                            <input type="date" name="tanggal_kembali" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">Konfirmasi Pinjam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<?= $this->endSection() ?>