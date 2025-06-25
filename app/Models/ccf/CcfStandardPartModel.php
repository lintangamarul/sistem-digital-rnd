<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfStandardPartModel extends Model
{
    protected $table         = 'ccf_standard_part';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'sp_part_list',
        'sp_material_spec',
        'sp_size_type',
        'sp_qty',
        'sp_category',
        'sp_cost',
        'jenis',
        'class'
    ];
    protected $useTimestamps = true;
}
