<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingsTable extends Migration
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
            'kode_booking' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'lapangan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal_booking' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'durasi' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total_harga' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Pending',
            ],
            'catatan' => [
                'type'       => 'TEXT',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('lapangan_id', 'lapangan', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('bookings', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('bookings', true);
    }
}
