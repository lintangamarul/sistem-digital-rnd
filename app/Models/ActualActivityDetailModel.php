<?php

namespace App\Models;
use CodeIgniter\Model;

class ActualActivityDetailModel extends Model
{
    protected $table = 'actual_activity_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'actual_activity_id', 'activity_id', 'project_id', 
        'part_no', 'remark', 'start_time', 
        'end_time', 'total_time', 'progress', 'status', 'modified_by', 'created_by'
    ];
    public function getLongestDurationActivity() {
        return $this->select('activity_id, SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) AS total_duration')
                    ->groupBy('activity_id')
                    ->orderBy('total_duration', 'DESC')
                    ->limit(1)
                    ->first();
    }

    public function getMostFrequentActivity() {
        return $this->select('activity_id, COUNT(*) AS frequency')
                    ->groupBy('activity_id')
                    ->orderBy('frequency', 'DESC')
                    ->limit(1)
                    ->first();
    }

}
