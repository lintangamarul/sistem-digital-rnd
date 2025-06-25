<?php

namespace App\Models;

use CodeIgniter\Model;

class DcpMachining2Model extends Model
{
    protected $table            = 'dcp_machining2';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'overview_id',
        'machining_proc',
        'machining_kom',
        'machining_lead_time',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}
