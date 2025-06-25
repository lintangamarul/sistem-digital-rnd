<?php

namespace App\Models\dcp;
use CodeIgniter\Model;

class DcpFinishing3Model extends Model {
    protected $table = 'dcp_finishing_3';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_part_list', 'finishing_material_spec', 'finishing_size_type','finishing_qty'];
}
