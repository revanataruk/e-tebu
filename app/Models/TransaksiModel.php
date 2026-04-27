<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'tb_transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_musim', 'id_kategori', 'tanggal', 'nominal', 
        'keterangan', 'status_lunas', 'jatuh_tempo', 'jenis_pembayaran'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getTotalByMusim($id_musim, $tipe_akun)
    {
        return $this->selectSum('nominal')
                    ->join('tb_kategori_akun', 'tb_kategori_akun.id_kategori = tb_transaksi.id_kategori')
                    ->where('id_musim', $id_musim)
                    ->where('tipe_akun', $tipe_akun)
                    ->get()
                    ->getRow()
                    ->nominal;
    }

    // Fungsi tambahan untuk mengambil daftar tagihan yang belum lunas (Basis Akrual)
    public function getJatuhTempo($id_musim)
    {
        return $this->select('tb_transaksi.*, tb_kategori_akun.nama_kategori')
                    ->join('tb_kategori_akun', 'tb_kategori_akun.id_kategori = tb_transaksi.id_kategori')
                    ->where('id_musim', $id_musim)
                    ->where('status_lunas', 0) // 0 = Belum Lunas
                    ->orderBy('jatuh_tempo', 'ASC') // Urutkan dari tanggal terdekat
                    ->findAll();
    }

    // Fungsi untuk memisahkan Biaya Tetap dan Biaya Variabel (Metode Full Costing)
    public function getTotalBiayaByJenis($id_musim, $jenis_biaya)
    {
        return $this->selectSum('nominal')
                    ->join('tb_kategori_akun', 'tb_kategori_akun.id_kategori = tb_transaksi.id_kategori')
                    ->where('id_musim', $id_musim)
                    ->where('tipe_akun', 'Pengeluaran')
                    ->where('jenis_biaya', $jenis_biaya)
                    ->get()
                    ->getRow()
                    ->nominal ?? 0;
    }
}
