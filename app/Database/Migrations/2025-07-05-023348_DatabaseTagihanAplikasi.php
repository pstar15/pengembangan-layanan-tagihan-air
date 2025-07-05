<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DatabaseTagihanAplikasi extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'                => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'nama_pelanggan'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat'           => [
                'type' => 'TEXT',
            ],
            'nomor_meter'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jumlah_meter'     => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'periode'          => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'jumlah_tagihan'   => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'status'           => [
                'type'       => 'ENUM',
                'constraint' => ['lunas', 'belum_lunas'],
                'default'    => 'belum_lunas',
            ],
            'created_at'       => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at'       => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('db_tagihanaplikasi');
    }

    public function down()
    {
        //
        $this->forge->dropTable('db_tagihanaplikasi');
    }
}
