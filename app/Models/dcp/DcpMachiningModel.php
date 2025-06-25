<?php

namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpMachiningModel extends Model
{
    protected $table            = 'dcp_machining';
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
