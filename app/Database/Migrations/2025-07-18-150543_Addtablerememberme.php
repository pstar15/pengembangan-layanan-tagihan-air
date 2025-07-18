<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addtablerememberme extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('users', [
            'remember_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'password' // letakkan setelah kolom password
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('users', 'remember_token');
    }
}
