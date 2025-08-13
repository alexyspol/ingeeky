<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'      => ['type' => 'ENUM', 'constraint' => ['open', 'closed', 'customer replied', 'awaiting customer'], 'default' => 'open'],
            'priority'    => ['type' => 'ENUM', 'constraint' => ['low', 'normal', 'high'], 'default' => 'normal'],
            'customer_id' => ['type' => 'INT', 'unsigned' => true],
            'created_by'  => ['type' => 'INT', 'unsigned' => true],
            'department'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->addForeignKey('customer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
