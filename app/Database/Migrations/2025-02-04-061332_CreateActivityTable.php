<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_by'  => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'modified_by' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'modified_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('activities');
    }

    public function down()
    {
        $this->forge->dropTable('activities');
    }
}
