<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpStandardPartModel extends Model
{
    protected $table         = 'dcp_standard_part';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'sp_part_list',
        'sp_material_spec',
        'sp_size_type',
        'sp_qty'
    ];
    protected $useTimestamps = true;
}
