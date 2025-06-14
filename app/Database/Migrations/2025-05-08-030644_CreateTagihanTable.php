<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'               => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_pelanggan'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'periode'          => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'jumlah_tagihan'   => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status'           => [
                'type'       => 'ENUM',
                'constraint' => ['Lunas', 'Belum Lunas'],
                'default'    => 'Belum Lunas',
            ],
            'created_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tagihan');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tagihan');
    }
}
