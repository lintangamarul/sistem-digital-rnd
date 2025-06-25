<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfPollyModel extends Model
{
    protected $table         = 'ccf_poly'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'poly_partlist',
        'poly_material',
        'poly_size_type_l', 
        'poly_size_type_w', 
        'poly_size_type_h', 
        'poly_qty', 
        'poly_weight'
    ];
    protected $useTimestamps = true;
}
