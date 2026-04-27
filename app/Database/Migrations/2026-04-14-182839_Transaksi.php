<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_musim'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_kategori'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal'          => ['type' => 'DATE'],
            'nominal'          => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'keterangan'       => ['type' => 'TEXT', 'null' => true],
            'status_lunas'     => ['type' => 'BOOLEAN', 'default' => false],
            'jatuh_tempo'      => ['type' => 'DATE', 'null' => true],
            'jenis_pembayaran' => ['type' => 'ENUM', 'constraint' => ['Tunai', 'Kredit']],
        ]);
        $this->forge->addKey('id_transaksi', true);
        
        // Relasi Foreign Key
        $this->forge->addForeignKey('id_musim', 'tb_musim_tanam', 'id_musim', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kategori', 'tb_kategori_akun', 'id_kategori', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('tb_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_transaksi');
    }
}