<?php

namespace App\Models\ccf;
use CodeIgniter\Model;
class CcfFinishing2Model extends Model {
    protected $table = 'ccf_finishing_2';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_process','finishing_mp', 'finishing_working_time', 'finishing_mp_time'];
}
