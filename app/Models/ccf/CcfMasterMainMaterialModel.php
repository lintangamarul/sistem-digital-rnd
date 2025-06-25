<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMasterMainMaterialModel extends Model
{
    protected $table         = 'ccf_master_main_material'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [

        'mm_part_list',
        'mm_material_spec',
        'mm_size_type_l',
        'mm_size_type_w',
        'mm_size_type_h',
        'mm_qty',
        'mm_weight',
        'mm_category', 
        'mm_cost',
        'jenis',
        'class'
    ];
    protected $useTimestamps = true;
}
