<?php 
namespace App\Controllers;

use App\Models\dcp\DcpOverviewModel;
use App\Models\dcp\DcpDesignProgramModel;
use App\Models\dcp\DcpPollyModel;
use App\Models\dcp\DcpMainMaterialModel;
use App\Models\dcp\DcpStandardPartModel;
use App\Models\dcp\DcpMachiningModel;
use App\Models\dcp\DcpFinishingModel;
use App\Models\dcp\DcpFinishing2Model;
use App\Models\dcp\DcpFinishing3Model;  
use App\Models\dcp\DcpHeatTreatmentModel;
use App\Models\dcp\DcpDieSpot1Model;
use App\Models\dcp\DcpDieSpot2Model;
use App\Models\dcp\DcpDieSpot3Model;
use App\Models\dcp\DcpToolCostModel;
use App\Models\dcp\DcpAksesorisModel;

use App\Models\PpsModel;
use App\Models\PpsDiesModel;
use App\Models\dcp\CuttingToolModel;
use App\Models\dcp\FinishingModel;
use App\Models\dcp\DcpMachining2Model;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Dcp extends BaseController
{  
    protected $db;
    protected $db_tooling;
    protected $overviewModel;
    protected $designProgramModel;
    protected $polyModel;
    protected $mainMaterialModel;
    protected $standardPartModel;
    protected $machiningModel;
    protected $machining2Model;
    protected $finishingModel;
    protected $finishing2Model;
    protected $finishing3Model;
    protected $heatTreatmentModel;  
    protected $dieSpotModel3;
    protected $dieSpotModel1;
    protected $toolCostModel;
    protected $aksesorisModel;
    protected $dieSpotModel2;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db_tooling = \Config\Database::connect('defaultTooling');
      
        $this->overviewModel = new DcpOverviewModel();
        $this->designProgramModel = new DcpDesignProgramModel();
        $this->polyModel = new DcpPollyModel();
        $this->mainMaterialModel = new DcpMainMaterialModel();
        $this->standardPartModel = new DcpStandardPartModel();
        $this->machiningModel = new DcpMachiningModel();
        $this->machining2Model = new DcpMachining2Model();
        $this->finishingModel = new DcpFinishingModel();
        $this->finishing2Model = new DcpFinishing2Model();
        $this->finishing3Model = new DcpFinishing3Model();
        $this->heatTreatmentModel = new DcpHeatTreatmentModel();
        $this->dieSpotModel1        = new DcpDieSpot1Model();
        $this->dieSpotModel3        = new DcpDieSpot3Model();
        $this->toolCostModel        = new DcpToolCostModel();
        $this->aksesorisModel       = new DcpAksesorisModel();        
        $this->dieSpotModel2 = new DcpDieSpot2Model();
    }
    public function index()
    {
        $data['dcpList'] = $this->overviewModel->getDcpList();
      
        return view('dcp/index', $data);
    }
    public function create($id)
    {
        $db               = \Config\Database::connect();
        $builder = $db->table('cutting_tools');
        $builder->where('process', 'TRIM, CUT, PIERCE, BLANK');
        $builder->update(['process' => 'TRIM, PIE, CUT, BLANK, SEP']);
    
        $ppsModel         = new PpsModel();
        $ppsDiesModel     = new PpsDiesModel();
        $cuttingToolModel = new CuttingToolModel();
        $finishingModel   = new FinishingModel();
        
        $ppsDiesData = $ppsDiesModel->where('id', $id)->first();
        $ppsData     = $ppsModel->where('id', $ppsDiesData['pps_id'])->first();  
        $process     = $ppsDiesData['proses'];
        
        $keywords = ['DR',  'FO', 'BE', 'FL', 'BL', 'TR', 'CUT',  'SEP', 'PI',];
        $found    = [];
        foreach ($keywords as $keyword) {
            if (stripos($process, $keyword) !== false) {
                $found[] = $keyword;
            }
        }
        $weight_poly = round($ppsDiesData['die_weight'] / (300 * 1.2), 2);
        $weight_foam = round($weight_poly / 2.5, 2);
        
     
        $class = isset($ppsDiesData['class']) ? $ppsDiesData['class'] : '';
        $keyword = null;
        if (!empty($found)) {
            $keyword = $found[0];
            $cutting_tool  = $cuttingToolModel->where('class', $class)
                                ->like('process', $keyword)
                                ->findAll();

            $finishing_data = $finishingModel->where('class', $class)
                                ->like('process', $keyword)
                                ->findAll();
        } else {
            $cutting_tool  = [];
            $finishing_data = [];
        }

        $ppsDiesId = $ppsDiesModel->select('id')->where('pps_id', $ppsData['id'])->findAll();
        $ppsId     = $ppsModel->select('id')->where('id', $id)->first();
        $process_leadtime = $ppsDiesData['proses'];
        $class = $ppsDiesData['class'];

        $leadtime_process = preg_split('/[\s,\/-]+/', strtolower($process_leadtime));
        $designRow = null;
        $cadCamRow = null;
        $polyRow = null;
        $machiningRow = null;
        $finishingRow = null;
        $leadtime_biggest_design = 0;
        $leadtime_biggest_cadcam = 0;
        $leadtime_biggest_poly = 0;
        $leadtime_biggest_machining = 0;
        $leadtime_biggest_finishing = 0;
        foreach ($leadtime_process as $leadtime) {
            if (strpos($leadtime, 'dr') !== false) {
                $mapped_process = 'draw';
            } elseif (
                strpos($leadtime, 'tr') !== false ||
                strpos($leadtime, 'pi') !== false ||
                strpos($leadtime, 'sep') !== false ||
                strpos($leadtime, 're') !== false
            ) {
                $mapped_process = 'trim';
            } elseif (
                strpos($leadtime, 'fl') !== false ||
                strpos($leadtime, 'be') !== false
            ) {
                $mapped_process = 'flange';
            } elseif (strpos($leadtime, 'c') !== false) {
                $mapped_process = 'cam';
            } elseif (strpos($leadtime, 'bl') !== false) {
                $mapped_process = 'blank';
            } elseif (strpos($leadtime, 'form') !== false) {
                $mapped_process = 'form';
            } else {
                continue;
            }
        
            // ====== DESIGN ======
            $builder = $db->table('lead_time');
            $builder->like('process', $mapped_process);
            $builder->where('class', $class);
            $builder->where('category', 'DESIGN');
            $row = $builder->get()->getRowArray();
            if (!empty($row) && $row['hour'] > $leadtime_biggest_design) {
                $leadtime_biggest_design = $row['hour'];
                $designRow = $row;
            }
        
            // ====== CAD CAM ======
            $builder = $db->table('lead_time');
            $builder->like('process', $mapped_process);
            $builder->where('class', $class);
            $builder->where('category', 'CAD CAM');
            $row = $builder->get()->getRowArray();
            if (!empty($row) && $row['hour'] > $leadtime_biggest_cadcam) {
                $leadtime_biggest_cadcam = $row['hour'];
                $cadCamRow = $row;
            }
        
            if (in_array($class, ['E', 'F', 'G', 'H'])) {
                $classpoly = 'D';
            } else {
                $classpoly = $class;
            }
            
            $builder = $db->table('lead_time');
            $builder->like('process', $mapped_process);
            $builder->where('class', $classpoly); // gunakan $classpoly yang sudah ditentukan
            $builder->where('category', 'POLY');
            $row = $builder->get()->getRowArray();
            
            if (!empty($row) && $row['hour'] > $leadtime_biggest_poly) {
                $leadtime_biggest_poly = $row['hour'];
                $polyRow = $row;
            }
            
        
            $builder = $db->table('lead_time');
            $builder->like('process', $mapped_process);
            $builder->where('class', $class);
            $builder->where('category', 'MACHINING');
            $row = $builder->get()->getRowArray();
            if (!empty($row) && $row['hour'] > $leadtime_biggest_machining) {
                $leadtime_biggest_machining = $row['hour'];
                $machiningRow = $row;
            }

            $builder = $db->table('lead_time');
            $builder->like('process', $mapped_process);
            $builder->where('class', $class);
            $builder->where('category', 'FINISHING AND TRY OUT');
            $row = $builder->get()->getRowArray();
            if (!empty($row) && $row['hour'] > $leadtime_biggest_finishing) {
                $leadtime_biggest_finishing = $row['hour'];
                $finishingRow = $row;
            }

        }
      
        // Buat output array akhir
        $dataLeadTime = [
            'designRow'     => $designRow,
            'cadCamRow'     => $cadCamRow,
            'polyRow'       => $polyRow,
            'hoursMachining'=> $leadtime_biggest_machining,
            'machiningRow'  => $machiningRow,
            'finishingRow'  => $finishingRow,
        ];
        
        // (Optional) Debug
        // echo '<pre>'; print_r($dataLeadTime); echo '</pre>';
  
        $finishingLeadTimeParts = [];

        if (!empty($finishingRow) && isset($finishingRow['hour'])) {
            $total = $finishingRow['hour'];
            $finishingLeadTimeParts = [
                round($total * (1 / 15), 2),
                round($total * (2 / 15), 2),
                round($total * (3 / 15), 2),
                round($total * (8 / 15), 2),
                round($total * (1 / 15), 2),
            ];
        }
        

        if (!empty($found)) {
            $maxCountFinishing = 0;
            $process_finishing  = $process; 
            foreach ($found as $kw) {
                $builderFinishing = $db->table('finishing');
                $builderFinishing->like('process', $kw);
                $count = $builderFinishing->countAllResults();
                if ($count > $maxCountFinishing) {
                    $maxCountFinishing = $count;
                    $process_finishing = $kw;
                }
            }
        
            $maxCountCutting = 0;
            $process_cutting  = $process;
            foreach ($found as $kw) {
                $builderCutting = $db->table('cutting_tools');
                $builderCutting->like('process', $kw);
                $count = $builderCutting->countAllResults();
                if ($count > $maxCountCutting) {
                    $maxCountCutting = $count;
                    $process_cutting = $kw;
                }
            }
        } else {
            $process_finishing = $process;
            $process_cutting   = $process;
        }
        
        // Jika ditemukan "C." atau varian lain, set proses_leadtime ke CAM
        // if (
        //     stripos($process_leadtime, 'C.') !== false ||
        //     stripos($process_leadtime, 'C/') !== false ||
        //     stripos($process_leadtime, 'C-') !== false
        // ) {
        //     $process_leadtime = 'CAM';
        // } else {
        //     $process_leadtime = $process_finishing;
        // }
        
        // Ambil data lead time untuk kategori MACHINING
        // $builderLead = $db->table('lead_time');
        // $builderLead->where('process', $process_leadtime);
        // $builderLead->where('class', $class);
        // $builderLead->where('category', 'MACHINING');
        // $queryMachining = $builderLead->get();
        // $machiningRow   = $queryMachining->getRowArray();
        
        // if ($machiningRow) {
        //     $hoursMachining = floatval($machiningRow['hour']);
        //     $remaining      = $hoursMachining - 8;
        //     $value40        = ($remaining * 40) / 100;
        //     $value35        = ($remaining * 35) / 100;
        //     $value25        = ($remaining * 25) / 100;
        // } else {
        //     $value40 = null;
        //     $value35 = null;
        //     $value25 = null;
        // }
        
 
        // Inisialisasi default null
        $hoursMachining = null;

        if ($machiningRow && isset($machiningRow['hour'])) {
            $hoursMachining = $machiningRow['hour'];
        }

        $mainMaterial = $this->mainMaterialModel
        ->orderBy('id', 'desc') 
        ->limit(300) 
        ->findAll();
    
         // $standardPart  = $this->standardPartModel->findAll();
         $standardPart = $this->db_tooling
         ->table('parts')
         ->select('category, description')
         ->where('status', 1)
         ->get()
         ->getResultArray(); 
        $aksesoris  = $this->aksesorisModel
        ->orderBy('id', 'desc') 
        ->limit(300) 
        ->findAll();
    
        $spPartList = array_unique(array_column($standardPart, 'category'));
     
        $spMaterialSpec = array_unique(array_column($standardPart, 'description'));
        $aksesorisPartList = array_unique(array_column($aksesoris, 'aksesoris_part_list'));
        $aksesorisSpec     = array_unique(array_column($aksesoris, 'aksesoris_spec'));
        $data = [
            'pps'             => $ppsData,
            'ppsDies'         => $ppsDiesData,
            'tool_cost'       => $cutting_tool,
            'finishing'       => $finishing_data,
            'ppsDiesId'       => $ppsDiesId,
            'ppsId'           => $ppsId,
            'process_finishing' => $process_finishing,
            'process_cutting'   => $process_cutting,
            'process_leadtime'  => $process_leadtime,
            'designRow'         => $designRow,
            'cadCamRow'         => $cadCamRow,
            'polyRow'           => $polyRow,
            'hoursMachining'      => $hoursMachining,
            'machiningRow'      => $machiningRow,
            'finishingRow'      => $finishingRow,
            'mainMaterial' => $mainMaterial,
            'spPartList' =>   $spPartList,
            'spMaterialSpec' =>  $spMaterialSpec,
            'aksesorisPartList' => $aksesorisPartList,
            'aksesorisSpec'     => $aksesorisSpec,
            'finishingLeadTimeParts' => $finishingLeadTimeParts,
            'weight_foam' => $weight_foam,
            'weight_poly' => $weight_poly
        ];

        return view('dcp/create', $data);
    }
    
     
    
    public function store()
    {
        // $this->db->transStart() ;

        $fileSketch = $this->request->getFile('sketch');
        $newName = null;
        if ($fileSketch && $fileSketch->isValid() && !$fileSketch->hasMoved()) {
            $newName = $fileSketch->getRandomName();
            $fileSketch->move(FCPATH . 'uploads/dcp', $newName);
        }
        $pps_dies =  $this->request->getPost('pps_dies');
        
        // Simpan Overview
        $this->overviewModel->insert([
            'id_pps' => $this->request->getPost('pps'),
            'id_pps_dies' => $this->request->getPost('pps_dies'),
            'sketch' => $newName,
            'created_by' =>session()->get('user_id'),
            'updated_by' => session()->get('user_id')
        ]);
        $overviewId = $this->db->insertID();

        $this->designProgramModel->insert([
            'overview_id'         => $overviewId,
            'design_man_power'    => $this->request->getPost('design_man_power'),
            'design_working_time' => $this->request->getPost('design_working_time'),
            // 'design_mp_time'      => $this->request->getPost('design_mp_time'),
            'prog_man_power'      => $this->request->getPost('prog_man_power'),
            'prog_working_time'   => $this->request->getPost('prog_working_time'),
            // 'prog_mp_time'        => $this->request->getPost('prog_mp_time')
        ]);

        $poly_partlist = $this->request->getPost('poly_partlist');
        if (!empty($poly_partlist) && is_array($poly_partlist)) {
            $polyData = [];
            foreach ($poly_partlist as $i => $part) {
                $polyData[] = [
                    'overview_id'    => $overviewId,
                    'poly_partlist'  => $part,
                    'poly_material'  => $this->request->getPost('poly_material')[$i] ?? null,
                    'poly_size_type_l' => $this->request->getPost('poly_size_type_l')[$i] ?? null,
                    'poly_size_type_w' => $this->request->getPost('poly_size_type_w')[$i] ?? null,
                    'poly_size_type_h' => $this->request->getPost('poly_size_type_h')[$i] ?? null,
                    'poly_qty'       => $this->request->getPost('poly_qty')[$i] ?? null,
                    'poly_weight'    => $this->request->getPost('poly_weight')[$i] ?? null
                ];
            }
            $this->polyModel->insertBatch($polyData);
        }

        // Simpan Main Material
        $mmPartList = $this->request->getPost('mm_part_list');
        if (!empty($mmPartList) && is_array($mmPartList)) {
            $mmData = [];
            foreach ($mmPartList as $i => $value) {
                if (!empty($value)) {
                    $mmData[] = [
                        'overview_id'      => $overviewId,
                        'mm_part_list'     => $value,
                        'mm_material_spec' => $this->request->getPost('mm_material_spec')[$i] ?? null,
                        'mm_size_type_l'     => $this->request->getPost('mm_size_type_l')[$i] ?? null,
                        'mm_size_type_w'     => $this->request->getPost('mm_size_type_w')[$i] ?? null,
                        'mm_size_type_h'     => $this->request->getPost('mm_size_type_h')[$i] ?? null,
                        'mm_qty'           => $this->request->getPost('mm_qty')[$i] ?? null,
                        'mm_weight'        => $this->request->getPost('mm_weight')[$i] ?? null
                    ];
                }
            }
            if (!empty($mmData)) {
                $this->mainMaterialModel->insertBatch($mmData);
            }
        }
        
        // Simpan Standard Part
        $spPartList = $this->request->getPost('sp_part_list');
        if (!empty($spPartList) && is_array($spPartList)) {
            $spData = [];
            foreach ($spPartList as $i => $value) {
                if (!empty($value)) {
                    $spData[] = [
                        'overview_id'       => $overviewId,
                        'sp_part_list'      => $value,
                        'sp_material_spec'  => $this->request->getPost('sp_material_spec')[$i] ?? null,
                        'sp_size_type'      => $this->request->getPost('sp_size_type')[$i] ?? null,
                        'sp_qty'            => $this->request->getPost('sp_qty')[$i] ?? null
                    ];
                }
            }
            if (!empty($spData)) {
                $this->standardPartModel->insertBatch($spData);
            }
        }
        
        $finishingPartList = $this->request->getPost('finishing_part_list');
        if (!empty($finishingPartList) && is_array($finishingPartList)) {
            $finishingData1 = [];
            foreach ($finishingPartList as $i => $value) {
                $finishingData1[] = [
                    'overview_id'             => $overviewId,
                    'finishing_part_list'     => $value,
                    'finishing_material_spec' => $this->request->getPost('finishing_material_spec')[$i] ?? null,
                    'finishing_size_type'     => $this->request->getPost('finishing_size_type')[$i] ?? null,
                    'finishing_qty'           => $this->request->getPost('finishing_qty')[$i] ?? null,
                ];
            }
            if (!empty($finishingData1)) {
                $this->finishing3Model->insertBatch($finishingData1);
            }
        }
        $finishingProcess2 = $this->request->getPost('finishing_process2');
        if (!empty($finishingProcess2) && is_array($finishingProcess2)) {
            $finishingData2 = [];
            foreach ($finishingProcess2 as $i => $value) {
                $finishingData2[] = [
                    'overview_id'         => $overviewId,
                    'finishing_process'   => $value,
                    'finishing_kom'       => $this->request->getPost('finishing_kom')[$i] ?? null,
                    'finishing_lead_time' => $this->request->getPost('finishing_lead_time')[$i] ?? null,
                ];
            }
            if (!empty($finishingData2)) {
                $this->finishingModel->insertBatch($finishingData2);
            }
        }
        // Simpan Finishing - Tabel 3: (Man Power & Time Data) menggunakan DcpFinishing2Model
        $finishingProcess3 = $this->request->getPost('finishing_process3');
        if (!empty($finishingProcess3) && is_array($finishingProcess3)) {
            $finishingData3 = [];
            foreach ($finishingProcess3 as $i => $value) {
                $finishingData3[] = [
                    'overview_id'             => $overviewId,
                    'finishing_mp'            => $this->request->getPost('finishing_mp')[$i] ?? null,
                    'finishing_working_time'  => $this->request->getPost('finishing_working_time')[$i] ?? null,
                    'finishing_mp_time'       => $this->request->getPost('finishing_mp_time')[$i] ?? null,
                ];
            }
            if (!empty($finishingData3)) {
                $this->finishing2Model->insertBatch($finishingData3);
            }
        }

        // Simpan Machining
        $processes = $this->request->getPost('machining_process');
        if (!empty($processes) && is_array($processes)) {
            $machiningData = [];
            foreach ($processes as $i => $process) {
                $machiningData[] = [
                    'overview_id'           => $overviewId,
                    'machining_process'     => $process,
                    'machining_man_power'   => $this->request->getPost('machining_man_power')[$i] ?? null,
                    'machining_working_time'=> $this->request->getPost('machining_working_time')[$i] ?? null,
                    'machining_mp_time'     => $this->request->getPost('machining_mp_time')[$i] ?? null
                ];
            }
            $this->machiningModel->insertBatch($machiningData);
        }

        $processes = $this->request->getPost('machining_proc');
        if (!empty($processes) && is_array($processes)) {
            $machiningData2 = [];
            foreach ($processes as $i => $process) {
                $machiningData2[] = [
                    'overview_id'           => $overviewId,
                    'machining_proc'     => $process,
                    'machining_kom'   => $this->request->getPost('machining_kom')[$i] ?? null,
                    'machining_lead_time'=> $this->request->getPost('machining_lead_time')[$i] ?? null,
                    'machining_lead_time_h'     => $this->request->getPost('machining_lead_time_h')[$i] ?? null
                ];
            }
            
            $this->machining2Model->insertBatch($machiningData2);
        }
    
    
            
        $die_spot_part_list      = $this->request->getPost('die_spot_part_list');
        $die_spot_material      = $this->request->getPost('die_spot_material');
        $die_spot_qty      = $this->request->getPost('die_spot_qty');
        $dieSpotWeight      = $this->request->getPost('die_spot_weight');
        $die_spot_kom      = $this->request->getPost('die_spot_kom');
        $dieSpotLeadTime    = $this->request->getPost('die_spot_lead_time');
        $dieSpotMp          = $this->request->getPost('die_spot_mp');
        $dieSpotWorkingTime = $this->request->getPost('die_spot_working_time');
        $dieSpotMpTime      = $this->request->getPost('die_spot_mp_time');
      
        $dieSpotModel1 = new DcpDieSpot1Model();
        //  $dieSpotModel2 = new DcpDieSpot2Model();
        $dieSpotModel3 = new DcpDieSpot3Model();
        
        if (is_array($die_spot_part_list)) {
            foreach ($die_spot_part_list as $i => $value) {
                $dieSpotData1 = [
                    'overview_id'       => $overviewId,
                    'die_spot_part_list' => $die_spot_part_list[$i] ?? null,
                    'die_spot_material'  => is_array($die_spot_material) ? ($die_spot_material[$i] ?? null) : null,
                    'die_spot_qty'       => is_array($die_spot_qty) ? ($die_spot_qty[$i] ?? null) : null,
                    'die_spot_weight'    => is_array($dieSpotWeight) ? ($dieSpotWeight[$i] ?? null) : null
                ];
                $dieSpotModel1->insert($dieSpotData1);
            }
        }
        
        if (is_array($die_spot_kom)) {
            foreach ($die_spot_kom as $i => $value) {
                $dieSpotData2 = [
                    'overview_id'        => $overviewId,
                    'die_spot_kom'       => $die_spot_kom[$i] ?? null,
                    'die_spot_lead_time' => is_array($dieSpotLeadTime) ? ($dieSpotLeadTime[$i] ?? null) : null
                ];
                $this->dieSpotModel2->insert($dieSpotData2);
            }
        }
        
        if (is_array($dieSpotMp)) {
            foreach ($dieSpotMp as $i => $value) {
                $dieSpotData3 = [
                    'overview_id'          => $overviewId,
                    'die_spot_mp'          => $dieSpotMp[$i] ?? null,
                    'die_spot_working_time'=> is_array($dieSpotWorkingTime) ? ($dieSpotWorkingTime[$i] ?? null) : null,
                    'die_spot_mp_time'     => is_array($dieSpotMpTime) ? ($dieSpotMpTime[$i] ?? null) : null
                ];
                $dieSpotModel3->insert($dieSpotData3);
            }
        }
        

        // 10. Simpan Tool Cost
        $toolCostProcess = $this->request->getPost('tool_cost_process');
        $toolCostTool    = $this->request->getPost('tool_cost_tool');
        $toolCostSpec    = $this->request->getPost('tool_cost_spec');
        $toolCostQty     = $this->request->getPost('tool_cost_qty');
        $toolCostModel   = new DcpToolCostModel();
        if (is_array($toolCostProcess)) {
            foreach ($toolCostProcess as $i => $value) {
                $tcData = [
                    'overview_id'       => $overviewId,
                    'tool_cost_process' => $toolCostProcess[$i],
                    'tool_cost_tool'    => $toolCostTool[$i],
                    'tool_cost_spec'    => $toolCostSpec[$i],
                    'tool_cost_qty'     => $toolCostQty[$i]
                ];
                $toolCostModel->insert($tcData);
            }
        }

        // 11. Simpan Aksesoris
        $aksesorisPartList = $this->request->getPost('aksesoris_part_list');
        $aksesorisSpec     = $this->request->getPost('aksesoris_spec');
        $aksesorisQty      = $this->request->getPost('aksesoris_qty');
        $aksesorisModel    = new DcpAksesorisModel();
        
        if (is_array($aksesorisPartList)) {
            foreach ($aksesorisPartList as $i => $value) {
                if (!empty($value)) {
                    $akData = [
                        'overview_id'         => $overviewId,
                        'aksesoris_part_list' => $value,
                        'aksesoris_spec'      => $aksesorisSpec[$i] ?? null,
                        'aksesoris_qty'       => $aksesorisQty[$i] ?? null
                    ];
                    $aksesorisModel->insert($akData);
                }
            }
        }
        
        $processes      = $this->request->getPost('heat_process');
        // 12 heat treat
        if (!empty($processes) && is_array($processes)) {
            $machiningData = [];
            foreach ($processes as $i => $process) {
                $machiningData[] = [
                    'overview_id'           => $overviewId,
                    'heat_process'     => $process,
                    'heat_machine'   => $this->request->getPost('heat_machine')[$i] ?? null,
                    'heat_weight'=> $this->request->getPost('heat_weight')[$i] ?? null,
                ];
            }
      
            $this->heatTreatmentModel->insertBatch($machiningData);
        }

        // Selesaikan transaksi
        // $db->transComplete();
 
        // if ($db->transStatus() === false) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        // } else {
            // Ambil id PPS dari input hidden 'op_after' untuk refresh data
            // $idPps = $this->request->getPost('op_after');
            // print_r(            $idPps);
   
            // // Ambil ulang data PPS, PPSDies, cutting tool, dan finishing berdasarkan idPps
            // $ppsData = (new PpsModel())->where('id', $idPps)->first();
            // $ppsDiesData = (new PpsDiesModel())->where('pps_id', $ppsData['id'])->first();
            // $class = isset($ppsDiesData['class']) ? $ppsDiesData['class'] : '';
            // $cutting_tool = (new CuttingToolModel())->where('class', $class)->findAll();
            // $finishing_data = (new FinishingModel())->where('class', $class)->findAll();
            // $ppsDiesDataId = (new PpsDiesModel())->select('id')->where('pps_id', $ppsData['id'])->findAll();

            // $data = [
            //     'pps'       => $ppsData,
            //     'ppsDies'   => $ppsDiesData,
            //     'tool_cost' => $cutting_tool,
            //     'finishing' => $finishing_data,
            //     'ppsDiesId' => $ppsDiesDataId,
            // ];
            
            // return redirect()->to('dcp/nextprocess/' . $idPps);

       
            // Atau gunakan redirect jika lebih sesuai:
            return redirect()->to('/pps')->with('success', 'Data DCP berhasil disimpan.');
        // }
    }
    public function edit($overviewId)
    {
        $overview = $this->overviewModel
                         ->select('dcp_overview.*, 
                                   pps_dies.process, 
                                   pps_dies.process_join, 
                                   pps_dies.proses AS proses, 
                                   pps_dies.die_length, 
                                   pps_dies.die_width, 
                                   pps_dies.die_height, 
                                   pps_dies.die_weight, 
                                   pps_dies.class AS class, 
                                   pps.cust, 
                                   pps.part_no')
                         ->join('pps_dies', 'dcp_overview.id_pps_dies = pps_dies.id', 'left')
                         ->join('pps', 'pps_dies.pps_id = pps.id', 'left')
                         ->find($overviewId);
    
        if (!$overview) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Overview dengan ID $overviewId tidak ditemukan.");
        }
    
        // Ambil data relasi 1 baris
        $singleModels = [
            'designProgram' => $this->designProgramModel->where('overview_id', $overviewId)->first(),
        ];
    
        // Ambil data relasi banyak baris
        $multiModels = [
            'poly'         => $this->polyModel,
            'mainMaterial' => $this->mainMaterialModel,
            'standardPart' => $this->standardPartModel,
            'machining'    => $this->machiningModel,
            'machining2'   => $this->machining2Model,
            'dieSpot1'     => $this->dieSpotModel1,
            'dieSpot2'     => $this->dieSpotModel2,
            'dieSpot3'     => $this->dieSpotModel3,
            'finishing'    => $this->finishingModel,
            'finishing2'   => $this->finishing2Model,
            'finishing3'   => $this->finishing3Model,
            'toolCost'     => $this->toolCostModel,
            'aksesoris'    => $this->aksesorisModel,
            'heat'         => $this->heatTreatmentModel,
        ];
    
        $data = $singleModels;
        foreach ($multiModels as $key => $model) {
            $data[$key] = $model->where('overview_id', $overviewId)->findAll();
        }
    
        $data['standardPartInventory'] = $this->db_tooling
        ->table('parts')
        ->select('category, description')
        ->where('status', 1)
        ->get()
        ->getResultArray(); 

        $data['spPartList'] = array_unique(array_column($data['standardPartInventory'], 'category'));
        $data['spMaterialSpec'] = array_unique(array_column($data['standardPartInventory'], 'description'));
    
        $data['hoursMachining'] = null;
    
        $process_leadtime = $overview['proses'] ?? null;
        $class = $overview['class'] ?? null;
    
        if ($process_leadtime && $class) {
            $leadtime_process = preg_split('/[\s,\/-]+/', strtolower($process_leadtime));
    
            $categories = ['DESIGN', 'CAD CAM', 'POLY', 'MACHINING'];
            $leadtimeMax = array_fill_keys($categories, 0);
            $leadtimeRow = array_fill_keys($categories, null);
    
            foreach ($leadtime_process as $leadtime) {
                $mapped_process = match (true) {
                    str_contains($leadtime, 'dr') => 'draw',
                    str_contains($leadtime, 'tr'), str_contains($leadtime, 'pi'), str_contains($leadtime, 're') => 'trim',
                    str_contains($leadtime, 'fl'), str_contains($leadtime, 'be') => 'flange',
                    str_contains($leadtime, 'c')  => 'cam',
                    str_contains($leadtime, 'bl') => 'blank',
                    str_contains($leadtime, 'form') => 'form',
                    default => null
                };
    
                if (!$mapped_process) continue;
    
                foreach ($categories as $category) {
                    $row = $this->getLeadTimeRow($mapped_process, $class, $category);
                    if ($row && $row['hour'] > $leadtimeMax[$category]) {
                        $leadtimeMax[$category] = $row['hour'];
                        $leadtimeRow[$category] = $row;
                    }
                }
            }
    
            $data['hoursMachining'] = $leadtimeRow['MACHINING']['hour'] ?? null;
        }
        $data['aksesorisAll'] = $this->aksesorisModel
        ->orderBy('id', 'desc') 
        ->limit(300) 
        ->findAll();
    
        $data['aksesorisPartList'] = array_unique(array_column($data['aksesorisAll'], 'aksesoris_part_list'));
        $data['aksesorisSpec']     = array_unique(array_column($data['aksesorisAll'], 'aksesoris_spec'));
        
        $data['overview'] = $overview;
        return view('dcp/edit', $data);
    }
    
    
    private function getLeadTimeRow($process, $class, $category)
    {
        return $this->db->table('lead_time')
                        ->like('process', $process)
                        ->where('class', $class)
                        ->where('category', $category)
                        ->get()
                        ->getRowArray();
    }
    
    

    public function update($overviewId)
    {
        $this->db->transStart();
    
        $fileSketch = $this->request->getFile('sketch');
        $newName = $this->request->getPost('old_sketch'); 
        if ($fileSketch && $fileSketch->isValid() && !$fileSketch->hasMoved()) {
            $newName = $fileSketch->getRandomName();
            $fileSketch->move(FCPATH . 'uploads/dcp', $newName);
        }
    
        $overviewData = [
            'sketch' => $newName,
            'updated_by' => session()->get('user_id')
        ];
        if (!empty($overviewData['sketch'])) {
            $this->overviewModel->update($overviewId, $overviewData);
        }
  
        $designData = [
            'design_man_power'    => $this->request->getPost('design_man_power'),
            'design_working_time' => $this->request->getPost('design_working_time'),
            // 'design_mp_time'      => $this->request->getPost('design_mp_time'),
            'prog_man_power'      => $this->request->getPost('prog_man_power'),
            'prog_working_time'   => $this->request->getPost('prog_working_time'),
            // 'prog_mp_time'        => $this->request->getPost('prog_mp_time')
        ];
 
        $designData = array_filter($designData, function($value) {
            return $value !== null && $value !== '';
        });
        
        $designProgramId = $this->request->getPost('design_program_id');
        if (!empty($designData) && !empty($designProgramId)) {
   
            $this->designProgramModel->update($designProgramId, $designData);
        
        }
        
        /* Update Poly */
        $this->polyModel->where('overview_id', $overviewId)->delete();
        $poly_partlist = $this->request->getPost('poly_partlist');
        if (!empty($poly_partlist) && is_array($poly_partlist)) {
            $polyData = [];
            foreach ($poly_partlist as $i => $part) {
                $polyData[] = [
                    'overview_id'      => $overviewId,
                    'poly_partlist'    => $part,
                    'poly_material'    => $this->request->getPost('poly_material')[$i] ?? null,
                    'poly_size_type_l' => $this->request->getPost('poly_size_type_l')[$i] ?? null,
                    'poly_size_type_w' => $this->request->getPost('poly_size_type_w')[$i] ?? null,
                    'poly_size_type_h' => $this->request->getPost('poly_size_type_h')[$i] ?? null,
                    'poly_qty'         => $this->request->getPost('poly_qty')[$i] ?? null,
                    'poly_weight'      => $this->request->getPost('poly_weight')[$i] ?? null
                ];
            }
            if (!empty($polyData)) {
                $this->polyModel->insertBatch($polyData);
            }
        }
    
       $this->finishing3Model->where('overview_id', $overviewId)->delete();
        $finishingPartList = $this->request->getPost('finishing_part_list');
        if (!empty($finishingPartList) && is_array($finishingPartList)) {
            $finishingData3 = [];
            foreach ($finishingPartList as $i => $part) {
                $finishingData3[] = [
                    'overview_id'             => $overviewId,
                    'finishing_part_list'     => $part,
                    'finishing_material_spec' => $this->request->getPost('finishing_material_spec')[$i] ?? null,
                    'finishing_size_type'     => $this->request->getPost('finishing_size_type')[$i] ?? null,
                    'finishing_qty'           => $this->request->getPost('finishing_qty')[$i] ?? null,
                ];
            }
            if (!empty($finishingData3)) {
                $this->finishing3Model->insertBatch($finishingData3);
            }
        }

        $this->finishingModel->where('overview_id', $overviewId)->delete();
        $finishingProcess = $this->request->getPost('finishing_process');
        if (!empty($finishingProcess) && is_array($finishingProcess)) {
            $finishingData = [];
            foreach ($finishingProcess as $i => $process) {
                $finishingData[] = [
                    'overview_id'         => $overviewId,
                    'finishing_process'   => $process,
                    'finishing_kom'       => $this->request->getPost('finishing_kom')[$i] ?? null,
                     'finishing_lead_time' => $this->request->getPost('finishing_lead_time')[$i] ?? null,
                ];
            }
            if (!empty($finishingData)) {
                $this->finishingModel->insertBatch($finishingData);
            }
        }

        $this->finishing2Model->where('overview_id', $overviewId)->delete();
        $finishingMp = $this->request->getPost('finishing_mp'); 
        $finishingWorkingTime = $this->request->getPost('finishing_working_time'); 
        $finishingMpTime = $this->request->getPost('finishing_mp_time'); 
        if (!empty($finishingMp) && is_array($finishingMp)) {
            $finishingData2 = [];
            foreach ($finishingMp as $i => $mp) {
                $finishingData2[] = [
                    'overview_id'            => $overviewId,
                    'finishing_mp'           => $mp,
                    'finishing_working_time' => $finishingWorkingTime[$i] ?? null,
                    // 'finishing_mp_time'      => $finishingMpTime[$i] ?? null,
                ];
            }
            if (!empty($finishingData2)) {
                $this->finishing2Model->insertBatch($finishingData2);
            }
        }

        /* Update Main Material */
        $this->mainMaterialModel->where('overview_id', $overviewId)->delete();
        $mmPartList = $this->request->getPost('mm_part_list');
        if (!empty($mmPartList) && is_array($mmPartList)) {
            $mmData = [];
            foreach ($mmPartList as $i => $value) {
                if (!empty($value)) {
                    $mmData[] = [
                        'overview_id'      => $overviewId,
                        'mm_part_list'     => $value,
                        'mm_material_spec' => $this->request->getPost('mm_material_spec')[$i] ?? null,
                    
                        'mm_size_type_l'     => $this->request->getPost('mm_size_type_l')[$i] ?? null,
                        'mm_size_type_w'     => $this->request->getPost('mm_size_type_w')[$i] ?? null,
                        'mm_size_type_h'     => $this->request->getPost('mm_size_type_h')[$i] ?? null,
                        'mm_qty'           => $this->request->getPost('mm_qty')[$i] ?? null,
                        'mm_weight'        => $this->request->getPost('mm_weight')[$i] ?? null
                    ];
                }
            }
            if (!empty($mmData)) {
                $this->mainMaterialModel->insertBatch($mmData);
            }
        }
        
        /* Update Standard Part */
        $this->standardPartModel->where('overview_id', $overviewId)->delete();
        $spPartList = $this->request->getPost('sp_part_list');
        if (!empty($spPartList) && is_array($spPartList)) {
            $spData = [];
            foreach ($spPartList as $i => $value) {
                if (!empty($value)) { 
                    $spData[] = [
                        'overview_id'      => $overviewId,
                        'sp_part_list'     => $value,
                        'sp_material_spec' => $this->request->getPost('sp_material_spec')[$i] ?? null,
                        'sp_size_type'     => $this->request->getPost('sp_size_type')[$i] ?? null,
                        'sp_qty'           => $this->request->getPost('sp_qty')[$i] ?? null
                    ];
                }
            }
            if (!empty($spData)) {
                $this->standardPartModel->insertBatch($spData);
            }
        }
        
    
        /* Update Machining */
        $this->machiningModel->where('overview_id', $overviewId)->delete();
    
        $processes = $this->request->getPost('machining_process');
        if (!empty($processes) && is_array($processes)) {
            $machiningData = [];
            foreach ($processes as $i => $process) {
                $machiningData[] = [
                    'overview_id'           => $overviewId,
                    'machining_process'     => $process,
                    'machining_man_power'   => $this->request->getPost('machining_man_power')[$i] ?? null,
                    'machining_working_time'=> $this->request->getPost('machining_working_time')[$i] ?? null,
                    // 'machining_mp_time'     => $this->request->getPost('machining_mp_time')[$i] ?? null
                ];
            }
            $this->machiningModel->insertBatch($machiningData);
        }

        /* Update Machining2 */
       // Hapus semua data machining lama berdasarkan overview_id
        $this->machining2Model->where('overview_id', $overviewId)->delete();

        // Ambil semua data dari form
        $processes = $this->request->getPost('machining_proc');
        $machining_kom = $this->request->getPost('machining_kom');
        $machining_lead_time = $this->request->getPost('machining_lead_time');
        $machining_lead_time_h = $this->request->getPost('machining_lead_time_h');

        // Cek dan simpan data jika proses tidak kosong
        if (!empty($processes) && is_array($processes)) {
            $machiningData2 = [];
            foreach ($processes as $i => $proc) {
                // Abaikan entri jika semua input kosong di baris tersebut
                if (
                    empty($proc) && 
                    (empty($machining_kom[$i]) || !isset($machining_kom[$i])) &&
                    (empty($machining_lead_time[$i]) || !isset($machining_lead_time[$i])) &&
                    (empty($machining_lead_time_h[$i]) || !isset($machining_lead_time_h[$i]))
                ) {
                    continue;
                }
                print_r( $machining_lead_time[$i] );
                $machiningData2[] = [
                    'overview_id'             => $overviewId,
                    'machining_proc'          => $proc,
                    'machining_kom'           => $machining_kom[$i] ?? null,
                    'machining_lead_time'     => $machining_lead_time[$i] ?? null,
                    'machining_lead_time_h'   => $machining_lead_time_h[$i] ?? null,
                ];
            }

            // Simpan ke database secara batch
            if (!empty($machiningData2)) {
                $this->machining2Model->insertBatch($machiningData2);
            }
        }
        /* Update Die Spot (Tabel 1) */
        $this->dieSpotModel1->where('overview_id', $overviewId)->delete();
        $die_spot_part_list = $this->request->getPost('die_spot_part_list');
        $die_spot_material  = $this->request->getPost('die_spot_material');
        $die_spot_qty       = $this->request->getPost('die_spot_qty');
        $dieSpotWeight      = $this->request->getPost('die_spot_weight');
        if (is_array($die_spot_part_list)) {
            foreach ($die_spot_part_list as $i => $value) {
                $dieSpotData1 = [
                    'overview_id'         => $overviewId,
                    'die_spot_part_list'  => $die_spot_part_list[$i] ?? null,
                    'die_spot_material'   => is_array($die_spot_material) ? ($die_spot_material[$i] ?? null) : null,
                    'die_spot_qty'        => is_array($die_spot_qty) ? ($die_spot_qty[$i] ?? null) : null,
                    'die_spot_weight'     => is_array($dieSpotWeight) ? ($dieSpotWeight[$i] ?? null) : null
                ];
                $this->dieSpotModel1->insert($dieSpotData1);
            }
        }
    
        /* Update Die Spot (Tabel 3) */
        $this->dieSpotModel3->where('overview_id', $overviewId)->delete();
        $dieSpotMp          = $this->request->getPost('die_spot_mp');
        $dieSpotWorkingTime = $this->request->getPost('die_spot_working_time');
        $dieSpotMpTime      = $this->request->getPost('die_spot_mp_time');
        if (is_array($dieSpotMp)) {
            foreach ($dieSpotMp as $i => $value) {
                $dieSpotData3 = [
                    'overview_id'           => $overviewId,
                    'die_spot_mp'           => $dieSpotMp[$i] ?? null,
                    'die_spot_working_time' => is_array($dieSpotWorkingTime) ? ($dieSpotWorkingTime[$i] ?? null) : null,
                    'die_spot_mp_time'      => is_array($dieSpotMpTime) ? ($dieSpotMpTime[$i] ?? null) : null
                ];
                $this->dieSpotModel3->insert($dieSpotData3);
            }
        }
    
        $this->dieSpotModel2->where('overview_id', $overviewId)->delete();
        $die_spot_kom = $this->request->getPost('die_spot_kom');
        $die_spot_lead_time      = $this->request->getPost('die_spot_lead_time');
        if (is_array($die_spot_kom)) {
            foreach ($die_spot_kom as $i => $value) {
                $dieSpotData2 = [
                    'overview_id'           => $overviewId,
                    'die_spot_mp'           => $dieSpotMp[$i] ?? null,
                    'die_spot_kom' => is_array($die_spot_kom) ? ($die_spot_kom[$i] ?? null) : null,
                    'die_spot_lead_time'      => is_array($die_spot_lead_time) ? ($die_spot_lead_time[$i] ?? null) : null
                ];
                $this->dieSpotModel2->insert($dieSpotData2);
            }
        }
        
        /* Update Tool Cost */
        $this->toolCostModel->where('overview_id', $overviewId)->delete();
        $toolCostProcess = $this->request->getPost('tool_cost_process');
        $toolCostTool    = $this->request->getPost('tool_cost_tool');
        $toolCostSpec    = $this->request->getPost('tool_cost_spec');
        $toolCostQty     = $this->request->getPost('tool_cost_qty');
        if (is_array($toolCostProcess)) {
            foreach ($toolCostProcess as $i => $value) {
                $tcData = [
                    'overview_id'       => $overviewId,
                    'tool_cost_process' => $toolCostProcess[$i],
                    'tool_cost_tool'    => $toolCostTool[$i],
                    'tool_cost_spec'    => $toolCostSpec[$i],
                    'tool_cost_qty'     => $toolCostQty[$i]
                ];
                $this->toolCostModel->insert($tcData);
            }
        }
    
        /* Update Heat Treatment */
        $heatProcesses = $this->request->getPost('heat_process');
        $heatMachines  = $this->request->getPost('heat_machine');
        $heatWeights   = $this->request->getPost('heat_weight');
    
        if (!empty($heatProcesses) && is_array($heatProcesses)) {
            $heatData = [];
            foreach ($heatProcesses as $i => $proc) {
                $heatData[] = [
                    'overview_id'  => $overviewId,
                    'heat_process' => $proc,
                    'heat_machine' => $heatMachines[$i] ?? null,
                    'heat_weight'  => $heatWeights[$i] ?? null,
                ];
                print_r(  $heatWeights );
        
            }
            $this->heatTreatmentModel->where('overview_id', $overviewId)->delete();
            if (!empty($heatData)) {
                $this->heatTreatmentModel->insertBatch($heatData);
            }
        }
        /* Update Aksesoris */
        $this->aksesorisModel->where('overview_id', $overviewId)->delete();
        $aksesorisPartList = $this->request->getPost('aksesoris_part_list');
        $aksesorisSpec     = $this->request->getPost('aksesoris_spec');
        $aksesorisQty      = $this->request->getPost('aksesoris_qty');
        if (is_array($aksesorisPartList)) {
            foreach ($aksesorisPartList as $i => $value) {
                if (!empty($value)) {
                    $akData = [
                        'overview_id'         => $overviewId,
                        'aksesoris_part_list' => $value,
                        'aksesoris_spec'      => $aksesorisSpec[$i] ?? null,
                        'aksesoris_qty'       => $aksesorisQty[$i] ?? null
                    ];
                    $this->aksesorisModel->insert($akData);
                }
            }
        }
        
    
        $this->db->transComplete();
    
        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        } else {
            return redirect()->to('/pps')->with('success', 'Data DCP berhasil diperbarui.');
        }
    }
    

  
    public function generateExcel($pps_id)
    {
        // =======================================================
        // 1. Ambil data dies berdasarkan pps_id (dari PpsDiesModel)
        // =======================================================
        $password = 'rnd';
        $templatePath = FCPATH . 'uploads/template/templateDCP.xlsx';
        $spreadsheet = IOFactory::load($templatePath);
        $usedSheets = [];
        $ppsDiesModel = new PpsDiesModel();
        $dies = $ppsDiesModel->getDiesByPps($pps_id);
      
        $dcpOverviewModel = new DcpOverviewModel();
        
        
        // =======================================================
        // 3. Looping setiap process (die) untuk mapping data ke worksheet
        // =======================================================
        $i = 0;
        $firstOverview = null;
        foreach ($dies as $die) {
            $i++;
        
            $overviewList = $dcpOverviewModel->select('
            dcp_overview.*, 
            pps_dies.process, 
            pps_dies.process_join, 
            pps_dies.proses, 
            pps_dies.die_length, 
            pps_dies.die_width, 
            pps_dies.die_height, 
            pps_dies.die_weight, 
            pps_dies.class,
            pps.cust as cust, 
            pps.part_name as part_name, 
            pps.part_no as part_no,
            users.nickname as created_by_nickname
        ')
            ->join('pps_dies', 'dcp_overview.id_pps_dies = pps_dies.id')
            ->join('pps', 'pps_dies.pps_id = pps.id')
            ->join('users', 'dcp_overview.created_by = users.id')
            ->where('pps_dies.id', $die['id'])
            ->findAll();
        
        
            if (empty($overviewList)) { 
               
                continue;
            }
            $overview = $overviewList[0];
            if (!$firstOverview) {
                $firstOverview = $overview;
            }
            $worksheetName = 'OP' . $i . '0';
            $sheet = $spreadsheet->getSheetByName($worksheetName);

            if (!$sheet) {
                continue; 
            }
            $usedSheets[] = $worksheetName; 
           
            $newWorksheetName = $overview['process'] . (!empty($overview['process_join']) ? ', ' . $overview['process_join'] : '');

            $newWorksheetName = trim($newWorksheetName, ', -');

            if (!empty($newWorksheetName)) {
                $sheet->setTitle($newWorksheetName);
            }

            $usedSheets[] = $newWorksheetName;
            $sheet = $spreadsheet->getSheetByName($newWorksheetName);
            // =======================================================
            // 5. Mapping Data Overview ke Cell di worksheet
            // =======================================================
            $sheet->setCellValue('I2', $overview['cust'] ?? '');
            $sheet->setCellValue('I3', $overview['part_no'] ?? '');
            $sheet->setCellValue('I4', $overview['part_name'] ?? '');
            $session = session(); 
            $sheet->setCellValue('S9',  $overview['created_by_nickname']);
            $sheet->setCellValue('I5', 
                ($overview['process'] ?? '') .
                (!empty($overview['process_join']) ? ',' . $overview['process_join'] : '') .
                '-' .
                ($overview['proses'] ?? '')
            );
            
            $sketchFilename = $overview['sketch'] ?? '';
            $sketchFile = FCPATH . 'uploads/dcp/' . $sketchFilename;
            
            if (!empty($sketchFilename) && file_exists($sketchFile)) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setPath($sketchFile);
                $drawing->setCoordinates('M3');
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawing->setWidth(10);
                $drawing->setHeight(110); 
                $drawing->setWorksheet($sheet);
            }
            
            $class = strtoupper($overview['class'] ?? '');
            $classCells = [
                'A' => 'O3',
                'B' => 'O4',
                'C' => 'O5',
                'D' => 'O6',
                'E' => 'O7',
                'F' => 'O8'
            ];
            if (isset($classCells[$class])) {
                $cellToColor = $classCells[$class];
                $sheet->getStyle($cellToColor)->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFFFFF00'); // kuning
            }
            
            // Die dimension:
            $sheet->setCellValue('I6', $overview['die_length'] ?? '');
            $sheet->setCellValue('J6', $overview['die_width'] ?? '');
            $sheet->setCellValue('K6', $overview['die_height'] ?? '');
            $sheet->setCellValue('I7', $overview['die_weight'] ?? '');
            
            $designProgram = $this->designProgramModel->where('overview_id', $overview['id'])->first();
       
   
           
            $sheet->setCellValue("D13", $designProgram['design_man_power'] ?? '');
            $sheet->setCellValue("F13", $designProgram['design_working_time'] ?? '');
            // $sheet->setCellValue("I13", $designProgram['design_mp_time'] ?? '');
            
            
            $sheet->setCellValue("D14", $designProgram['prog_man_power'] ?? '');
            $sheet->setCellValue("F14", $designProgram['prog_working_time'] ?? '');
            // $sheet->setCellValue("I14", $designProgram['prog_mp_time'] ?? '');
               
    
        
            $poly  = $this->polyModel->where('overview_id',  $overview['id'])->findAll();
       

     
            $startRow = 19;
            foreach ($poly as $data) {
                $sheet->setCellValue("E{$startRow}", $data['poly_size_type_l'] ?? '');
                $sheet->setCellValue("F{$startRow}", $data['poly_size_type_w'] ?? '');
                $sheet->setCellValue("G{$startRow}", $data['poly_size_type_h'] ?? '');
                $sheet->setCellValue("H{$startRow}", $data['poly_qty'] ?? '');
                $sheet->setCellValue("I{$startRow}", $data['poly_weight'] ?? '');
                $startRow++;
            }

           
            $standardPart  = $this->standardPartModel->where('overview_id', $overview['id'])->findAll();
            $startRow = 49;
            foreach ($standardPart as $data) {
                $sheet->setCellValue("C{$startRow}", $data['sp_part_list'] ?? '');
                $sheet->setCellValue("D{$startRow}", $data['sp_material_spec'] ?? '');
                $sheet->setCellValue("E{$startRow}", $data['sp_size_type'] ?? '');
                $sheet->setCellValue("H{$startRow}", $data['sp_qty'] ?? '');
                $startRow++;
            }

       

            // =======================================================
            // 6. Mapping Data Main Material (DcpMainMaterialModel)
            // =======================================================
            $mainMaterialModel = new DcpMainMaterialModel();
            $mmData = $mainMaterialModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $startRow = 26;
            foreach ($mmData as $data) {
                $sheet->setCellValue("C{$startRow}", $data['mm_part_list'] ?? '');
                $sheet->setCellValue("D{$startRow}", $data['mm_material_spec'] ?? '');
                $sheet->setCellValue("E{$startRow}", $data['mm_size_type_l'] ?? '');
                $sheet->setCellValue("F{$startRow}", $data['mm_size_type_w'] ?? '');
                $sheet->setCellValue("G{$startRow}", $data['mm_size_type_h'] ?? '');
                $sheet->setCellValue("H{$startRow}", $data['mm_qty'] ?? '');
                $sheet->setCellValue("I{$startRow}", $data['mm_weight'] ?? '');
                $startRow++;
            }
            
            // =======================================================
            // 7. Mapping Data Machining (DcpMachiningModel)
            // =======================================================
            $machiningModel = new DcpMachiningModel();
            $machiningData  = $machiningModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $startRow       = 99; 
            foreach ($machiningData as $data) {
                $sheet->setCellValue("D{$startRow}", $data['machining_man_power'] ?? '');
                $sheet->setCellValue("G{$startRow}", $data['machining_working_time'] ?? '');
                $startRow++;
                if ($startRow > 100) break;
            }
            
            
            
            // =======================================================
            // 8. Mapping Data Machining Model2 (DcpMachining2Model)
            // =======================================================
            $machining2Model = new DcpMachining2Model();
            $machining2Data  = $machining2Model->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row             = 102;
            $totalLeadTime   = 0; 
            
            foreach ($machining2Data as $data) {
                $leadTime = $data['machining_lead_time'] ?? 0;
                $sheet->setCellValue("D{$row}", $data['machining_kom'] ?? '');
                $sheet->setCellValue("G{$row}", $leadTime);
                $sheet->setCellValue("H{$row}", $data['machining_lead_time_h'] ?? '');
                
                $totalLeadTime += $leadTime;
                
                $row++;
                if ($row > 114) break;
            }
            
            $sheet->setCellValue("G115", $totalLeadTime);
            
            $finishing  = $this->finishingModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row        = 31;
            if ($finishing) {
                foreach ($finishing as $data) {
                    $sheet->setCellValue("O{$row}", $data['finishing_kom'] ?? '');
                    $sheet->setCellValue("Q{$row}", $data['finishing_lead_time'] ?? '');
                    $row++;
                    if ($row > 31) break;
                }
            }
            

            
            $finishing2 = $this->finishing2Model->where('overview_id', $overview['id'] ?? 0)->findAll();
         
            $row             = 33;
            foreach ($finishing2 as $data) {
                // $sheet->setCellValue("N{$row}", $data['finishing_mp'] ?? '');
                $sheet->setCellValue("O{$row}", $data['finishing_mp'] ?? '');
                $sheet->setCellValue("P{$row}", $data['finishing_working_time'] ?? '');
                $sheet->setCellValue("R{$row}", $data['finishing_mp_time'] ?? '');
                $row++;
                if ($row > 34) break;
            }
            $finishing3  = $this->finishing3Model->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row             = 13;
          
            foreach ($finishing3 as $data) {
                $sheet->setCellValue("N{$row}", $data['finishing_part_list'] ?? '');
                $sheet->setCellValue("O{$row}", $data['finishing_material_spec'] ?? '');
                $sheet->setCellValue("P{$row}", $data['finishing_size_type'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['finishing_qty'] ?? '');
                $row++;
             
                if ($row > 29) break;
            }

         

            // =======================================================
            // 9. Mapping Data Heat Treatment (DcpHeatTreatmentModel)
            // =======================================================
            $heatTreatmentModel = new DcpHeatTreatmentModel();
            $heatData = $heatTreatmentModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 38; 
            foreach ($heatData as $data) {
                $sheet->setCellValue("O{$row}", $data['heat_machine'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['heat_weight'] ?? '');
                $row++;
                if ($row > 40) break;
            }
            
            
            // =======================================================
            // 10. Mapping Data Die Spot 1 (DcpDieSpot1Model)
            // =======================================================
            $dieSpot1Model = new DcpDieSpot1Model();
            $dieSpot1Data = $dieSpot1Model->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 44;
            foreach ($dieSpot1Data as $data) {
                $sheet->setCellValue("N{$row}", $data['die_spot_part_list'] ?? '');
                $sheet->setCellValue("O{$row}", $data['die_spot_material'] ?? '');
                $sheet->setCellValue("P{$row}", $data['die_spot_qty'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['die_spot_weight'] ?? '');
                $row++;
                if ($row > 49) break;
            }
            
            // =======================================================
            // 11. Mapping Data Die Spot 2 (DcpDieSpot2Model)
            // =======================================================
            $dieSpot2Model = new DcpDieSpot2Model();
            $dieSpot2Data = $dieSpot2Model->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 51;
            foreach ($dieSpot2Data as $data) {
                $sheet->setCellValue("O{$row}", $data['die_spot_kom'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['die_spot_lead_time'] ?? '');
                $row++;
                if ($row > 52) break;
            }
            // =======================================================
            // 12. Mapping Data Die Spot 3 (DcpDieSpot3Model)
            // =======================================================
            $dieSpot3Model = new DcpDieSpot3Model();
            $dieSpot3Data = $dieSpot3Model->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 54;
            foreach ($dieSpot3Data as $data) {
                $sheet->setCellValue("O{$row}", $data['die_spot_mp'] ?? '');
                $sheet->setCellValue("P{$row}", $data['die_spot_working_time'] ?? '');
                $sheet->setCellValue("R{$row}", $data['die_spot_mp_time'] ?? '');
                $row++;
                if ($row > 56) break;
            }
            
            // =======================================================
            // 13. Mapping Data Tool Cost (DcpToolCostModel)
            // =======================================================
            $toolCostModel = new DcpToolCostModel();
            $toolCostData = $toolCostModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 60;
        
            foreach ($toolCostData as $data) {
                $sheet->setCellValue("N{$row}", $data['tool_cost_process'] ?? '');
                $sheet->setCellValue("O{$row}", $data['tool_cost_tool'] ?? '');
                $sheet->setCellValue("P{$row}", $data['tool_cost_spec'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['tool_cost_qty'] ?? '');
                $row++;
                if ($row > 79) break;
            }
            
            // =======================================================
            // 14. Mapping Data Aksesoris (DcpAksesorisModel)
            // =======================================================
            $aksesorisModel = new DcpAksesorisModel();
            $aksesorisData = $aksesorisModel->where('overview_id', $overview['id'] ?? 0)->findAll();
            $row = 90;
            foreach ($aksesorisData as $data) {
                $sheet->setCellValue("N{$row}", $data['aksesoris_part_list'] ?? '');
                $sheet->setCellValue("O{$row}", $data['aksesoris_spec'] ?? '');
                $sheet->setCellValue("Q{$row}", $data['aksesoris_qty'] ?? '');
                $row++;
                if ($row > 105) break;
            }
         
        }
        // foreach ($spreadsheet->getAllSheets() as $sheet) {
       
        //     $sheet->getProtection()->setSheet(true);
        //     $sheet->getProtection()->setPassword('rnd');
            
        //     $sheet->getProtection()->setSelectLockedCells(true);
        //     $sheet->getProtection()->setSelectUnlockedCells(true);
        // }
        for ($idx = $spreadsheet->getSheetCount() - 1; $idx >= 0; $idx--) {
            $sheet = $spreadsheet->getSheet($idx);
            if (! in_array($sheet->getTitle(), $usedSheets)) {
                $spreadsheet->removeSheetByIndex($idx);
            }
        }
        $filename = 'DCP ';
        if ($firstOverview) {
            $filename .= $firstOverview['part_no'] . '_' . $firstOverview['part_name'];
        } else {
            $filename .= ' ' . date('Ymd_His');
        }
        $filename .= '.xlsx';
    
          // exit();
        // =======================================================
        // 15. Output File Excel dengan multi worksheet
        // =======================================================
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }
    public function getSpMaterialSpec()
    {
        $keyword = $this->request->getGet('q'); // Ambil keyword dari query string
    
        $standardPart = $this->db_tooling
            ->table('parts')
            ->select('description')
            ->where('status', 1)
            ->like('category', $keyword)
            ->get()
            ->getResultArray();
    
        $descriptions = array_unique(array_column($standardPart, 'description'));
    
        return $this->response->setJSON($descriptions);
    }
    public function getSpMaterialSpec2()
    {
        $keyword = $this->request->getGet('q'); 
    
        $standardPart = $this->db_tooling
            ->table('parts')
            ->select('description')
            ->where('status', 1)
            ->like('description', $keyword)
            ->get()
            ->getResultArray();
    
        $descriptions = array_unique(array_column($standardPart, 'description'));
    
        return $this->response->setJSON($descriptions);
    }

public function convertDcp()
{
    if ($this->request->getMethod() !== 'POST') {
        return redirect()->back()->with('error', 'Invalid request method');
    }

    $sourceDcpId = $this->request->getPost('source_dcp_id');
    $targetDieId = $this->request->getPost('target_die_id');

    if (empty($sourceDcpId) || empty($targetDieId)) {
        return redirect()->back()->with('error', 'Parameter tidak lengkap');
    }

    $dcpOverviewModel = new \App\Models\dcp\DcpOverviewModel();
    $ppsDiesModel = new \App\Models\PpsDiesModel();

    try {
        
        $db = \Config\Database::connect();
        $db->transStart();

        $sourceDcp = $dcpOverviewModel->find($sourceDcpId);
        if (!$sourceDcp) {
            $db->transRollback();
            return redirect()->back()->with('error', 'DCP sumber tidak ditemukan');
        }

        $targetDie = $ppsDiesModel->find($targetDieId);
        if (!$targetDie) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Die target tidak ditemukan');
        }

        $existingDcp = $dcpOverviewModel->where('id_pps_dies', $targetDieId)->first();
        if ($existingDcp && $existingDcp['id'] != $sourceDcpId) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Die target sudah digunakan oleh DCP lain');
        }

        $updateData = [
            'id_pps_dies' => $targetDieId
        ];

        $updated = $dcpOverviewModel->update($sourceDcpId, $updateData);
        
        if (!$updated) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal mengupdate DCP');
        }
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal melakukan konversi DCP');
        }

        $targetInfo = $targetDie['process'];
        if (!empty($targetDie['proses'])) {
            $targetInfo .= ' - ' . $targetDie['proses'];
        }
        
        $successMsg = "DCP berhasil dikonversi ke {$targetInfo}";
        
        return redirect()->back()->with('success', $successMsg);

    } catch (\Exception $e) {
  
        if (isset($db)) {
            $db->transRollback();
        }
        
        log_message('error', 'DCP Conversion Error: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
    
}
