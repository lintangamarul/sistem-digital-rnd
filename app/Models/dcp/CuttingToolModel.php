<?php

namespace App\Models\dcp;

use CodeIgniter\Model;

class CuttingToolModel extends Model
{
    protected $table = 'cutting_tools';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'spec_cutter', 'jenis_chip', 'class', 'diameter',
        'kebutuhan_chip', 'remarks', 'process', 'status',
        'created_at', 'created_by', 'modified_at', 'modified_by'
    ];

    public function getMatchingData($process, $classValues)
    {
        if (empty($classValues) || (count($classValues) === 1 && $classValues[0] === '')) {
            return $this->where('process', $process)->findAll();
        }
        return $this->where('process', $process)
                    ->whereIn('class', $classValues)
                    ->findAll();
    }
}
