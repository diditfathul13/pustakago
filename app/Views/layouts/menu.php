<ul class="nav flex-column mt-3">
    <li class="nav-item">
        <a class="nav-link" href="#">
            <b>Didit13
            </b>App <i class="bi bi-yelp"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/') ?>">
            <i class="bi bi-house"></i> <span>Dashboard</span>
        </a>
    </li>
    // Tombol logout 
<a href="<?= site_url('/logout') ?>"> Log Out </a>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/users') ?>">
            <i class="bi bi-people"></i> <span>Users</span>
        </a>
    </li>
        <?php $idu = session('id_user'); ?>
</ul>
<li class="nav-item mt-3">
    <span class="nav-link disabled">Masuk sebagai: <b><?= session('nama'); ?> (<?= session('role'); ?>)</b></span>
</li>


<center>
    <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" height="80" class="mt-3 rounded-circle" />
</center>