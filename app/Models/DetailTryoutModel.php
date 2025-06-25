<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTryoutModel extends Model
{
    protected $table            = 'detail_tryouts';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'tryout_id', 'problem_image', 'problem_text', 'counter_measure', 'pic', 'target', 'progress'
    ];
}
