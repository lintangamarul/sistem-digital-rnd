<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTryoutJigModel extends Model
{
    protected $table      = 'detail_tryout_jig';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tryout_jig_id', 'problem', 'problem_image', 'measure', 'pic', 'target', 'remarks', 'progress'];

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
