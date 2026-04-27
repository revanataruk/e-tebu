<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function index()
    {
        // Cek jika user sudah login, langsung arahkan ke Dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login'); // Memanggil file tampilan login
    }

    public function proses_login()
    {
        $session = session();
        $model = new PenggunaModel();
        
        // Mengambil inputan dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Mencari user di database berdasarkan username
        $data = $model->where('username', $username)->first();

        if ($data) {
            if ($password === $data['password']) {
                // Jika password benar, buat sesi (session)
                $ses_data = [
                    'id_user'       => $data['id_user'],
                    'username'      => $data['username'],
                    'nama_lengkap'  => $data['nama_lengkap'],
                    'isLoggedIn'    => TRUE
                ];
                $session->set($ses_data);
                
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Kata Sandi Salah!');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('error', 'Nama Pengguna Tidak Ditemukan!');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}