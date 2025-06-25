<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'role_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_by' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME'],
            'modified_by' => ['type' => 'INT', 'null' => true],
            'modified_at' => ['type' => 'DATETIME', 'null' => true],
            'status' => ['type' => 'TINYINT', 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('roles');
    }
    public function down()
    {
        // Fungsi ini digunakan untuk rollback migrasi
        $this->forge->dropTable('roles');
    }
}
