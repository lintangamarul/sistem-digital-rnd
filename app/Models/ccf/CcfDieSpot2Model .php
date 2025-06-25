<?php

namespace App\Models\ccf;

use CodeIgniter\Model;

class CcfDieSpot2Model extends Model
{
    protected $table         = 'ccf_die_spot2';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'die_spot_kom',
        'die_spot_lead_time'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
