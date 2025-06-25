<?php 
namespace App\Models\dcp;

use CodeIgniter\Model;

class DcpDesignProgramModel extends Model
{
    protected $table         = 'dcp_design_program'; 
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'overview_id',
        'design_man_power', 
        'design_working_time', 
        'design_mp_time', 
        'prog_man_power', 
        'prog_working_time', 
        'prog_mp_time','id'
    ];
    protected $useTimestamps = true;
}
