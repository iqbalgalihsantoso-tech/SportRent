<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLapanganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_lapangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'jenis_lantai' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'harga_per_jam' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'deskripsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Tersedia',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('lapangan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('lapangan', true);
    }
}
