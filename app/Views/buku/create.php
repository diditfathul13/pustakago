<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow border-0 p-4">
        <h4 class="fw-bold mb-4">Input Data Buku Baru</h4>
        <form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
    <label class="form-label text-uppercase fw-bold" style="font-size: 0.75rem;">Kategori Buku</label>
    <select name="kategori" class="form-select" required>
        <option value="" selected disabled>Pilih Kategori</option>
        <option value="Novel">Novel</option>
        <option value="Horor">Horor</option>
        <option value="Romance">Romance</option>
        <option value="Sains">Sains</option>
        <option value="Sejarah">Sejarah</option>
        <option value="Manajemen">Manajemen</option>
    </select>
</div>
                <div class="col-md-6 mb-3">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
    <label class="fw-bold">Jumlah Buku (Stok)</label>
    <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 10" required>
</div>
                <div class="col-md-6 mb-3">
                    <label>Cover</label>
                    <input type="file" name="cover" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary px-5">Simpan Buku</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>