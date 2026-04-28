<?php

namespace App\Controllers;

use App\Models\PinjamModel;
use App\Models\BukuModel;

class Peminjaman extends BaseController
{
    protected $pinjamanModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->pinjamanModel = new PinjamModel();
        $this->bukuModel = new BukuModel();
    }

    /**
     * ADMIN: Tampilan Sirkulasi Peminjaman (Dashboard Admin)
     */
    public function index()
    {
        $all_pinjaman = $this->pinjamanModel->select('peminjaman.*, buku.judul, buku.id_buku')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('id_pinjam', 'DESC')
            ->findAll();

        $today = new \DateTime(date('Y-m-d'));
        $denda_per_hari = 5000; 

        foreach ($all_pinjaman as &$p) {
            if ($p['status'] == 'dipinjam' && !empty($p['tanggal_kembali'])) {
                $batas_kembali = new \DateTime($p['tanggal_kembali']);
                
                if ($today > $batas_kembali) {
                    $selisih = $today->diff($batas_kembali);
                    $hari_terlambat = $selisih->days;
                    $total_denda = $hari_terlambat * $denda_per_hari;
                    
                    if ($p['denda'] != $total_denda) {
                        $p['denda'] = $total_denda;
                        $this->pinjamanModel->update($p['id_pinjam'], ['denda' => $total_denda]);
                    }
                }
            }
        }

        $data = [
            'pinjaman' => $all_pinjaman,
            'cari'     => '' 
        ];

        return view('peminjaman/index', $data);
    }

    public function ajukan($id_buku)
    {
        $buku = $this->bukuModel->find($id_buku);
        if ($buku['tersedia'] <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        $this->pinjamanModel->save([
            'id_buku'         => $id_buku,
            'nama_peminjam'   => session()->get('nama'),
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => null,
            'status'          => 'pending',
            'status_bayar'    => 'belum',
            'denda'           => 0
        ]);
        
        return redirect()->to('/buku')->with('success', 'Peminjaman diajukan! Menunggu konfirmasi admin.');
    }

    public function approve($id_pinjam)
    {
        $tgl_pinjam  = $this->request->getPost('tanggal_pinjam');
        $tgl_kembali = $this->request->getPost('tanggal_kembali');

        if (!$tgl_pinjam || !$tgl_kembali) {
            return redirect()->back()->with('error', 'Tanggal pinjam dan batas kembali harus diisi!');
        }

        $dataPinjam = $this->pinjamanModel->find($id_pinjam);
        $buku = $this->bukuModel->find($dataPinjam['id_buku']);

        if ($buku['tersedia'] <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis, tidak bisa menyetujui pinjaman.');
        }

        $this->pinjamanModel->update($id_pinjam, [
            'status'          => 'dipinjam',
            'tanggal_pinjam'  => $tgl_pinjam,
            'tanggal_kembali' => $tgl_kembali
        ]);
        
        $this->bukuModel->update($dataPinjam['id_buku'], [
            'tersedia' => $buku['tersedia'] - 1
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function konfirmasi_kembali($id_pinjam)
    {
        $pj = $this->pinjamanModel->find($id_pinjam);
        $bk = $this->bukuModel->find($pj['id_buku']);

        if ($pj['denda'] > 0 && $pj['status_bayar'] != 'lunas') {
            return redirect()->back()->with('error', 'Gagal! Denda Rp ' . number_format($pj['denda'], 0, ',', '.') . ' belum dilunasi.');
        }

        $this->pinjamanModel->update($id_pinjam, ['status' => 'kembali']);
        $this->bukuModel->update($pj['id_buku'], ['tersedia' => $bk['tersedia'] + 1]);

        return redirect()->to('/peminjaman')->with('success', 'Buku telah diterima kembali.');
    }

    public function kembalikan($id_pinjam)
    {
        $this->pinjamanModel->update($id_pinjam, ['status' => 'menunggu_kembali']);
        return redirect()->to('/peminjaman/riwayat')->with('success', 'Permintaan pengembalian telah dikirim!');
    }

    public function riwayat()
    {
        $namaUser = session()->get('nama');
        if (!$namaUser) return redirect()->to('/login');

        $riwayat = $this->pinjamanModel->select('peminjaman.*, buku.judul')
                                ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                                ->where('nama_peminjam', $namaUser)
                                ->orderBy('id_pinjam', 'DESC')
                                ->findAll();
        
        $data = [
            'riwayat' => $riwayat,
            'cari'    => ''
        ];

        return view('peminjaman/riwayat', $data);
    }

    public function hapus($id_pinjam)
    {
        $this->pinjamanModel->delete($id_pinjam);
        return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function bayar_dana($id_pinjam)
    {
        $fileBukti = $this->request->getFile('bukti_bayar');

        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFile = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti_bayar', $namaFile);

            $this->pinjamanModel->update($id_pinjam, [
                'bukti_bayar'  => $namaFile,
                'status_bayar' => 'proses'
            ]);

            return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah!');
        }
        
        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    public function verifikasi_bayar($id)
    {
        $pinjaman = $this->pinjamanModel->find($id);
        
        $this->pinjamanModel->update($id, [
            'status_bayar' => 'lunas',
            'status'       => 'kembali'
        ]);

        $buku = $this->bukuModel->find($pinjaman['id_buku']);
        $this->bukuModel->update($pinjaman['id_buku'], ['tersedia' => $buku['tersedia'] + 1]);

        return redirect()->back()->with('success', 'Pembayaran diverifikasi. Buku otomatis masuk stok.');
    }

    public function tagih_denda($id)
    {
        $pesan = $this->request->getPost('pesan_admin') ?: "Buku belum bisa diterima. Silakan lunasi denda Anda terlebih dahulu.";
        
        // Perbaikan: Pakai $this->pinjamanModel sesuai definisi di __construct
        $this->pinjamanModel->update($id, [
            'pesan_admin' => $pesan
        ]);

        return redirect()->back()->with('success', 'Peringatan denda telah dikirim ke User.');
    }
}