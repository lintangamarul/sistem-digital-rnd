<?php

namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpDieSpot3Model extends Model
{
    protected $table         = 'dcp_die_spot3';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'die_spot_mp',
        'die_spot_working_time',
        'die_spot_mp_time'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}

