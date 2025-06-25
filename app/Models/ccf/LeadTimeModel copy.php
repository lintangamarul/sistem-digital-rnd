<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadTimeModel extends Model
{
    protected $table = 'lead_time';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category', 'process', 'class', 'hour', 'week', 'status',
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
