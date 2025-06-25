<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 255],
            'nik' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'foto' => ['type' => 'TEXT', 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'role_id' => ['type' => 'INT', 'constraint' => 11],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
        $this->db->table('users')->insert([
            'nama'      => 'Admin',
            'nik'       => '12345678',
            'password'  => password_hash('password123', PASSWORD_DEFAULT),
            'email'     => 'admin@example.com',
            'no_hp'     => '08123456789',
            'role_id'   => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
    }
    public function down()
    {
        // Fungsi ini digunakan untuk rollback migrasi
        $this->forge->dropTable('users');
    }
}
