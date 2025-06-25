<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;

class CcfMasterStandardPartModel extends Model
{
    protected $table         = 'ccf_master_standard_part';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'sp_part_list',
        'sp_material_spec',
        'sp_size_type',
        'sp_qty',
        'sp_category',
        'sp_cost','jenis',
        'class'
    ];

    protected $useTimestamps = true;
}

