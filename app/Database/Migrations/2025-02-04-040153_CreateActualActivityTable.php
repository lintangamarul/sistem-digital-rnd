<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActualActivity extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_by'  => ['type' => 'INT', 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'modified_by' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'modified_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('actual_activity');
    }

    public function down()
    {
        $this->forge->dropTable('actual_activity');
    }
}
