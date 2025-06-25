<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleFeatureModel extends Model
{
    protected $table = 'role_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'fitur_id', 'created_at', 'updated_at'];
}
