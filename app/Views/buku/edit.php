<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Edit Data Buku</h3>
    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="coverLama" value="<?= $buku['cover'] ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="<?= $buku['isbn'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Judul Buku</label>
                    <input type="text" name="judul" class="form-control" value="<?= $buku['judul'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <?php $kats = ['Novel', 'Horor', 'Romance', 'Sains', 'Sejarah']; ?>
                        <?php foreach ($kats as $k): ?>
                            <option value="<?= $k ?>" <?= $buku['kategori'] == $k ? 'selected' : '' ?>><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?= $buku['penulis'] ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jumlah Buku (Stok)</label>
                    <input type="number"
                        name="tersedia"
                        class="form-control"
                        placeholder="Contoh: 10"
                        value="<?= $buku['tersedia'] ?>"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Ganti Cover (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="cover" class="form-control">
                </div>

            </div>
            <div class="col-md-6 mb-3">
                <label class="fw-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required><?= $buku['deskripsi'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary px-5 mt-3 shadow">Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>