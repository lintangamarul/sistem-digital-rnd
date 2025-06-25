<?php namespace App\Models;

use CodeIgniter\Model;

class PpsModel extends Model
{
    protected $table         = 'pps';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'cust', 'model', 'receive',
        'id',
        'part_no', 'part_name',
        'cf', 'material', 'tonasi',
        'length', 'width', 'boq',
        'blank', 'panel', 'scrap',
        'total_mp', 'doc_level', 'total_stroke',
        'excel_file',
        'process_layout',
        'blank_layout',
        'created_at',
        'created_by','status',
 
    ];
    protected $useTimestamps = true;
}
