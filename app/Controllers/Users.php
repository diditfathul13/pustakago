<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    /**
     * INI FUNGSI YANG DICARI: profile
     */
    public function profile()
    {
        $id = session()->get('id_user');
        
        // Proteksi jika session hilang
        if (!$id) {
            return redirect()->to('/login')->with('error', 'Silakan login kembali.');
        }

        $data = [
            'user' => $this->users->find($id),
            'cari' => '', // Mencegah error navbar
            'title' => 'Profile Saya'
        ];

        return view('users/profile', $data);
    }

    public function index()
    {
        // Proteksi Admin/Petugas
        $role = strtolower(session()->get('role') ?? '');
        if ($role != 'admin' && $role != 'petugas') {
            return redirect()->to('/dashboard')->with('error', 'Akses Ditolak!');
        }

        $data = [
            'users' => $this->users->findAll(),
            'cari'  => ''
        ];
        
        return view('users/index', $data);
    }

    public function create()
    {
        $data['cari'] = '';
        return view('users/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'     => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'role'     => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = null;
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $this->users->save([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = [
            'user' => $this->users->find($id),
            'cari' => ''
        ];
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->users->find($id);
        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($fotoBaru && $fotoBaru->isValid() && $fotoBaru->getName() != '') {
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }
            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $dataUpdate = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ];

        if ($this->request->getPost('password') != "") {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->users->update($id, $dataUpdate);
        return redirect()->to('/users')->with('success', 'Data user berhasil diupdate!');
    }

    public function delete($id)
    {
        $user = $this->users->find($id);
        if ($user && $user['foto'] && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }
        $this->users->delete($id);
        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }
}