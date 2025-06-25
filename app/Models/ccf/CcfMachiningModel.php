<?php

namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMachiningModel extends Model
{
    protected $table            = 'ccf_machining';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'overview_id',
        'machining_process',
        'machining_man_power',
        'machining_working_time',
        'machining_mp_time',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}
