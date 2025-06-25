<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpMainMaterialModel extends Model
{
    protected $table         = 'dcp_main_material'; 
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

    ];
    protected $useTimestamps = true;
}
