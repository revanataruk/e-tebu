<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriAkun extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'jenis_biaya'   => ['type' => 'ENUM', 'constraint' => ['Tetap', 'Variabel'], 'null' => true],
            'tipe_akun'     => ['type' => 'ENUM', 'constraint' => ['Pemasukan', 'Pengeluaran']],
        ]);
        $this->forge->addKey('id_kategori', true);
        $this->forge->createTable('tb_kategori_akun');
    }

    public function down()
    {
        $this->forge->dropTable('tb_kategori_akun');
    }
}