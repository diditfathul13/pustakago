<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    // Ini untuk tampilan Katalog (Grid Card)
    public function index()
    {
        $cari = $this->request->getGet('cari');
        $data = [
            'buku'  => ($cari) ? $this->bukuModel->cariData($cari) : $this->bukuModel->findAll(),
            'cari'  => $cari,
            'title' => 'Katalog Buku'
        ];
        // Kita arahkan ke view katalog agar tampilannya mewah
        return view('buku/katalog', $data);
    }

    public function create() { return view('buku/create'); }

  public function store()
{
    $fileCover = $this->request->getFile('cover');
    $path = 'uploads/buku/';

    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $namaCover = ($fileCover->isValid()) ? $fileCover->getRandomName() : 'default.jpg';
    if ($fileCover->isValid()) {
        $fileCover->move($path, $namaCover);
    }

    // Ambil input jumlah
    $jumlah = $this->request->getPost('jumlah');

    $this->bukuModel->save([
        'isbn'      => $this->request->getPost('isbn'),
        'judul'     => $this->request->getPost('judul'),
        'kategori'  => $this->request->getPost('kategori'),
        'penulis'   => $this->request->getPost('penulis'),
        'jumlah'    => $jumlah,
        'tersedia'  => $jumlah, // OTOMATIS: Tersedia = Jumlah saat buku baru
        'deskripsi' => $this->request->getPost('deskripsi'),
        'cover'     => $namaCover
    ]);

    return redirect()->to(base_url('buku'))->with('success', 'Buku Berhasil Ditambahkan');
}

   public function edit($id)
{
    $model = new \App\Models\BukuModel();
    $data['buku'] = $model->find($id); // Mencari data buku berdasarkan ID

    return view('buku/edit', $data); // Mengirim variabel $buku ke view edit
}

public function update($id)
{
    $fileCover = $this->request->getFile('cover');
    $bukuLama = $this->bukuModel->find($id);
    $path = 'uploads/buku/';

    // Logika Cover
    if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
        $namaCover = $fileCover->getRandomName();
        $fileCover->move($path, $namaCover);
        if ($bukuLama['cover'] != 'default.jpg' && file_exists($path . $bukuLama['cover'])) {
            unlink($path . $bukuLama['cover']);
        }
    } else {
        $namaCover = $this->request->getPost('coverLama');
    }

    // TANGKAP DATA SECARA MANUAL
    $data = [
        'isbn'      => $this->request->getPost('isbn'),
        'judul'     => $this->request->getPost('judul'),
        'kategori'  => $this->request->getPost('kategori'),
        'penulis'   => $this->request->getPost('penulis'),
        'jumlah'    => $this->request->getPost('jumlah'),   // Dari input manual
        'tersedia'  => $this->request->getPost('tersedia'), // Dari input manual
        'deskripsi' => $this->request->getPost('deskripsi'),
        'cover'     => $namaCover
    ];

    $this->bukuModel->update($id, $data);

    return redirect()->to(base_url('buku'))->with('success', 'Data buku berhasil diupdate secara manual!');
}
    public function delete($id)
    {
        $data = $this->bukuModel->find($id);
        if ($data['cover'] != 'default.jpg' && file_exists('uploads/buku/' . $data['cover'])) {
            unlink('uploads/buku/' . $data['cover']);
        }
        $this->bukuModel->delete($id);
        return redirect()->to(base_url('buku'))->with('success', 'Buku Berhasil Dihapus');
    }

    public function detail($id)
    {
        $data['buku'] = $this->bukuModel->find($id);
        return view('buku/detail', $data);
    }
    
}