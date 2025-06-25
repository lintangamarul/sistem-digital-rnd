<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;

class CcfMasterTrialProcessModel extends Model
{
    protected $table         = 'master_trial_process';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'jenis',
        'class',
        'tp_part_list',
        'tp_material_spec',
        'tp_size_type',
        'tp_qty',
        'tp_cost'
    ];
    protected $useTimestamps = true;
}

