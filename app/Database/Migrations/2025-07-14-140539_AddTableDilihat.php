<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableDilihat extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('notifikasi_tagihan', [
            'dilihat' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'waktu', // Letakkan setelah kolom `waktu`
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('notifikasi_tagihan', 'dilihat');
    }
}
