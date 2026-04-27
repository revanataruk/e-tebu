<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengguna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'     => ['type' => 'VARCHAR', 'constraint' => '100'],
            'password'     => ['type' => 'VARCHAR', 'constraint' => '255'],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => '100'],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tb_pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pengguna');
    }
}