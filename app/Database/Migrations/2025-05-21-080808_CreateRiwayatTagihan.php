<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatTagihan extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'nama_pelanggan' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nomor_meter' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'periode' => ['type' => 'VARCHAR', 'constraint' => '20'],
            'jumlah_tagihan' => ['type' => 'INT'],
            'status' => ['type' => 'ENUM','constraint' => ['Lunas', 'Belum Lunas'],'default'    => 'Belum Lunas',],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('riwayat_tagihan');
    }

    public function down()
    {
        //
        $this->forge->dropTable('riwayat_tagihan');
    }
}
