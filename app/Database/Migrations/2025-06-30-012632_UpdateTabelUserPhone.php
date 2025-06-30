<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelUserPhone extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('userphone', [
            'is_online' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'password'
            ],
            'last_online' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'after'   => 'is_online'
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('userphone', ['is_online', 'last_online']);
    }
}
