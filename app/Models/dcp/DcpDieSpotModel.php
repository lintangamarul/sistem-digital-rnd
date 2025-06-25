<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpDieSpotModel extends Model
{
    protected $table         = 'dcp_die_spot';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'die_spot_weight',
        'die_spot_lead_time',
        'die_spot_mp',
        'die_spot_working_time',
        'die_spot_mp_time'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
