<?php

namespace App\Models;

use CodeIgniter\Model;

class TryoutModel extends Model
{
    protected $table = 'tryouts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id', 'mc_line', 'slide_dh', 'adaptor', 'cush_press', 
        'cush_h', 'main_press', 'spm', 'gsph', 'boolster','dates', 'part_trial_image', 'material_image', 'material_pakai', 'material_sisa',
    'part_target', 'part_act', 'part_judge',
    'trial_time', 'trial_maker', 'projek', 'konfirmasi_produksi', 'konfirmasi_qc', 'konfirmasi_tooling','konfirmasi_rd','step', 'event', 'part_up', 'part_std', 'part_down', 'panel_ok', 'material', 'cust', 'activity'
    ];

    public function getTryouts()
    {
        return $this->select('tryouts.*, projects.part_no, projects.process')
                    ->join('projects', 'projects.id = tryouts.project_id')
                    ->findAll();
    }
    
}
