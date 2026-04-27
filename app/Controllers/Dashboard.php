<?php

namespace App\Controllers;

use App\Models\MusimModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/auth');

        $musimModel = new MusimModel();
        $transaksiModel = new TransaksiModel();

        $musimAktif = $musimModel->getMusimAktif();

        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $saldo = 0;
        $tagihan = []; // Siapkan array kosong untuk tagihan

        if ($musimAktif) {
            $totalPemasukan = $transaksiModel->getTotalByMusim($musimAktif['id_musim'], 'Pemasukan') ?? 0;
            $totalPengeluaran = $transaksiModel->getTotalByMusim($musimAktif['id_musim'], 'Pengeluaran') ?? 0;
            $saldo = $totalPemasukan - $totalPengeluaran;
            
            // Ambil data jatuh tempo
            $tagihan = $transaksiModel->getJatuhTempo($musimAktif['id_musim']);
        }

        $data = [
            'title'       => 'Dashboard - E-Tebu',
            'musimAktif'  => $musimAktif,
            'pemasukan'   => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'saldo'       => $saldo,
            'tagihan'     => $tagihan // Kirim data tagihan ke View
        ];

        return view('dashboard/index', $data);
    }
}