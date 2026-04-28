<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .profile-container {
        padding-top: 50px;
        position: relative;
        z-index: 10;
    }
    .profile-card {
        background: #1e293b; /* Navy Dark sesuai tema sirkulasi */
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        overflow: hidden;
    }
    .profile-header {
        background: linear-gradient(135deg, #0ea5e9, #6366f1);
        height: 120px;
    }
    .profile-avatar-wrapper {
        margin-top: -60px;
        text-align: center;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid #1e293b;
        object-fit: cover;
        background: #334155;
    }
    .info-label {
        color: #38bdf8; /* Cyan sesuai warna header tabel */
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .info-value {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .badge-role {
        background: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }
</style>

<div class="container profile-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-card">
                <div class="profile-header"></div>
                
                <div class="profile-avatar-wrapper">
                    <?php 
                        $foto_path = (!empty($user['foto'])) ? 'uploads/users/' . $user['foto'] : 'assets/img/avatar.png';
                        $foto_url = base_url($foto_path);
                    ?>
                    <img src="<?= $foto_url ?>" class="profile-avatar" alt="User Photo">
                </div>

                <div class="p-5 text-center">
                    <h3 class="text-white fw-bold mb-1"><?= $user['nama'] ?? 'Nama User' ?></h3>
                    <div class="mb-4">
                        <span class="badge-role"><?= $user['role'] ?? 'Member' ?></span>
                    </div>
                    
                    <hr class="border-secondary opacity-25">

                    <div class="row text-start mt-4">
                        <div class="col-6">
                            <p class="info-label mb-1">Username</p>
                            <p class="info-value">@<?= $user['username'] ?? '-' ?></p>
                        </div>
                        <div class="col-6">
                            <p class="info-label mb-1">Status Akun</p>
                            <p class="info-value text-success">Aktif</p>
                        </div>
                        <div class="col-12 mt-2 text-center">
                            <p class="text-white-50 small mb-3 italic">Data ini sinkron dengan database PustakaGO</p>
                            <a href="<?= base_url('users/edit/' . ($user['id_user'] ?? '')) ?>" class="btn btn-info w-100 rounded-pill fw-bold py-2 shadow">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?= base_url('dashboard') ?>" class="text-white-50 text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>