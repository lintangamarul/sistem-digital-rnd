<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfAksesorisModel extends Model
{
    protected $table         = 'ccf_aksesoris';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'aksesoris_part_list',
        'aksesoris_spec',
        'aksesoris_qty'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
