<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtRiwayatTagihan extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('riwayat_tagihan', [
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'created_at', // letakkan setelah created_at jika sudah ada
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('riwayat_tagihan', 'updated_at');
    }
}
