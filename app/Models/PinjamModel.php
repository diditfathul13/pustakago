<?php

namespace App\Models;

use CodeIgniter\Model;

class PinjamModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id_pinjam';

    // File: app/Models/PinjamModel.php
    protected $allowedFields = [
        'id_buku', 
        'nama_peminjam', 
        'telepon', 
        'tanggal_pinjam', 
        'tanggal_kembali', 
        'status', 
        'denda', 
        'bukti_bayar', 
        'status_bayar',
        'pesan_admin' // <--- SUDAH SAYA TAMBAHKAN DI SINI AGAR TIDAK ERROR LAGI
    ];

    public function getSemua() {
        return $this->select('peminjaman.*, buku.judul')
                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                    ->orderBy('id_pinjam', 'DESC')
                    ->findAll();
    }
}