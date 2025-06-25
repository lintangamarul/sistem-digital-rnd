<?php 
namespace App\Models\ccf;
use CodeIgniter\Model;
class CcfFinishingModel extends Model {
    protected $table = 'ccf_finishing';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_process', 'finishing_kom', 'finishing_lead_time'];
}
