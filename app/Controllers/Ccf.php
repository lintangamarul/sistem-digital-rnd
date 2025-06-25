<?php 
namespace App\Controllers;

use App\Models\ccf\CcfOverviewModel;
use App\Models\ccf\CcfDesignProgramModel;
use App\Models\ccf\CcfPollyModel;
use App\Models\ccf\CcfMainMaterialModel;
use App\Models\ccf\CcfStandardPartModel;
use App\Models\ccf\CcfMachiningModel;
use App\Models\ccf\CcfFinishingModel;
use App\Models\ccf\CcfFinishing2Model;
use App\Models\ccf\CcfFinishing3Model;  
use App\Models\ccf\CcfHeatTreatmentModel;
use App\Models\ccf\CcfDieSpot1Model;
use App\Models\ccf\CcfDieSpot2Model;
use App\Models\ccf\CcfDieSpot3Model;
use App\Models\ccf\CcfToolCostModel;
use App\Models\ccf\CcfMasterToolCostModel;
use App\Models\ccf\CcfAksesorisModel;
use App\Models\ccf\CcfMasterFinishing3Model;
use App\Models\ccf\CcfMasterMainMaterialModel;
use App\Models\ccf\CcfMasterStandardPartModel;
use App\Models\PpsModel;
use App\Models\PpsDiesModel;
use App\Models\CuttingToolModel;
use App\Models\FinishingModel;
use App\Models\ccf\CcfMachining2Model;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\ProjectModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Ccf extends BaseController
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
    protected $masterToolCostModel;
    protected $aksesorisModel;
    protected $dieSpotModel2;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db_tooling = \Config\Database::connect('defaultTooling');

        $this->overviewModel = new CcfOverviewModel();
        $this->designProgramModel = new CcfDesignProgramModel();
    
        $this->polyModel = new CcfPollyModel();
  
        $this->mainMaterialModel = new CcfMainMaterialModel();
        $this->standardPartModel = new CcfStandardPartModel();
        $this->machiningModel = new CcfMachiningModel();
        $this->machining2Model = new CcfMachining2Model();
        $this->finishingModel = new CcfFinishingModel();
        $this->finishing2Model = new CcfFinishing2Model();
        $this->finishing3Model = new CcfFinishing3Model();
        $this->heatTreatmentModel = new CcfHeatTreatmentModel();
        $this->dieSpotModel1        = new CcfDieSpot1Model();
        $this->dieSpotModel3        = new CcfDieSpot3Model();
        $this->toolCostModel        = new CcfToolCostModel();
        $this->masterToolCostModel        = new CcfMasterToolCostModel();
        $this->aksesorisModel       = new CcfAksesorisModel();        
        $this->dieSpotModel2 = new CcfDieSpot2Model();
    }

    public function index()
    {
        // $all = $this->overviewModel->where('status', 1)->where('jenis', 'CCF')->findAll();
        $all = $this->overviewModel->where('jenis', 'CCF')->findAll();
    
        $groupedCcf = [];
        foreach ($all as $row) {
            $groupedCcf[$row['part_no']][] = $row;
        }
    
        // kirim ke view
        return view('ccf/index', [
            'groupedCcf' => $groupedCcf
        ]);
    }
    

    public function create() 
    {
        $data['projects'] = (new ProjectModel())
            ->where('status', 1)
            ->where('jenis !=', 'Others')
            ->orderBy('model')
            ->orderBy('part_no')
            ->findAll();
        
        $data['tool_cost'] = (new CcfMasterToolCostModel())
            ->where('status', 1)
            ->where('jenis', 'CCF')
            ->findAll();
        
        $data['ccf_master_finishing_3'] = (new CcfMasterFinishing3Model()) 
        ->where('jenis', 'CCF')
            ->findAll();
            $model = new CcfMasterMainMaterialModel();
            $data['ccf_master_main_material'] = $model->where('jenis', 'CCF')->findAll();
         
            $data['ccf_master_standard_part'] = (new CcfMasterStandardPartModel())->where('jenis', 'CCF')->findAll();

            return view('ccf/create', $data);
    }
    

    public function getLeadTime($class)
    {
        $leadTimeModel = new \App\Models\ccf\CcfLeadTimeModel();
    
        $dataDesign = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'Designing')
            ->first();
    
        $dataProg = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'Programming')
            
            ->first();
    
        $dataFinish = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'Finishing')
            ->first();
            $dataMachining = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'MACHINING')
            ->first();
            $dataFabrikasi = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'FABRIKASI')
            ->first();
            $dataAssembly = $leadTimeModel
            ->where('class', $class)
            ->where('category', 'ASSEMBLING')
            ->first();
        
            $payload = [
            'class' => $class,
            'designing' => [
                'hour' => $dataDesign['hour'] ?? null,
                'cost' => $dataDesign['cost'] ?? null,
            ],
            'programming' => [
                'hour' => $dataProg['hour'] ?? null,
                'cost' => $dataProg['cost'] ?? null,
            ],
            'finishing' => $dataFinish['hour'] ?? null,
            'machining' => [
                'hour' => $dataMachining['hour'] ?? null,
                'cost' => $dataMachining['cost'] ?? null,
            ],
            'fabrikasi' => [
                'hour' => $dataFabrikasi['hour'] ?? null,
                'cost' => $dataFabrikasi['cost'] ?? null,
            ],
            'assembly' => [
                'hour' => $dataAssembly['hour'] ?? null,
                'cost' => $dataAssembly['cost'] ?? null,
            ],
        ];
    
        return $this->response->setJSON($payload);
    }
    
    public function store()
    {
        $validation = \Config\Services::validation();
        $session    = session();

        $validation->setRules([
            'part_no'    => 'required',
            'class'      => 'required',
            'cf_process' => 'required',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $validation->getErrors());
        }

        $debug = [];

        $fileSketch = $this->request->getFile('sketch');
        $newName    = null;
        if ($fileSketch && $fileSketch->isValid() && ! $fileSketch->hasMoved()) {
            $newName = $fileSketch->getRandomName();
            $fileSketch->move(FCPATH . 'uploads/ccf', $newName);
        }

        $cfDimension = implode('x', [
            $this->request->getPost('cf_length'),
            $this->request->getPost('cf_width'),
            $this->request->getPost('cf_height'),
        ]);
        $overviewData = [
            'jenis'      => 'CCF',
            'customer'      => $this->request->getPost('cust'),
            'part_name'     => $this->request->getPost('part_name'),
            'part_no'       => $this->request->getPost('part_no'),
            'sketch'        => $newName,
            'cf_process'    => $this->request->getPost('cf_process'),
            'cf_dimension'  => $cfDimension,
            'weight'        => $this->request->getPost('cf_weight'),
            'model'         => $this->request->getPost('model'),
            'class'         => $this->request->getPost('class'),
            'ukuran_part'   => $this->request->getPost('ukuran_part'),
            'status'        => 1,              
        ];

        // 4) Insert Overview
        if ($this->overviewModel->insert($overviewData)) {
            $debug[] = "[OVERVIEW] SUCCESS\n" 
                . $this->db->getLastQuery()->getQuery();          // *** DEBUG ***
        } else {
            $debug[] = "[OVERVIEW] FAILED\n" 
                . json_encode($this->overviewModel->errors());    // *** DEBUG ***
        }
        $overviewId = $this->overviewModel->getInsertID();

        // 5) Insert Design & Program
        $dp = [
            'overview_id'         => $overviewId,
            'design_man_power'    => $this->request->getPost('design_man_power'),
            'design_working_time' => $this->request->getPost('design_working_time'),
            'prog_man_power'      => $this->request->getPost('prog_man_power'),
            'prog_working_time'   => $this->request->getPost('prog_working_time'),
        ];
        if ($this->designProgramModel->insert($dp)) {
            $debug[] = "[DESIGN] SUCCESS\n" . $this->db->getLastQuery()->getQuery(); // *** DEBUG ***
        } else {
            $debug[] = "[DESIGN] FAILED\n" . json_encode($this->designProgramModel->errors());
        }

        // 6) InsertBatch Main Material
        $mmData = [];
        foreach ($this->request->getPost('mm_part_list') ?? [] as $i => $part) {
            $mmData[] = [
                'overview_id'     => $overviewId,
                'mm_part_list'    => $part,
                'mm_material_spec'=> $this->request->getPost('mm_material_spec')[$i],
                'mm_size_type_l'  => $this->request->getPost('mm_size_type_l')[$i],
                'mm_size_type_w'  => $this->request->getPost('mm_size_type_w')[$i],
                'mm_size_type_h'  => $this->request->getPost('mm_size_type_h')[$i],
                'mm_qty'          => $this->request->getPost('mm_qty')[$i],
                'mm_weight'       => $this->request->getPost('mm_weight')[$i],
            ];
        }
        if (! empty($mmData)) {
            if ($this->mainMaterialModel->insertBatch($mmData)) {
                $debug[] = "[MM] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
            } else {
                $debug[] = "[MM] FAILED\n" . json_encode($this->mainMaterialModel->errors());
            }
        }

        // 7) InsertBatch Standard Part
        $spData = [];
        foreach ($this->request->getPost('sp_part_list') ?? [] as $i => $part) {
            $spData[] = [
                'overview_id'      => $overviewId,
                'sp_part_list'     => $part,
                'sp_material_spec' => $this->request->getPost('sp_material_spec')[$i],
                'sp_size_type'     => $this->request->getPost('sp_size_type')[$i],
                'sp_qty'           => $this->request->getPost('sp_qty')[$i],
            ];
        }
        if (! empty($spData)) {
            if ($this->standardPartModel->insertBatch($spData)) {
                $debug[] = "[SP] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
            } else {
                $debug[] = "[SP] FAILED\n" . json_encode($this->standardPartModel->errors());
            }
        }

        // 8) InsertBatch Machining (table1 & table2)
        $m1 = []; foreach ($this->request->getPost('machining_process') ?? [] as $i => $p) {
            $m1[] = [
                'overview_id'   => $overviewId,
                'machining_process'       => $p,
                'machining_man_power'     => $this->request->getPost('machining_man_power')[$i],
                'machining_working_time'  => $this->request->getPost('machining_working_time')[$i],
            ];
        }
        if (! empty($m1) && $this->machiningModel->insertBatch($m1)) {
            $debug[] = "[M1] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        $m2 = []; 
        foreach ($this->request->getPost('machining_proc') ?? [] as $i => $p) {
            $m2[] = [
                'overview_id' => $overviewId,
                'machining_proc'     => $p,
                'machining_kom'     => $this->request->getPost('machining_kom')[$i],
                'machining_lead_time'   => $this->request->getPost('machining_lead_time')[$i],
            ];
        }
        if (! empty($m2) && $this->machining2Model->insertBatch($m2)) {
            $debug[] = "[M2] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        // 9) InsertBatch Finishing (3 tables)
        $f3= []; foreach ($this->request->getPost('finishing_part_list') ?? [] as $i => $part) {
            $f3[] = [
                'overview_id'  => $overviewId,
                'finishing_part_list'    => $part,
                'finishing_material_spec'=> $this->request->getPost('finishing_material_spec')[$i],
                'finishing_size_type'    => $this->request->getPost('finishing_size_type')[$i],
                'finishing_qty'          => $this->request->getPost('finishing_qty')[$i],
            ];
        }
        if (! empty($f3) && $this->finishing3Model->insertBatch($f3)) {
            $debug[] = "[F3] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        $f1 = []; foreach ($this->request->getPost('finishing_process2') ?? [] as $i => $proc) {
            $f1[] = [
                'overview_id'=> $overviewId,
                'finishing_process'    => $proc,
                'finishing_kom'    => $this->request->getPost('finishing_kom')[$i],
                'finishing_lead_time'  => $this->request->getPost('finishing_lead_time')[$i],
            ];
        }
        if (! empty($f1) && $this->finishingModel->insertBatch($f1)) {
            $debug[] = "[f1] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        $f2 = []; foreach ($this->request->getPost('finishing_process3') ?? [] as $i => $proc) {
            $f2[] = [
                'overview_id'   => $overviewId,
                'finishing_process'       => $proc,
                'finishing_mp'     => $this->request->getPost('finishing_mp')[$i],
                'finishing_working_time'  => $this->request->getPost('finishing_working_time')[$i],
            ];
        }

        if (! empty($f2) && $this->finishing2Model->insertBatch($f2)) {
            $debug[] = "[F2] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        // 10) InsertBatch Heat Treatment
        $h = []; foreach ($this->request->getPost('heat_process') ?? [] as $i => $proc) {
            $h[] = [
                'overview_id'=> $overviewId,
                'heat_process'    => $proc,
                'heat_machine'    => $this->request->getPost('heat_machine')[$i],
                'heat_weight'     => $this->request->getPost('heat_weight')[$i],
            ];
        }
        if (! empty($h) && $this->heatTreatmentModel->insertBatch($h)) {
            $debug[] = "[HEAT] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
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
      
        $die_spot_process2      = $this->request->getPost('die_spot_process2');
        $die_spot_process3      = $this->request->getPost('die_spot_process3');
        // 11) InsertBatch DieSpot
        $d1 = []; foreach ($this->request->getPost('die_spot_part_list') ?? [] as $i => $part) {
            $d1[] = [
                'overview_id'=> $overviewId,
                'die_spot_part_list'  => $part,
                'die_spot_material'   => $this->request->getPost('die_spot_material')[$i],
                'die_spot_qty'        => $this->request->getPost('die_spot_qty')[$i],
                'die_spot_weight'     => $this->request->getPost('die_spot_weight')[$i],
            ];
        }
        if (! empty($d1) && $this->dieSpotModel1->insertBatch($d1)) {
            $debug[] = "[DS1] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

                
        if (is_array($die_spot_process2)) {
            foreach ($die_spot_process2 as $i => $value) {
                $dieSpotData2 = [
                    'overview_id'        => $overviewId,
                    'die_spot_kom'       => is_array($die_spot_kom) ? ($die_spot_kom[$i] ?? null) : null,
                    'die_spot_process'       => $die_spot_process2[$i] ?? null,
                    'die_spot_lead_time' => is_array($dieSpotLeadTime) ? ($dieSpotLeadTime[$i] ?? null) : null
                ];
                $this->dieSpotModel2->insert($dieSpotData2);
            }
        }
        
        if (is_array($die_spot_process3)) {
            foreach ($die_spot_process3 as $i => $value) {
                $dieSpotData3 = [
                    'overview_id'          => $overviewId,
                    'die_spot_process'       => $die_spot_process3[$i] ?? null,
                    'die_spot_mp'          => is_array($dieSpotMp) ? ($dieSpotMp[$i] ?? null) : null,
                    'die_spot_working_time'=> is_array($dieSpotWorkingTime) ? ($dieSpotWorkingTime[$i] ?? null) : null,
                    'die_spot_mp_time'     => is_array($dieSpotMpTime) ? ($dieSpotMpTime[$i] ?? null) : null
                ];
                $this->dieSpotModel3->insert($dieSpotData3);
            }
        }

        // 12) InsertBatch Tool Cost
        $tc = []; foreach ($this->request->getPost('tool_cost_process') ?? [] as $i => $proc) {
            $tc[] = [
                'overview_id'=> $overviewId,
                'tool_cost_process'    => $proc,
                'tool_cost_tool'       => $this->request->getPost('tool_cost_tool')[$i],
                'tool_cost_spec'       => $this->request->getPost('tool_cost_spec')[$i],
                'tool_cost_qty'        => $this->request->getPost('tool_cost_qty')[$i],
            ];
        }
        if (! empty($tc) && $this->toolCostModel->insertBatch($tc)) {
            $debug[] = "[TC] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        // 13) InsertBatch Aksesoris
        $ak = []; foreach ($this->request->getPost('aksesoris_part_list') ?? [] as $i => $part) {
            $ak[] = [
                'overview_id'=> $overviewId,
                'aksesoris_part_list'  => $part,
                'aksesoris_spec'       => $this->request->getPost('aksesoris_spec')[$i],
                'aksesoris_qty'        => $this->request->getPost('aksesoris_qty')[$i],
            ];
        }
        if (! empty($ak) && $this->aksesorisModel->insertBatch($ak)) {
            $debug[] = "[AK] SUCCESS\n" . $this->db->getLastQuery()->getQuery();
        }

        echo "<pre>" . implode("\n\n", $debug) . "</pre>";
        return redirect()->to('/ccf')->with('success', 'Data CCF berhasil disimpan.');
    }

    
    public function edit($id, $mode = 'edit')
    {
        // data utama CCF
        $ccf = $this->overviewModel->find($id);
        if (!$ccf) {
            return redirect()->to('/ccf')->with('error', 'Data CCF tidak ditemukan');
        }
        $db = \Config\Database::connect();
        $data = [
            'ccf' => $ccf,
            'projects' => (new ProjectModel())
                ->where('jenis !=', 'Others')
                ->orderBy('model')
                ->orderBy('part_no')
                ->findAll(),
            'standardParts' => [],
            'mainMaterials' => [],
            'machinings' => [],
            'machinings2' => [],
            'finishings' => [],
            'finishings2' => [],
            'finishings3' => [],
            'heatTreatments' => [],
            'dieSpot1' => [],
            'dieSpot2' => [],
            'dieSpot3' => [],
            'toolCosts' => [],
            'aksesoris' => [],
            'tool_cost' => [],
            'ccf_master_finishing_3' => [],
            'ccf_master_main_material' => []
        ];

        $data['designProgram'] = $this->designProgramModel->where('overview_id', $id)->first();
        $mainMaterials = $db->table('ccf_main_material m')
            ->select('m.*, master.mm_category')
            ->join('ccf_master_main_material master', 'm.mm_part_list = master.mm_part_list', 'left')
            ->where('m.overview_id', $id)
            ->get()
            ->getResultArray();
        
        $standardParts = $db->table('ccf_standard_part sp')
            ->select('sp.*, master.sp_category')
            ->join('ccf_master_standard_part master', 'sp.sp_part_list = master.sp_part_list', 'left')
            ->where('sp.overview_id', $id)
            ->get()
            ->getResultArray();

        $data['mainMaterials'] = $mainMaterials ?: [];
        $data['standardParts'] = $standardParts ?: [];

        $data['machinings'] = $this->machiningModel->where('overview_id', $id)->findAll() ?: [];
        $data['machinings2'] = $this->machining2Model->where('overview_id', $id)->findAll() ?: [];
        $data['finishings'] = $this->finishing3Model->where('overview_id', $id)->findAll() ?: [];
        $data['finishings2'] = $this->finishingModel->where('overview_id', $id)->findAll() ?: [];
        $data['finishings3'] = $this->finishing2Model->where('overview_id', $id)->findAll() ?: [];
        $data['heatTreatments'] = $this->heatTreatmentModel->where('overview_id', $id)->findAll() ?: [];
        $data['dieSpot1'] = $this->dieSpotModel1->where('overview_id', $id)->findAll() ?: [];
        $data['dieSpot2'] = $this->dieSpotModel2->where('overview_id', $id)->findAll() ?: [];
        $data['dieSpot3'] = $this->dieSpotModel3->where('overview_id', $id)->findAll() ?: [];
        $data['toolCosts'] = $this->toolCostModel->where('overview_id', $id)->findAll() ?: [];
        $data['aksesoris'] = $this->aksesorisModel->where('overview_id', $id)->findAll() ?: [];

        $data['tool_cost'] = (new CcfMasterToolCostModel())->where('status', 1)->findAll() ?: [];
        $data['ccf_master_finishing_3'] = (new CcfMasterFinishing3Model())->findAll() ?: [];
        $data['ccf_master_main_material'] = (new CcfMasterMainMaterialModel())->findAll() ?: [];
        
        $viewName = $mode === 'copy' ? 'ccf/edit_copy' : 'ccf/edit';
        return view($viewName, $data);
    }
    public function update($id)
    {
        $validation = \Config\Services::validation();
        $session = session();
        
        $validation->setRules([
            'part_no' => 'required',
            'class' => 'required',
            'cf_process' => 'required'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        try {
            $fileSketch = $this->request->getFile('sketch');
            $newName = $this->request->getPost('existing_sketch');
            
            if ($fileSketch && $fileSketch->isValid() && !$fileSketch->hasMoved()) {

                if ($newName && file_exists(FCPATH . 'uploads/ccf/' . $newName)) {
                    unlink(FCPATH . 'uploads/ccf/' . $newName);
                }
                $newName = $fileSketch->getRandomName();
                $fileSketch->move(FCPATH . 'uploads/ccf', $newName);
            }
    
            // 1. Update Overview
            $cfDimension = implode('x', [
                $this->request->getPost('cf_length'),
                $this->request->getPost('cf_width'),
                $this->request->getPost('cf_height')
            ]);
    
            $overviewData = [
                'customer' => $this->request->getPost('cust'),
                'part_name' => $this->request->getPost('part_name'),
                'part_no' => $this->request->getPost('part_no'),
                'sketch' => $newName,
                'cf_process' => $this->request->getPost('cf_process'),
                'cf_dimension' => $cfDimension,
                'weight' => $this->request->getPost('cf_weight'),
                'model' => $this->request->getPost('model'),
                'class' => $this->request->getPost('class'),
                'ukuran_part' => $this->request->getPost('ukuran_part')
            ];
    
            $this->overviewModel->update($id, $overviewData);

            // 2. Update Design & Program
            $designProgram = $this->designProgramModel->where('overview_id', $id)->first();
            if ($designProgram) {
                $this->designProgramModel->update($designProgram['id'], [
                    'design_man_power' => $this->request->getPost('design_man_power'),
                    'design_working_time' => $this->request->getPost('design_working_time'),
                    'prog_man_power' => $this->request->getPost('prog_man_power'),
                    'prog_working_time' => $this->request->getPost('prog_working_time')
                ]);
            }
    
            // 3. Update Main Material
            $this->mainMaterialModel->where('overview_id', $id)->delete();
            $mmData = [];
            foreach ($this->request->getPost('mm_part_list') as $i => $part) {
                if (!empty($part)) {
                    $mmData[] = [
                        'overview_id' => $id,
                        'mm_part_list' => $part,
                        'mm_material_spec' => $this->request->getPost('mm_material_spec')[$i] ?? null,
                        'mm_size_type_l' => $this->request->getPost('mm_size_type_l')[$i] ?? null,
                        'mm_size_type_w' => $this->request->getPost('mm_size_type_w')[$i] ?? null,
                        'mm_size_type_h' => $this->request->getPost('mm_size_type_h')[$i] ?? null,
                        'mm_qty' => $this->request->getPost('mm_qty')[$i] ?? null,
                        'mm_weight' => $this->request->getPost('mm_weight')[$i] ?? null
                    ];
                }
            }
            if (!empty($mmData)) $this->mainMaterialModel->insertBatch($mmData);
    
            // 4. Update Standard Part
            $this->standardPartModel->where('overview_id', $id)->delete();
            $spData = [];
            foreach ($this->request->getPost('sp_part_list') as $i => $part) {
                if (!empty($part)) {
                    $spData[] = [
                        'overview_id' => $id,
                        'sp_part_list' => $part,
                        'sp_material_spec' => $this->request->getPost('sp_material_spec')[$i] ?? null,
                        'sp_size_type' => $this->request->getPost('sp_size_type')[$i] ?? null,
                        'sp_qty' => $this->request->getPost('sp_qty')[$i] ?? null
                    ];
                }
            }
            if (!empty($spData)) $this->standardPartModel->insertBatch($spData);
    
            // 5. Update Machining
            // Tabel 1
            $this->machiningModel->where('overview_id', $id)->delete();
            $machiningData1 = [];
            $machiningProcesses = $this->request->getPost('machining_process');
            foreach ($machiningProcesses as $i => $process) {
                $machiningData1[] = [
                    'overview_id' => $id,
                    'machining_process' => $process,
                    'machining_man_power' => $this->request->getPost('machining_man_power')[$i] ?? null,
                    'machining_working_time' => $this->request->getPost('machining_working_time')[$i] ?? null
                ];
            }
            if (!empty($machiningData1)) $this->machiningModel->insertBatch($machiningData1);
    
            // Tabel 2
            $this->machining2Model->where('overview_id', $id)->delete();
            $machiningData2 = [];
            $machining_proc = $this->request->getPost('machining_proc');
          
            foreach ($machining_proc as $i => $proc) {
                $machiningData2[] = [
                    'overview_id' => $id,
                    'machining_proc' => $proc,
                    'machining_kom' => $this->request->getPost('machining_kom')[$i] ?? null,
                    'machining_lead_time' => $this->request->getPost('machining_lead_time')[$i] ?? null
                ];
            }
            if (!empty($machiningData2)) $this->machining2Model->insertBatch($machiningData2);
    
    
            // 6. Update Finishing
            // Tabel 1
            $this->finishing3Model->where('overview_id', $id)->delete();
            $finishingData1 = [];
            foreach ($this->request->getPost('finishing_part_list') as $i => $part) {
                if (!empty($part)) {
                    $finishingData1[] = [
                        'overview_id' => $id,
                        'finishing_part_list' => $part,
                        'finishing_material_spec' => $this->request->getPost('finishing_material_spec')[$i] ?? null,
                        'finishing_size_type' => $this->request->getPost('finishing_size_type')[$i] ?? null,
                        'finishing_qty' => $this->request->getPost('finishing_qty')[$i] ?? null
                    ];
                }
            }

            if (!empty($finishingData1)) $this->finishing3Model->insertBatch($finishingData1);
       
          // Tabel 2
            // $this->finishingModel->where('overview_id', $id)->delete();
            // $finishingData2 = [];

            // $finishingProcess2 = $this->request->getPost('finishing_process2');
            // if (is_array($finishingProcess2)) {
            //     foreach ($finishingProcess2 as $i => $process) {
            //         $finishingData2[] = [
            //             'overview_id' => $id,
            //             'finishing_process' => $process,
            //             'finishing_kom' => $this->request->getPost('finishing_kom')[$i] ?? null,
            //             'finishing_lead_time' => $this->request->getPost('finishing_lead_time')[$i] ?? null
            //         ];
            //     }
            //     if (!empty($finishingData2)) {
            //         $this->finishingModel->insertBatch($finishingData2);
            //     }
            // }

            // // Tabel 3
            // $this->finishing2Model->where('overview_id', $id)->delete();
            // $finishingData3 = [];

            // $finishingProcess3 = $this->request->getPost('finishing_process3');
            // if (is_array($finishingProcess3)) {
            //     foreach ($finishingProcess3 as $i => $process) {
            //         $finishingData3[] = [
            //             'overview_id' => $id,
            //             'finishing_process' => $process,
            //             'finishing_man_power' => $this->request->getPost('finishing_mp')[$i] ?? null,
            //             'finishing_working_time' => $this->request->getPost('finishing_working_time')[$i] ?? null
            //         ];
            //     }
            //     if (!empty($finishingData3)) {
            //         $this->finishing2Model->insertBatch($finishingData3);
            //     }
            // }

            // 7. Update Heat Treatment
            $this->heatTreatmentModel->where('overview_id', $id)->delete();
            $heatData = [];
  
            foreach ($this->request->getPost('heat_process') as $i => $process) {
                $heatData[] = [
                    'overview_id' => $id,
                    'heat_process' => $process,
                    'heat_machine' => $this->request->getPost('heat_machine')[$i] ?? null,
                    'heat_weight' => $this->request->getPost('heat_weight')[$i] ?? null
                ];
            }
            if (!empty($heatData)) $this->heatTreatmentModel->insertBatch($heatData);
    
         // 8. Update Die Spot & Try

            // Tabel 1
            $this->dieSpotModel1->where('overview_id', $id)->delete();
            $dieSpotData1 = [];

            $partList1 = $this->request->getPost('die_spot_part_list');
            if (is_array($partList1)) {
                foreach ($partList1 as $i => $part) {
                    $dieSpotData1[] = [
                        'overview_id' => $id,
                        'die_spot_part_list' => $part,
                        'die_spot_material' => $this->request->getPost('die_spot_material')[$i] ?? null,
                        'die_spot_qty' => $this->request->getPost('die_spot_qty')[$i] ?? null,
                        'die_spot_weight' => $this->request->getPost('die_spot_weight')[$i] ?? null
                    ];
                }
                if (!empty($dieSpotData1)) {
                    $this->dieSpotModel1->insertBatch($dieSpotData1);
                }
            }

            // Tabel 2
            $this->dieSpotModel2->where('overview_id', $id)->delete();
            $dieSpotData2 = [];

            $process2 = $this->request->getPost('die_spot_process2');
            if (is_array($process2)) {
                foreach ($process2 as $i => $process) {
                    $dieSpotData2[] = [
                        'overview_id' => $id,
                        'die_spot_process' => $process,
                        'die_spot_kom' => $this->request->getPost('die_spot_kom')[$i] ?? null,
                        'die_spot_lead_time' => $this->request->getPost('die_spot_lead_time')[$i] ?? null
                    ];
                }
                if (!empty($dieSpotData2)) {
                    $this->dieSpotModel2->insertBatch($dieSpotData2);
                }
            }

            // Tabel 3
            $this->dieSpotModel3->where('overview_id', $id)->delete();
            $dieSpotData3 = [];

            $process3 = $this->request->getPost('die_spot_process3');
            if (is_array($process3)) {
                foreach ($process3 as $i => $process) {
                    $dieSpotData3[] = [
                        'overview_id' => $id,
                        'die_spot_process' => $process,
                        'die_spot_mp' => $this->request->getPost('die_spot_mp')[$i] ?? null,
                        'die_spot_working_time' => $this->request->getPost('die_spot_working_time')[$i] ?? null
                    ];
                }
                if (!empty($dieSpotData3)) {
                    $this->dieSpotModel3->insertBatch($dieSpotData3);
                }
            }

        
            // 9. Update Tool Cost
            $this->toolCostModel->where('overview_id', $id)->delete();
            $toolCostData = [];
            foreach ($this->request->getPost('tool_cost_process') as $i => $process) {
                if (!empty($process)) {
                    $toolCostData[] = [
                        'overview_id' => $id,
                        'tool_cost_process' => $process,
                        'tool_cost_tool' => $this->request->getPost('tool_cost_tool')[$i] ?? null,
                        'tool_cost_spec' => $this->request->getPost('tool_cost_spec')[$i] ?? null,
                        'tool_cost_qty' => $this->request->getPost('tool_cost_qty')[$i] ?? null
                    ];
                }
            }
            if (!empty($toolCostData)) $this->toolCostModel->insertBatch($toolCostData);
    
            // 10. Update Aksesoris
            $this->aksesorisModel->where('overview_id', $id)->delete();
            $aksesorisData = [];
            foreach ($this->request->getPost('aksesoris_part_list') as $i => $part) {
                if (!empty($part)) {
                    $aksesorisData[] = [
                        'overview_id' => $id,
                        'aksesoris_part_list' => $part,
                        'aksesoris_spec' => $this->request->getPost('aksesoris_spec')[$i] ?? null,
                        'aksesoris_qty' => $this->request->getPost('aksesoris_qty')[$i] ?? null
                    ];
                }
            }
            if (!empty($aksesorisData)) $this->aksesorisModel->insertBatch($aksesorisData);
            return redirect()->to('/ccf')->with('success', 'Data CCF berhasil diperbarui');
        } catch (\Exception $e) {
            // $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $ccf = $this->overviewModel->find($id);

        if (!$ccf) {
            return redirect()->to('/ccf')->with('error', 'Data tidak ditemukan.');
        }

        $this->overviewModel->update($id, ['status' => 0]);

        return redirect()->to('/ccf')->with('success', 'Data berhasil dihapus.');
    }
    public function rollback($id)
    {
        $model = new CcfOverviewModel();
        $data = $model->find($id);
    
        if ($data) {
            $model->update($id, ['status' => 1]);
            return redirect()->to('/ccf')->with('message', 'Data berhasil dikembalikan.');
        } else {
            return redirect()->to('/ccf')->with('error', 'Data tidak ditemukan.');
        }
    }
      
    public function generateExcel($id)
    {
        $password     = 'rnd';
        $templatePath = FCPATH . 'uploads/template/templateCcf.xlsx';
        $spreadsheet  = IOFactory::load($templatePath);
        $usedSheets   = [];
    
        $overview = $this->overviewModel
                         ->where('id', $id)
                         ->first();
    
        if (! $overview) {
            throw new \RuntimeException("Overview untuk CCF ID {$id} tidak ditemukan");
        }
    
        $sheet = $spreadsheet->getSheetByName('template');

        $newWorksheetName = trim($overview['part_no'], ', -');

        $invalidChars = ['\\', '/', '*', ':', '?', '[', ']'];

        $newWorksheetName = str_replace($invalidChars, '-', $newWorksheetName);

        $newWorksheetName = mb_substr($newWorksheetName, 0, 31);

        if (empty(trim($newWorksheetName, '-'))) {
            $newWorksheetName = 'Sheet_' . date('YmdHis');
        }

        $sheet->setTitle($newWorksheetName);
        $usedSheets[] = $newWorksheetName;
        $sheet = $spreadsheet->getSheetByName($newWorksheetName);

    
        $sheet->setCellValue('J3', $overview['customer']);
        $sheet->setCellValue('K3', $overview['model']);
        $sheet->setCellValue('J4', $overview['part_no']);
        $sheet->setCellValue('J5', $overview['part_name']);
        $sheet->setCellValue('J6', $overview['cf_process']);
        $sheet->setCellValue('J7', $overview['cf_dimension']);
        $sheet->setCellValue('J8', $overview['weight']);
    
        if (!empty($overview['sketch'])) {
            $file = FCPATH . 'uploads/ccf/' . $overview['sketch'];
            if (file_exists($file)) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Sketch');
                $drawing->setDescription('Sketch Image');
                $drawing->setPath($file);
                $drawing->setCoordinates('N6');
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawing->setResizeProportional(false);
                $drawing->setWidthAndHeight(120, 110);   
                $drawing->setWorksheet($sheet);         
            }
        }
        
    
        $class = strtoupper(substr($overview['class'] ?? '',0,1));
        $map   = ['A'=>'P6','B'=>'P7','C'=>'P8','D'=>'P9'];
        if (isset($map[$class])) {
            $sheet->getStyle($map[$class])
                  ->getFill()
                  ->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('FFFFFF00');
        }

        $dp = $this->designProgramModel
                   ->where('overview_id',$overview['id'])
                   ->first();
        $sheet->setCellValue('E14', $dp['design_man_power'] ?? '')
              ->setCellValue('G14', $dp['design_working_time'] ?? '')
              ->setCellValue('E15', $dp['prog_man_power'] ?? '')
              ->setCellValue('G15', $dp['prog_working_time'] ?? '');
    
        // Polly
        $poly = $this->polyModel->where('overview_id',$overview['id'])->findAll();

        // Standard Part
        $std = $this->standardPartModel
            ->select('ccf_standard_part.*, ccf_master_standard_part.sp_category')
            ->join('ccf_master_standard_part', 'ccf_standard_part.sp_part_list = ccf_master_standard_part.sp_part_list', 'left')
            ->where('ccf_standard_part.overview_id', $overview['id'])
                 ->where('ccf_master_standard_part.jenis', 'CCF')
            ->findAll();

        // Group berdasarkan sp_category
        $groupedStd = [];
        foreach ($std as $row) {
            $groupedStd[$row['sp_category']][] = $row;
        }

        $r = 37;
        $no = 1;

        foreach ($groupedStd as $category => $items) {
            $sheet->setCellValue("C{$r}", $no++)
                ->setCellValue("D{$r}", strtoupper($category));
            $sheet->getStyle("D{$r}")->getFont()->setBold(true);
            $r++;

            foreach ($items as $d) {
                $sheet->setCellValue("D{$r}", $d['sp_part_list'])
                    ->setCellValue("E{$r}", $d['sp_material_spec'])
                    ->setCellValue("F{$r}", $d['sp_size_type'])
                    ->setCellValue("I{$r}", $d['sp_qty']);
                $r++;

                if ($r > 77) break 2; 
            }
        }

            // Main Material
        $mm = $this->mainMaterialModel
            ->select('ccf_main_material.*, ccf_master_main_material.mm_category')
            ->join('ccf_master_main_material', 'ccf_main_material.mm_part_list = ccf_master_main_material.mm_part_list', 'left')
            ->where('ccf_main_material.overview_id', $overview['id'])
            ->findAll();

        // Kelompokkan berdasarkan kategori
        $grouped = [];
        foreach ($mm as $row) {
            $grouped[$row['mm_category']][] = $row;
        }

        $r  = 19; // baris awal
        $no = 1;  // nomor kategori

        foreach ($grouped as $category => $items) {
            // Tampilkan nomor hanya di kategori
            $sheet->setCellValue("C{$r}", $no++)
                ->setCellValue("D{$r}", strtoupper($category));
            $r++;

            if ($r > 33) break;

            foreach ($items as $d) {
                $sheet->setCellValue("D{$r}", $d['mm_part_list'])
                    ->setCellValue("E{$r}", $d['mm_material_spec'])
                    ->setCellValue("F{$r}", $d['mm_size_type_l'])
                    ->setCellValue("G{$r}", $d['mm_size_type_w'])
                    ->setCellValue("H{$r}", $d['mm_size_type_h'])
                    ->setCellValue("I{$r}", $d['mm_qty'])
                    ->setCellValue("J{$r}", $d['mm_weight']);

                $r++;
                if ($r > 33) break;
            }
        }

        // Machining
        $mc = $this->machiningModel->where('overview_id',$overview['id'])->findAll();
       
        
        $r = 81;
        foreach($mc as $d){
               $sheet
                ->setCellValue("D{$r}", $d['machining_process'])
                ->setCellValue("E{$r}", $d['machining_man_power'])
                ->setCellValue("H{$r}", $d['machining_working_time']);
                $r++;
          if ($r>87) break;
        }
    
        // Machining2
        $m2 = $this->machining2Model->where('overview_id',$overview['id'])->findAll();
        $r = 89; $tot=0;
        foreach($m2 as $d){
          $sheet->setCellValue("D{$r}", $d['machining_proc'])
             ->setCellValue("E{$r}", $d['machining_kom'])
                ->setCellValue("I{$r}", $d['machining_lead_time'])
                ->setCellValue("J{$r}", $d['machining_lead_time_h']);
                $r++;
          $tot += $d['machining_lead_time'];
          if ($r>96) break;
        }
        $sheet->setCellValue('G115',$tot);
    
        // Finishing
        $f1 = $this->finishingModel->where('overview_id',$overview['id'])->findAll();
        $r=23;
        foreach($f1 as $d){
          $sheet->setCellValue("P{$r}", $d['finishing_kom'])
                ->setCellValue("R{$r}", $d['finishing_lead_time']);
          if (++$r>24) break;
        }
    
        // Finishing2
        $f2 = $this->finishing2Model->where('overview_id',$overview['id'])->findAll();
        $r=26;
        foreach($f2 as $d){
          $sheet->setCellValue("P{$r}", $d['finishing_mp'])
                ->setCellValue("Q{$r}", $d['finishing_working_time']);
          if (++$r>27) break;
        }
    
        // Finishing3
        $f3 = $this->finishing3Model->where('overview_id',$overview['id'])->findAll();
        $r=14;
        foreach($f3 as $d){
          $sheet->setCellValue("O{$r}", $d['finishing_part_list'])
                ->setCellValue("P{$r}", $d['finishing_material_spec'])
                ->setCellValue("Q{$r}", $d['finishing_size_type'])
                ->setCellValue("R{$r}", $d['finishing_qty']);
          if (++$r>20) break;
        }
    
        // Heat Treatment
        $ht = $this->heatTreatmentModel->where('overview_id',$overview['id'])->findAll();
        $r=31;
        foreach($ht as $d){
          $sheet->setCellValue("O{$r}", $d['heat_process'])
                ->setCellValue("P{$r}", $d['heat_machine'])
                ->setCellValue("R{$r}", $d['heat_weight']);
          if (++$r>33) break;
        }
    
          
            
        
        // =======================================================
        // 10. Mapping Data Die Spot 1 (DcpDieSpot1Model)
        // =======================================================
        $dieSpot1Model = new CcfDieSpot1Model();
        $dieSpot1Data = $dieSpot1Model->where('overview_id', $overview['id'] ?? 0)->findAll();
        $row = 37;
        foreach ($dieSpot1Data as $data) {
            $sheet->setCellValue("O{$row}", $data['die_spot_part_list'] ?? '');
            $sheet->setCellValue("P{$row}", $data['die_spot_material'] ?? '');
            $sheet->setCellValue("Q{$row}", $data['die_spot_qty'] ?? '');
            $sheet->setCellValue("R{$row}", $data['die_spot_weight'] ?? '');
            $row++;
            if ($row > 45) break;
        }
        
        // // =======================================================
        // // 11. Mapping Data Die Spot 2 (DcpDieSpot2Model)
        // // =======================================================
        $dieSpot2Model = new CcfDieSpot2Model();
        $dieSpot2Data = $dieSpot2Model->where('overview_id', $overview['id'] ?? 0)->findAll();
        $row = 47;
        foreach ($dieSpot2Data as $data) {
            $sheet->setCellValue("O{$row}", $data['die_spot_process'] ?? '');
            $sheet->setCellValue("P{$row}", $data['die_spot_kom'] ?? '');
            $sheet->setCellValue("R{$row}", $data['die_spot_lead_time'] ?? '');
            $row++;
            if ($row > 51) break;
        }
        // // =======================================================
        // // 12. Mapping Data Die Spot 3 (CcfDieSpot3Model)
        // // =======================================================
        $dieSpot3Model = new CcfDieSpot3Model();
        $dieSpot3Data = $dieSpot3Model->where('overview_id', $overview['id'] ?? 0)->findAll();
        $row = 53;
        foreach ($dieSpot3Data as $data) {
            $sheet->setCellValue("O{$row}", $data['die_spot_process'] ?? '');
            $sheet->setCellValue("P{$row}", $data['die_spot_mp'] ?? '');
            $sheet->setCellValue("Q{$row}", $data['die_spot_working_time'] ?? '');
            $row++;
            if ($row > 57) break;
        }
        
        // =======================================================
        // 13. Mapping Data Tool Cost (CcfToolCostModel)
        // =======================================================
        $toolCostModel = new CcfToolCostModel();
        $toolCostData = $toolCostModel->where('overview_id', $overview['id'] ?? 0)->findAll();
        $row = 61;
        $no = 1;
    
        foreach ($toolCostData as $data) {
            $sheet->setCellValue("N{$row}", $no++);
            $sheet->setCellValue("O{$row}", $data['tool_cost_process'] ?? '');
            $sheet->setCellValue("P{$row}", $data['tool_cost_tool'] ?? '');
            $sheet->setCellValue("Q{$row}", $data['tool_cost_spec'] ?? '');
            $sheet->setCellValue("R{$row}", $data['tool_cost_qty'] ?? '');
            $row++;
            if ($row > 73) break;
        }
        
        // =======================================================
        // 14. Mapping Data Aksesoris (DcpAksesorisModel)
        // =======================================================
        $aksesorisModel = new CcfAksesorisModel();
        $aksesorisData = $aksesorisModel->where('overview_id', $overview['id'] ?? 0)->findAll();
        $row = 77;
        foreach ($aksesorisData as $data) {
            $sheet->setCellValue("O{$row}", $data['aksesoris_part_list'] ?? '');
            $sheet->setCellValue("P{$row}", $data['aksesoris_spec'] ?? '');
            $sheet->setCellValue("Q{$row}", $data['aksesoris_qty'] ?? '');
            $sheet->setCellValue("R{$row}", $data['aksesoris_qty'] ?? '');
            $row++;
            if ($row > 81) break;
        }

    $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="CCF_'.$overview['part_no'].'.xlsx"');
    $writer->save('php://output');
    exit;
}
    
    

}
