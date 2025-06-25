<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMainMaterialModel extends Model
{
    protected $table         = 'ccf_main_material'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'mm_part_list',
        'mm_material_spec',
        'mm_size_type_l',
        'mm_size_type_w',
        'mm_size_type_h',
        'mm_qty',
        'mm_weight',
        'category',
        'mm_cost'

    ];
    protected $useTimestamps = true;
}
