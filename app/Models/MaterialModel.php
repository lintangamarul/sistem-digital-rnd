<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table      = 'nmaterial';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name_material',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'status'
    ];

    protected $useTimestamps = true;

    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
