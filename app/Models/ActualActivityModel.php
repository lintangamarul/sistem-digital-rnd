<?php

namespace App\Models;
use CodeIgniter\Model;
class ActualActivityModel extends Model {
    protected $table = 'actual_activity';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status', 'created_by', 'created_at', 'modified_by', 'modified_at', 'dates', 'comment', 'comment_by'];
    public function getActivitiesWithUsers()
    {
        return $this->select('actual_activity.*, users.nama AS created_by_name')
                    ->join('users', 'users.id = actual_activity.created_by', 'left')
                    ->where('actual_activity.status', 1)
                    ->where('users.status', 1)
                    ->orderBy('actual_activity.dates', 'DESC') 
                    ->orderBy('actual_activity.modified_at', 'ASC')
                    ->findAll();
    }
    
}

