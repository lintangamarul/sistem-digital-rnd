<?php

namespace App\Models;

use CodeIgniter\Model;

class TryoutJigModel extends Model
{
    protected $table = 'tryout_jigs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'part_no', 'image', 'process', 'event', 'date', 'projek', 'cust', 'project_id',
        'm_usage', 'm_spec', 'holder', 'r_visual', 'r_torque', 'r_cut', 
        's_visual', 's_torque', 's_cut', 'judge', 'judgement',
        't_target', 'a_target', 't_cycle', 'a_cycle', 'shift', 
        't_uph', 'a_uph', 'work_h', 'work_d', 'whit', 'whitout', 'part_name', 'tooling', 'quality', 'produksi', 'rnd', 'ps'
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
