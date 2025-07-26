<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatLogin extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'user_id'    => ['type' => 'INT'],
            'waktu'      => ['type' => 'DATETIME'],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45],
            'lokasi'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'perangkat'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'     => ['type' => 'ENUM("Sukses","Gagal")'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('riwayat_login');
    }

    public function down()
    {
        //
        $this->forge->dropTable('riwayat_login');
    }
}
