<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'group', 'nik', 'password', 'foto', 'email', 'no_hp', 'role_id', 'created_at', 'modified_at', 'created_by', 'modified_by', 'status', 'department', 'nickname', 'jenis_kelamin', 'jumlah_piket'];
}
