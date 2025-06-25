<?php

namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfDieSpot3Model extends Model
{
    protected $table         = 'ccf_die_spot3';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'die_spot_mp',
        'die_spot_working_time',
        'die_spot_mp_time','die_spot_process'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}

