<?php

namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfDieSpot1Model extends Model
{
    protected $table         = 'ccf_die_spot1';
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
