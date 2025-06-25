<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActualActivityDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'actual_activity_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'activity_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'part_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'start_time' => [
                'type' => 'DATETIME',
            ],
            'end_time' => [
                'type' => 'DATETIME',
            ],
            'total_time' => [
                'type' => 'INT',
                'comment' => 'Total time in minutes',
            ],
            'progress' => [
                'type'       => 'INT',
                'constraint' => 3,
                'comment'    => 'Progress in percentage',
            ],
        ]);

        $this->forge->addKey('id', true);
       
        $this->forge->createTable('actual_activity_detail');
    }

    public function down()
    {
        $this->forge->dropTable('actual_activity_detail');
    }
}
