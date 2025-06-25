<?php namespace App\Models;

use CodeIgniter\Model;

class PpsDiesModel extends Model
{
    protected $table         = 'pps_dies';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id',
        'pps_id',
        'process', 'process_join', 'proses', 'proses_gang','length_mp', 'main_pressure',
        'machine', 'capacity', 'cushion', 'die_length', 'die_width', 'die_height',
        'casting_plate', 'die_weight', 
        'dc_process', 'dc_machine', 'upper', 'lower',
        'pad', 'pad_lifter', 'sliding', 'guide', 'insert', 'heat_treatment', 'die_height_max',
        'clayout_img', 'die_construction_img',
        'slide_stroke', 'cushion_stroke', 'die_cushion_pad',
        'bolster_length', 'bolster_width', 'slide_area_length',
        'slide_area_width', 'cushion_pad_length', 'cushion_pad_width', 'class', 'panjang', 'lebar','qty',    'cbPanjangProses', 'cbPanjangLebar', 'cbPie', 'diameterPie', 'jumlahPie', 'panjangProses'
        
    ];

    protected $useTimestamps = true; 

    /**
     * Ambil semua dies berdasarkan pps_id
     */
    public function getDiesByPps($pps_id)
    {
        return $this->where('pps_id', $pps_id)->findAll();
    }
}
