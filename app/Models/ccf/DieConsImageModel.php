<?php namespace App\Models;

use CodeIgniter\Model;
class DieConsImageModel extends Model
{
    protected $table         = 'die_cons_images';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'proses', 'pad_lifter', 'casting_plate', 'image'
    ];
    protected $useTimestamps = true;
}

