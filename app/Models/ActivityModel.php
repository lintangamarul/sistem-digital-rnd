<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table      = 'activities';
    protected $primaryKey = 'id';

    protected $allowedFields = ['project_id', 'name', 'status', 'created_by', 'created_at', 'modified_by', 'modified_at'];
    protected $useTimestamps = false;
}
