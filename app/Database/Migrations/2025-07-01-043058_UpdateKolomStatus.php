<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKolomStatus extends Migration
{
    public function up()
    {
        //
        $this->forge->modifyColumn('tagihan', [
            'status' => [
                'type'       => "ENUM('Lunas','Belum Lunas','Tidak Ada')",
                'default'    => 'Tidak Ada',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->modifyColumn('tagihan', [
            'status' => [
                'type'       => "ENUM('Lunas','Belum Lunas')",
                'default'    => 'Belum Lunas',
                'null'       => true,
            ],
        ]);
    }
}
