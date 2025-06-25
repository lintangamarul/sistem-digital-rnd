<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduledMessageModel extends Model
{
    protected $table = 'scheduled_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['target', 'message', 'schedule', 'status'];
    protected $useTimestamps = true;
}
