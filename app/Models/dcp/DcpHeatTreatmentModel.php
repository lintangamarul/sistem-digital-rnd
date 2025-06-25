<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpHeatTreatmentModel extends Model
{
    protected $table         = 'dcp_heat_treatment';
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
