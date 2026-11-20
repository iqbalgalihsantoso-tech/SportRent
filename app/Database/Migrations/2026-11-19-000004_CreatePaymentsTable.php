<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentsTable extends Migration
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
            'booking_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'metode_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jumlah_pembayaran' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Menunggu Verifikasi',
            ],
            'bukti_transfer' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tanggal_pembayaran' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addForeignKey('booking_id', 'bookings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payments', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('payments', true);
    }
}
