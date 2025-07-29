<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUseriDRiwayatTagihan extends Migration
{
    public function up()
    {
        //
        $this->forge->modifyColumn('riwayat_tagihan', [
            'user_id' => [
                'name'       => 'user_id',
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        // Tambahkan index
        $this->forge->addKey('user_id');

        // Tambahkan FK
        $this->db->query('
            ALTER TABLE riwayat_tagihan
            ADD CONSTRAINT fk_riwayat_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        //
        $this->db->query('ALTER TABLE riwayat_tagihan DROP FOREIGN KEY fk_riwayat_user');
    }
}
