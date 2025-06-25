<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfOverviewModel extends Model
{
    protected $table         = 'ccf_overview'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'customer',
        'sketch',
        'part_no',
        'part_name',
        'cf_process',
        'cf_dimension',
        'weight',
        'model',
        'class',
        'status',
        'ukuran_part',
        'jenis'
    ];
    protected $useTimestamps = true;


}
