<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfMasterAksesorisModel extends Model
{
    protected $table         = 'ccf_master_aksesoris'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [

        'part_list',
        'material_spec',
        'qty',
        'category', 
        'cost',
        'jenis',
        'class'
    ];
    protected $useTimestamps = true;
}
