<?php

namespace App\Models\ccf;
use CodeIgniter\Model;
class CcfMasterFinishing3Model extends Model {
    protected $table = 'ccf_master_finishing_3';
    protected $primaryKey = 'id';
    protected $allowedFields = ['finishing_part_list', 'finishing_material_spec', 'finishing_size_type','finishing_qty','jenis',
        'class'];
}
