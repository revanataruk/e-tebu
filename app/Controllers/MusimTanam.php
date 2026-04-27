<?php

namespace App\Controllers;

use App\Models\MusimModel;

class MusimTanam extends BaseController
{
    protected $musimModel;

    public function __construct()
    {
        $this->musimModel = new MusimModel();
    }

    public function index()
    {
        // Proteksi Halaman
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Daftar Musim Tanam - E-Tebu',
            'musim' => $this->musimModel->orderBy('tgl_mulai', 'DESC')->findAll()
        ];

        return view('musim/index', $data);
    }

    public function simpan()
    {
        // Menyimpan data musim baru dari form Modal
        $this->musimModel->save([
            'nama_musim'   => $this->request->getPost('nama_musim'),
            'tgl_mulai'    => $this->request->getPost('tgl_mulai'),
            'tgl_selesai'  => $this->request->getPost('tgl_selesai'),
            'status_aktif' => 0 // Default saat dibuat adalah tidak aktif
        ]);

        session()->setFlashdata('pesan', 'Musim tanam baru berhasil ditambahkan.');
        return redirect()->to('/musimtanam');
    }

    public function set_aktif($id_musim)
    {
        // LOGIKA INTI: Sesuai Sequence Diagram di proposal
        // 1. Reset semua status musim menjadi 0 (Tidak Aktif)
        $this->musimModel->set(['status_aktif' => 0])->where('id_musim >', 0)->update();

        // 2. Set status musim yang dipilih menjadi 1 (Aktif)
        $this->musimModel->update($id_musim, ['status_aktif' => 1]);

        session()->setFlashdata('pesan', 'Status Musim Aktif berhasil diperbarui.');
        return redirect()->to('/musimtanam');
    }
}