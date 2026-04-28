<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    // Nama tabel di database
    protected $table      = 'buku';
    
    // Primary key tabel
    protected $primaryKey = 'id_buku';

    // Kolom yang boleh dimanipulasi (Insert/Update)
    // Sesuai dengan database kamu: isbn, judul, kategori, penulis, jumlah, tersedia, deskripsi, cover
   // Harus ada kolom tersedia & jumlah di sini!
protected $allowedFields = ['isbn', 'judul', 'kategori', 'penulis', 'jumlah', 'tersedia', 'deskripsi', 'cover'];

    // Fungsi untuk fitur pencarian di Katalog
    public function cariData($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('isbn', $keyword)
                    ->orLike('kategori', $keyword)
                    ->orLike('penulis', $keyword) // Min tambahkan penulis juga biar makin lengkap carinya
                    ->findAll();
    }

    // Fungsi tambahan jika kamu butuh ambil data buku yang masih tersedia saja
    public function getBukuTersedia()
    {
        return $this->where('tersedia >', 0)->findAll();
    }
}