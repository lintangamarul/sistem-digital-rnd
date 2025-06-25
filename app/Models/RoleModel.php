<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'role_name',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
        'status'
    ];
}
