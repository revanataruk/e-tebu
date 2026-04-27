<?php

namespace App\Controllers;
use App\Models\TransaksiModel;
use App\Models\MusimModel;
use App\Models\KategoriModel;
use App\Models\BuktiModel;
use Dompdf\Dompdf;

class Transaksi extends BaseController
{
    protected $transaksiModel, $musimModel, $kategoriModel, $buktiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->musimModel = new MusimModel();
        $this->kategoriModel = new KategoriModel();
        $this->buktiModel = new BuktiModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/auth');

        // Ambil musim yang sedang aktif
        $musimAktif = $this->musimModel->getMusimAktif();

        // Join tabel transaksi dengan kategori untuk ditampilkan di tabel
        $transaksi = [];
        if ($musimAktif) {
            $transaksi = $this->transaksiModel
                ->select('tb_transaksi.*, tb_kategori_akun.nama_kategori, tb_kategori_akun.tipe_akun')
                ->join('tb_kategori_akun', 'tb_kategori_akun.id_kategori = tb_transaksi.id_kategori')
                ->where('id_musim', $musimAktif['id_musim'])
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        }

        $data = [
            'title'      => 'Buku Transaksi - E-Tebu',
            'musimAktif' => $musimAktif,
            'kategori'   => $this->kategoriModel->findAll(),
            'transaksi'  => $transaksi
        ];

        return view('transaksi/index', $data);
    }

    public function simpan()
    {
        $musimAktif = $this->musimModel->getMusimAktif();
        if (!$musimAktif) {
            session()->setFlashdata('error', 'Gagal! Tidak ada musim tanam yang aktif.');
            return redirect()->to('/transaksi');
        }

        // 1. Logika Basis Akrual (Sesuai Proposal)
        $jenis_pembayaran = $this->request->getPost('jenis_pembayaran');
        $status_lunas = ($jenis_pembayaran == 'Kredit') ? 0 : 1;
        $jatuh_tempo = ($jenis_pembayaran == 'Kredit') ? $this->request->getPost('jatuh_tempo') : null;

        // 2. Simpan Data Transaksi
        $dataTransaksi = [
            'id_musim'         => $musimAktif['id_musim'],
            'id_kategori'      => $this->request->getPost('id_kategori'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'nominal'          => str_replace(['Rp', '.', ' '], '', $this->request->getPost('nominal')), // Bersihkan format Rupiah
            'keterangan'       => $this->request->getPost('keterangan'),
            'status_lunas'     => $status_lunas,
            'jatuh_tempo'      => $jatuh_tempo,
            'jenis_pembayaran' => $jenis_pembayaran
        ];
        
        $this->transaksiModel->insert($dataTransaksi);
        $id_transaksi_baru = $this->transaksiModel->getInsertID();

        // 3. Logika Upload Bukti Nota
        $fileNota = $this->request->getFile('foto_nota');
        if ($fileNota && $fileNota->isValid() && !$fileNota->hasMoved()) {
            // Generate nama file acak agar tidak bentrok
            $namaFileBaru = $fileNota->getRandomName();
            $fileNota->move(FCPATH . 'uploads/nota', $namaFileBaru);

            // Simpan ke tb_bukti_transaksi
            $this->buktiModel->save([
                'id_transaksi' => $id_transaksi_baru,
                'nama_file'    => $fileNota->getClientName(),
                'path_file'    => 'uploads/nota/' . $namaFileBaru
            ]);
        }

        session()->setFlashdata('pesan', 'Transaksi berhasil dicatat!');
        return redirect()->to('/transaksi');
    }

    public function ekspor_pdf()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/auth');

        $musimAktif = $this->musimModel->getMusimAktif();
        if (!$musimAktif) {
            session()->setFlashdata('error', 'Tidak ada data musim aktif untuk diekspor.');
            return redirect()->to('/transaksi');
        }

        // Ambil data transaksi
        $transaksi = $this->transaksiModel
            ->select('tb_transaksi.*, tb_kategori_akun.nama_kategori, tb_kategori_akun.tipe_akun')
            ->join('tb_kategori_akun', 'tb_kategori_akun.id_kategori = tb_transaksi.id_kategori')
            ->where('id_musim', $musimAktif['id_musim'])
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $data = [
            'musimAktif' => $musimAktif,
            'transaksi'  => $transaksi
        ];

        // Load tampilan HTML untuk PDF
        $html = view('transaksi/pdf_template', $data);

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output file PDF ke browser
        $dompdf->stream("Laporan_Transaksi_" . date('Ymd') . ".pdf", ["Attachment" => false]);
    }
}