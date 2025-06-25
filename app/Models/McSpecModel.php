<?php namespace App\Models;

use CodeIgniter\Model;

class McSpecModel extends Model
{
    protected $table         = 'mc_spec'; 
    protected $primaryKey    = 'id';       
    protected $allowedFields = [
        'machine',
        'bolster_length',
        'bolster_width',
        'slide_area_length',
        'slide_area_width',
        'die_height',
        'cushion_pad_length',
        'cushion_pad_width',
        'cushion_stroke',
         'capacity',
        'cushion',
        
    ];  
    // protected $useTimestamps = true; 
}