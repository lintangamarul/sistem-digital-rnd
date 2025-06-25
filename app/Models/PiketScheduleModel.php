<?php
namespace App\Models;
use CodeIgniter\Model;
class PiketScheduleModel extends Model {
    protected $table = 'piket_schedule';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'user_id', 'week'];
}
