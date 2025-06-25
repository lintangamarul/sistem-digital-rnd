<?php

namespace App\Models\ccf;
use CodeIgniter\Model;
class CcfFinishing3Model extends Model {
    protected $table = 'ccf_finishing_3';
    protected $primaryKey = 'id';
    protected $allowedFields = ['overview_id', 'finishing_part_list', 'finishing_material_spec', 'finishing_size_type','finishing_qty'];
}
