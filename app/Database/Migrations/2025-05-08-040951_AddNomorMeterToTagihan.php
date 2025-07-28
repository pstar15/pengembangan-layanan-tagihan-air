<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNomorMeterToTagihan extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tagihan', [
            'nomor_meter' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'after' => 'nama_pelanggan'
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tagihan', 'nomor_meter');
    }
}
