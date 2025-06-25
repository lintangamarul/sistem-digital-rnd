<?php

namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMachining2Model extends Model
{
    protected $table            = 'ccf_machining2';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'overview_id',
        'machining_proc',
        'machining_kom',
        'machining_lead_time',
        'machining_lead_time_h',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}
