<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailClusterModel extends Model
{
    protected $table = 'detail_cluster';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tryout_jig_id', 'part_levelling', 'part_specification'];

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
