<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi style dengan dashboard admin */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        color: #0e0303;
        border: 1px solid #fecaca;
    }
    .table thead th {
        background-color: #1e293b;
        color: #38bdf8;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    /* Animasi pulse untuk peringatan admin */
    .alert-admin {
        background: #fff1f2;
        border-left: 4px solid #e11d48;
        border-radius: 10px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.01); }
        100% { transform: scale(1); }
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman Saya</h2>
        <span class="badge bg-light text-dark rounded-pill px-3 py-2 shadow-sm">Total: <?= count($riwayat) ?> Transaksi</span>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-3">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card glass-card shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Buku</th>
                        <th class="text-center">Tanggal Pinjam</th>
                        <th class="text-center">Batas Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($riwayat)): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted small italic">Anda belum memiliki riwayat transaksi peminjaman.</td></tr>
                    <?php else: ?>
                        <?php foreach($riwayat as $r): 
                            $is_late = false;
                            $denda_display = 0;
                            
                            if ($r['tanggal_kembali'] && $r['tanggal_kembali'] != '0000-00-00') {
                                $tgl_kembali = new \DateTime($r['tanggal_kembali']);
                                $tgl_sekarang = new \DateTime(date('Y-m-d'));
                                
                                if ($r['status'] == 'dipinjam' && $tgl_sekarang > $tgl_kembali) {
                                    $is_late = true;
                                    $selisih = $tgl_sekarang->diff($tgl_kembali);
                                    $hari_terlambat = $selisih->days;
                                    $denda_display = $hari_terlambat * 5000;
                                } else {
                                    $denda_display = $r['denda'];
                                }
                            }
                        ?>
                        <tr>
                            <td class="ps-4">
                                <strong class="text-dark d-block"><?= $r['judul'] ?></strong>
                                <small class="text-primary fw-bold">ID: #<?= $r['id_pinjam'] ?></small>

                                <?php if (!empty($r['pesan_admin']) && $r['status_bayar'] !== 'lunas'): ?>
                                    <div class="alert-admin p-2 mt-2 shadow-sm">
                                        <small class="text-danger fw-bold d-block"><i class="bi bi-megaphone-fill me-1"></i> Pesan Admin:</small>
                                        <small class="text-dark italic">"<?= $r['pesan_admin'] ?>"</small>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="date-box">
                                    <?= $r['tanggal_pinjam'] ? date('d M Y', strtotime($r['tanggal_pinjam'])) : '-' ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if ($r['tanggal_kembali'] && $r['tanggal_kembali'] != '0000-00-00') : ?>
                                    <div class="date-box <?= $is_late ? 'return-late' : '' ?>">
                                        <?= date('d M Y', strtotime($r['tanggal_kembali'])) ?>
                                    </div>
                                <?php else : ?>
                                    <span class="text-muted small italic">Menunggu Approval Admin</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($r['status'] == 'pending'): ?>
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">Verifikasi</span>
                                <?php elseif($r['status'] == 'dipinjam'): ?>
                                    <span class="badge bg-success px-3 rounded-pill">Dipinjam</span>
                                <?php elseif($r['status'] == 'menunggu_kembali'): ?>
                                    <span class="badge bg-info text-white px-3 rounded-pill">Proses Kembali</span>
                                <?php elseif($r['status'] == 'kembali'): ?>
                                    <span class="badge bg-secondary px-3 rounded-pill">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($denda_display > 0): ?>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="text-danger fw-bold">Rp <?= number_format($denda_display, 0, ',', '.') ?></span>
                                        
                                        <?php if($r['status_bayar'] == 'belum'): ?>
                                            <button type="button" class="btn btn-sm btn-primary mt-1 py-1 px-2" style="font-size: 0.7rem;" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $r['id_pinjam'] ?>">
                                                <i class="bi bi-wallet2"></i> Bayar DANA
                                            </button>
                                        <?php elseif($r['status_bayar'] == 'proses'): ?>
                                            <span class="badge bg-info mt-1" style="font-size: 0.6rem;">Cek Verifikasi</span>
                                        <?php elseif($r['status_bayar'] == 'lunas'): ?>
                                            <span class="badge bg-success mt-1" style="font-size: 0.6rem;">LUNAS</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($r['status'] == 'dipinjam'): ?>
                                    <a href="<?= base_url('peminjaman/kembalikan/'.$r['id_pinjam']) ?>" 
                                       class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                       onclick="return confirm('Apakah ingin mengembalikan buku ini?')">
                                        Kembalikan
                                    </a>
                                <?php else: ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($riwayat as $r): ?>
    <?php 
        $denda_modal = 0;
        if ($r['tanggal_kembali'] && $r['tanggal_kembali'] != '0000-00-00') {
            $tgl_kembali = new \DateTime($r['tanggal_kembali']);
            $tgl_sekarang = new \DateTime(date('Y-m-d'));
            if ($r['status'] == 'dipinjam' && $tgl_sekarang > $tgl_kembali) {
                $selisih = $tgl_sekarang->diff($tgl_kembali);
                $denda_modal = $selisih->days * 5000;
            } else {
                $denda_modal = $r['denda'];
            }
        }
    ?>
    <?php if($denda_modal > 0 && $r['status_bayar'] == 'belum'): ?>
    <div class="modal fade" id="modalBayar<?= $r['id_pinjam'] ?>" tabindex="-1" aria-labelledby="label<?= $r['id_pinjam'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <form action="<?= base_url('peminjaman/bayar_dana/'.$r['id_pinjam']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-header border-0 bg-primary text-white p-4" style="border-radius: 20px 20px 0 0;">
                        <h5 class="modal-title fw-bold" id="label<?= $r['id_pinjam'] ?>"><i class="bi bi-phone-fill me-2"></i>Pembayaran DANA</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <p class="text-muted mb-1">Total Denda Anda</p>
                        <h3 class="fw-bold text-danger mb-4">Rp <?= number_format($denda_modal, 0, ',', '.') ?></h3>
                        
                        <div class="card bg-light border-0 p-3 mb-4 rounded-4">
                            <small class="text-muted d-block mb-2">Scan atau Transfer ke nomor DANA:</small>
                            <h4 class="fw-bold text-primary mb-0">0812-3456-7890</h4>
                            <small class="fw-bold text-dark">A/N PERPUSTAKAAN DIGITAL</small>
                        </div>

                        <div class="text-start">
                            <label class="form-label fw-bold small">UPLOAD BUKTI TRANSFER</label>
                            <input type="file" name="bukti_bayar" class="form-control rounded-3" accept="image/*" required>
                            <small class="text-muted" style="font-size: 0.7rem;">*Gunakan format JPG/PNG.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<?= $this->endSection() ?>