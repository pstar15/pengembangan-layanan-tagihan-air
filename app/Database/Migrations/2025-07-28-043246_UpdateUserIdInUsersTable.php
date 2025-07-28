<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserIdInUsersTable extends Migration
{
    public function up()
    {
        //
        $this->forge->modifyColumn('users', [
            'id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->modifyColumn('users', [
            'id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => false,
            ],
        ]);
    }
}
