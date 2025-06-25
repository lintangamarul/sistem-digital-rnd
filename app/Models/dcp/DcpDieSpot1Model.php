<?php

namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpDieSpot1Model extends Model
{
    protected $table         = 'dcp_die_spot1';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'die_spot_part_list',
        'die_spot_material',
        'die_spot_qty',
        'die_spot_weight'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
