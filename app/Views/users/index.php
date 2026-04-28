<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling agar sinkron dengan tema Glassmorphism PustakaGO */
    .users-container {
        padding-top: 10px;
        animation: fadeIn 0.8s ease-in-out;
    }

    .glass-card-user {
        background: rgba(255, 255, 255, 0.9); /* Transparansi agar background tembus */
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        overflow: hidden;
    }

    .card-header-glass {
        background: rgba(30, 41, 59, 0.95); /* Warna slate gelap */
        padding: 20px 25px;
        color: #38bdf8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table thead th {
        background: transparent;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .img-user-circle {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #38bdf8;
        transition: 0.3s;
    }

    .img-user-circle:hover {
        transform: scale(1.1);
    }

    .badge-role {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 10px;
        letter-spacing: 0.5px;
    }

    .role-admin { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .role-petugas { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

    .btn-action-custom {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container users-container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <div>
            <h2 class="text-white fw-bold mb-0">Manajemen Users</h2>
            <p class="text-white-50 small">Kelola data administrator dan  user</p>
        </div>
        <?php if (strtolower(session()->get('role')) == 'admin') : ?>
            <a href="<?= base_url('users/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah User
            </a>
        <?php endif; ?>
    </div>

    <div class="glass-card-user">
        <div class="p-0">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 rounded-0 mb-0 py-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-center">
                        <tr>
                            <th width="70">NO</th>
                            <th class="text-start">PROFIL USER</th>
                            <th>USERNAME</th>
                            <th>JABATAN</th>
                            <th>FOTO</th>
                            <?php if (strtolower(session()->get('role')) == 'admin') : ?>
                                <th width="150">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1; foreach ($users as $u): ?>
                                <tr class="text-center">
                                    <td class="fw-bold text-muted"><?= $no++ ?></td>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark mb-0"><?= $u['nama'] ?></div>
                                        <small class="text-primary fw-bold" style="font-size: 10px;">ID: #USR-<?= $u['id_user'] ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border px-3 rounded-pill">@<?= $u['username'] ?></span>
                                    </td>
                                    <td>
                                        <?php $roleClass = (strtolower($u['role']) == 'admin') ? 'role-admin' : 'role-petugas'; ?>
                                        <span class="badge-role <?= $roleClass ?>">
                                            <i class="bi bi-shield-lock-fill me-1"></i> <?= strtoupper($u['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($u['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="img-user-circle shadow-sm">
                                        <?php else: ?>
                                            <img src="https://ui-avatars.com/api/?name=<?= $u['nama'] ?>&background=38bdf8&color=fff&bold=true" class="img-user-circle shadow-sm">
                                        <?php endif; ?>
                                    </td>
                                    
                                    <?php if (strtolower(session()->get('role')) == 'admin') : ?>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= base_url('users/edit/' . $u['id_user']) ?>" class="btn btn-warning btn-action-custom text-white shadow-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('users/delete/' . $u['id_user']) ?>" 
                                                   onclick="return confirm('Hapus user ini selamanya?')" 
                                                   class="btn btn-danger btn-action-custom shadow-sm">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted bg-white">
                                    <i class="bi bi-people display-1 opacity-25"></i>
                                    <p class="mt-3 fw-bold">Belum ada user terdaftar.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>