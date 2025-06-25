<?php

namespace App\Models\ccf;
use CodeIgniter\Model;

class JcpLeadtimeModel extends Model
{
    protected $table = 'jcp_master_leadtime';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'parts', 'class', 'measuring_hour', 
        'hour_machine_laser_cutting', 'hour_machine_big', 
        'hour_machine_small', 'total_day', 'status'
    ];
}
