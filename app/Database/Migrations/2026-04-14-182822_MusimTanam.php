<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MusimTanam extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_musim'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_musim'   => ['type' => 'VARCHAR', 'constraint' => '100'],
            'tgl_mulai'    => ['type' => 'DATE'],
            'tgl_selesai'  => ['type' => 'DATE'],
            'status_aktif' => ['type' => 'BOOLEAN', 'default' => false],
        ]);
        $this->forge->addKey('id_musim', true);
        $this->forge->createTable('tb_musim_tanam');
    }

    public function down()
    {
        $this->forge->dropTable('tb_musim_tanam');
    }
}