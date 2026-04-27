<?php

namespace App\Controllers;

use App\Models\MusimModel;
use App\Models\TransaksiModel;

class Laporan extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/auth');

        $musimModel = new MusimModel();
        $transaksiModel = new TransaksiModel();
        $musimAktif = $musimModel->getMusimAktif();

        // Inisialisasi variabel dengan nilai 0
        $pemasukan = 0;
        $biayaTetap = 0;
        $biayaVariabel = 0;
        $totalBiaya = 0;
        $labaBersih = 0;

        if ($musimAktif) {
            // 1. Ambil Total Pendapatan
            $pemasukan = $transaksiModel->getTotalByMusim($musimAktif['id_musim'], 'Pemasukan') ?? 0;
            
            // 2. Terapkan Full Costing: Hitung Biaya Tetap & Variabel
            $biayaTetap = $transaksiModel->getTotalBiayaByJenis($musimAktif['id_musim'], 'Tetap');
            $biayaVariabel = $transaksiModel->getTotalBiayaByJenis($musimAktif['id_musim'], 'Variabel');
            
            // 3. Kalkulasi Total Biaya & Laba Bersih
            $totalBiaya = $biayaTetap + $biayaVariabel;
            $labaBersih = $pemasukan - $totalBiaya;
        }

        $data = [
            'title'         => 'Laporan Keuangan - E-Tebu',
            'musimAktif'    => $musimAktif,
            'pemasukan'     => $pemasukan,
            'biayaTetap'    => $biayaTetap,
            'biayaVariabel' => $biayaVariabel,
            'totalBiaya'    => $totalBiaya,
            'labaBersih'    => $labaBersih
        ];

        return view('laporan/index', $data);
    }
}