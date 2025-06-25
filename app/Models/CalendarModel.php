<?php namespace App\Models;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table = 'calendar_events';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'date', 'start_time', 'notes', 'is_private', 'created_by'];
    protected $returnType = 'array';
}