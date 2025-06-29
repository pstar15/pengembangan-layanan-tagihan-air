<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelTagihan extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tagihan', [
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
        $this->forge->dropColumn('tagihan', ['alamat', 'jumlah_meter']);
    }
}
