<?php

namespace App\Models;

use CodeIgniter\Model;
class FinishingModel extends Model
{
    protected $table = 'finishing';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'part_list',
        'material',
        'diameter',
        'class',
        'qty',
        'remarks',
        'status',
        'process',
        
        'created_at',
        'created_by',
        'modified_at',
        'modified_by'
    ];

    public function getMatchingData($process, $class = null)
    {
        $builder = $this->builder();
        $builder->where('process', $process);
        if (!empty($class)) {
            $builder->where('class', $class);
        }
        return $builder->get()->getResultArray();
    }
}
