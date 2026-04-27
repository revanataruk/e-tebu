<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuktiTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bukti'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_transaksi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_file'    => ['type' => 'VARCHAR', 'constraint' => '255'],
            'path_file'    => ['type' => 'VARCHAR', 'constraint' => '255'],
        ]);
        $this->forge->addKey('id_bukti', true);
        
        // Relasi Foreign Key
        $this->forge->addForeignKey('id_transaksi', 'tb_transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('tb_bukti_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_bukti_transaksi');
    }
}