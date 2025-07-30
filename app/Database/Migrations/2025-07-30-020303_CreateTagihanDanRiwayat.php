<?php

namespace App\Database\Migrations;

use Config\Database;
use CodeIgniter\Database\Migration;

class CreateTagihanDanRiwayat extends Migration
{
    protected $DBGroup = 'db_tagihanaplikasi';

    public function up()
    {
        $db = Database::connect();
        //
        if (!$db->tableExists('tagihanaplikasi')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nama_pelanggan' => ['type' => 'VARCHAR', 'constraint' => 100],
                'alamat'         => ['type' => 'VARCHAR', 'constraint' => 255],
                'nomor_meter'    => ['type' => 'VARCHAR', 'constraint' => 50],
                'jumlah_meter'   => ['type' => 'INT', 'constraint' => 11],
                'periode'        => ['type' => 'VARCHAR', 'constraint' => 20],
                'jumlah_tagihan' => ['type' => 'INT', 'constraint' => 11],
                'status'         => [
                    'type'       => 'ENUM',
                    'constraint' => ['Lunas', 'Belum Lunas', 'Tidak Ada'],
                ],
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('tagihanaplikasi');
        }

        if (!$db->tableExists('riwayataplikasi')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nama_pelanggan' => ['type' => 'VARCHAR', 'constraint' => 100],
                'alamat'         => ['type' => 'VARCHAR', 'constraint' => 255],
                'nomor_meter'    => ['type' => 'VARCHAR', 'constraint' => 50],
                'jumlah_meter'   => ['type' => 'INT', 'constraint' => 11],
                'periode'        => ['type' => 'VARCHAR', 'constraint' => 20],
                'jumlah_tagihan' => ['type' => 'INT', 'constraint' => 11],
                'status'         => [
                    'type'       => 'ENUM',
                    'constraint' => ['Lunas', 'Belum Lunas', 'Tidak Ada'],
                ],
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('riwayataplikasi');
        }
    }

    public function down()
    {
        // Hapus tabel jika ada
        $db = Database::connect();

        if ($db->tableExists('tagihanaplikasi')) {
            $this->forge->dropTable('tagihanaplikasi');
        }

        if ($db->tableExists('riwayataplikasi')) {
            $this->forge->dropTable('riwayataplikasi');
        }
    }
}
