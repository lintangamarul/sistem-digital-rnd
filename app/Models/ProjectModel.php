<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table      = 'projects';
    protected $primaryKey = 'id';

    protected $allowedFields = [
       'part_name', 'jenis','another_project', 'model', 'part_no', 'process', 'status', 
        'created_by', 'created_at', 'modified_by', 'modified_at', 'proses', 'jenis_tooling', 'customer'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'modified_at';
}
