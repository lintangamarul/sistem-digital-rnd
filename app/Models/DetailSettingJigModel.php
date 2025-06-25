<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailSettingJigModel extends Model
{
    protected $table = 'detail_setting_jigs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tryout_jig_id', 'point', 'class', 'combination', 'sched_chanl', 'squeeze', 
        'up_slope', 'w_c1', 'w_t1', 'w_c2', 'w_t2', 'w_c3', 'w_t3', 
        'press', 'ratio', 'amper', 'volt', 'speed','hold'
    ];

    protected $beforeInsert = ['convertToUppercase'];
    protected $beforeUpdate = ['convertToUppercase'];
    
    protected function convertToUppercase(array $data)
    {
        foreach ($data['data'] as $key => $value) {
            if (is_string($value)) {
                $data['data'][$key] = strtoupper($value);
            }
        }
        return $data;
    }
}
