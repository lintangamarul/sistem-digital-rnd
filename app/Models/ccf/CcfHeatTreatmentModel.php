<?php 
namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfHeatTreatmentModel extends Model
{
    protected $table         = 'ccf_heat_treatment';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'heat_process',
        'heat_machine',
        'heat_weight'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
