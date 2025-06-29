<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelRiwayat extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('riwayat_tagihan', [
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'after'      => 'nama_pelanggan',
                'null'       => true,
            ],
            'jumlah_meter' => [
                'type'       => 'INT',
                'constraint' => 11,
                'after'      => 'nomor_meter',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('riwayat_tagihan', ['alamat', 'jumlah_meter']);
    }
}
