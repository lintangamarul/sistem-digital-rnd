<?php

namespace App\Models\ccf;

use CodeIgniter\Model;
class CcfLeadTimeModel extends Model
{
    protected $table = 'ccf_lead_time';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category', 'class', 'hour', 'week', 'status', 'cost',
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
