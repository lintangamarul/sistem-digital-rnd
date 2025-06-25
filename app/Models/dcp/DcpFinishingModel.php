<?php 
namespace App\Models\dcp;
use CodeIgniter\Model;

class DcpFinishingModel extends Model {
    protected $table = 'dcp_finishing';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_process', 'finishing_kom', 'finishing_lead_time'];
}
