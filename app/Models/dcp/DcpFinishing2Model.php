<?php

namespace App\Models\dcp;
use CodeIgniter\Model;

class DcpFinishing2Model extends Model {
    protected $table = 'dcp_finishing_2';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_mp', 'finishing_working_time', 'finishing_mp_time'];
}
