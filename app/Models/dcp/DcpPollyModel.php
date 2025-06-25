<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpPollyModel extends Model
{
    protected $table         = 'dcp_poly'; 
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
