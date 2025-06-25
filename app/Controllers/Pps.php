<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;     
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PpsModel;
use App\Models\PpsDiesModel;
use App\Models\dcp\DcpOverviewModel;
use App\Models\McSpecModel;
use App\Models\MasterTableModel;
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
use App\Models\dcp\CuttingToolModel;
use App\Models\dcp\FinishingModel;
use App\Models\dcp\DcpMachining2Model;
use App\Models\ProjectModel;
use App\Models\MaterialModel;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Models\UserModel;
class Pps extends Controller
{

    protected $ppsModel;
    protected $ppsDiesModel;
    protected $mcSpecModel;
    protected $masterTableModel;


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
        $this->ppsModel = new PpsModel();
        $this->ppsDiesModel = new PpsDiesModel();
        $this->mcSpecModel = new McSpecModel();  
        $this->masterTableModel = new MasterTableModel(); 

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
    // Tampilkan form input
    public function create()
    {
        $mcSpecData = $this->mcSpecModel->findAll();
        
        // Ambil data dari master_table
        $masterTableData = $this->masterTableModel->findAll();
    
        $data['projects'] = (new ProjectModel())
            ->where('status', 1)
            ->where('jenis !=', 'Others')
            ->orderBy('model')
            ->orderBy('part_no')
            ->findAll();
        $materialData = (new \App\Models\MaterialModel())
            ->where('status', 1)
            ->orderBy('name_material', 'ASC')
            ->findAll();
        
        return view('pps/create', [
            'mcSpecData' => $mcSpecData,
            'masterTableData' => $masterTableData,
            'projects' => $data['projects'],
            'materialData' => $materialData,
        ]);
    }
    
    public function index()
    {
        $oneMonthAgo = date('Y-m-d H:i:s', strtotime('-1 month'));
        $expiredPps = $this->ppsModel->where('status', 0)->where('created_at <', $oneMonthAgo)->findAll();
    
        if (!empty($expiredPps)) {
            foreach ($expiredPps as $pps) {
                $ppsId = $pps['id'];
    
                $this->ppsDiesModel->where('pps_id', $ppsId)->delete();
    
                $dcps = $this->overviewModel->where('id_pps_dies', $ppsId)->findAll();
    
                foreach ($dcps as $dcp) {
                    $dcpId = $dcp['id'];
    
                    $this->designProgramModel->where('overview_id', $dcpId)->delete();
                    $this->polyModel->where('overview_id', $dcpId)->delete();
                    $this->mainMaterialModel->where('overview_id', $dcpId)->delete();
                    $this->standardPartModel->where('overview_id', $dcpId)->delete();
                    $this->machiningModel->where('overview_id', $dcpId)->delete();
                    $this->machining2Model->where('overview_id', $dcpId)->delete();
                    $this->finishingModel->where('overview_id', $dcpId)->delete();
                    $this->finishing2Model->where('overview_id', $dcpId)->delete();
                    $this->finishing3Model->where('overview_id', $dcpId)->delete();
                    $this->heatTreatmentModel->where('overview_id', $dcpId)->delete();
                    $this->dieSpotModel1->where('overview_id', $dcpId)->delete();
                    $this->dieSpotModel2->where('overview_id', $dcpId)->delete();
                    $this->dieSpotModel3->where('overview_id', $dcpId)->delete();
                    $this->toolCostModel->where('overview_id', $dcpId)->delete();
                    $this->aksesorisModel->where('overview_id', $dcpId)->delete();
    
                    $this->overviewModel->delete($dcpId);
                }
    
                $this->ppsModel->delete($ppsId);
            }
        }
    
        $pps = $this->ppsModel->findAll();
    
        $groupedPps = [];
        foreach ($pps as $item) {
            $partNo = $item['part_no'] ?? 'UNKNOWN';
            $groupedPps[$partNo][] = $item;
        }
    
        $data = [
            'pps' => $pps,
            'groupedPps' => $groupedPps,
        ];
    
        return view('pps/index', $data);
    }
    
    public function delete($id)
    {
        $model = new PpsModel();
        $data = $model->find($id);
        if ($data) {
            print_r($data );
            $model->update($id, ['status' => 0]);
    
            return redirect()->to('/pps')->with('message', 'Data berhasil dihapus.');
            
        } else {
            return redirect()->to('/pps')->with('error', 'Data tidak ditemukan.');
        }
    }
    
    public function rollback($id)
    {
        $model = new PpsModel();
        $data = $model->find($id); 
    
        if ($data) {
            $model->update($id, ['status' => 1]);
            return redirect()->to('/pps')->with('message', 'Data berhasil dikembalikan.');
        } else {
            return redirect()->to('/pps')->with('error', 'Data tidak ditemukan.');
        }
    }
    
    public function detail($id)
    {
        $ppsModel = new PpsModel();
        $ppsDiesModel = new PpsDiesModel();

        $pps = $ppsModel->find($id);
        if (!$pps) {
            return redirect()->to('/pps')->with('error', 'Data tidak ditemukan');
        }

        $dies = $ppsDiesModel->getDiesByPps($id);

        $data = [
            'pps'  => $pps,
            'dies' => $dies
        ];

        return view('pps/detail', $data);
    }
    public function listProcessDies($id)
    {
        $ppsModel      = new PpsModel();
        $ppsDiesModel  = new PpsDiesModel();
        $overviewModel = new DcpOverviewModel();
    
        $dies = $ppsDiesModel->getDiesByPps($id);
        $pps = $ppsModel->where('id', $id)->first();
        
        if (!empty($dies)) {
            $diesIds = array_column($dies, 'id');
            $dcp = $overviewModel->whereIn('id_pps_dies', $diesIds)->findAll();
        } else {
            $dcp = [];
        }
    
        $existingDcpSameClass = [];
        $existingDcpDifferentClass = [];
        
        if ($pps && !empty($pps['part_no'])) {
            // Get PPS with same part_no but different id
            $samePps = $ppsModel->where('part_no', $pps['part_no'])
                               ->where('id !=', $id)
                               ->where('status', 1)
                               ->findAll();
            
            if (!empty($samePps)) {
                $samePpsIds = array_column($samePps, 'id');
                
                // Get all dies from PPS with same part_no
                $sameDies = $ppsDiesModel->whereIn('pps_id', $samePpsIds)->findAll();
                
                if (!empty($sameDies)) {
                    // Create array of current dies processes for comparison
                    $currentProcesses = array_column($dies, 'process');
                    
                    // Filter dies that have matching process with current dies
                    $matchingProcessDies = [];
                    foreach ($sameDies as $die) {
                        if (in_array($die['process'], $currentProcesses)) {
                            $matchingProcessDies[] = $die;
                        }
                    }
                    
                    if (!empty($matchingProcessDies)) {
                        $matchingDiesIds = array_column($matchingProcessDies, 'id');
                        
                        // Get DCP records only for dies with matching process
                        $existingDcpRecords = $overviewModel->whereIn('id_pps_dies', $matchingDiesIds)->findAll();
                        
                        foreach ($existingDcpRecords as $dcpRecord) {
                            // Find related die
                            $relatedDie = null;
                            foreach ($matchingProcessDies as $die) {
                                if ($die['id'] == $dcpRecord['id_pps_dies']) {
                                    $relatedDie = $die;
                                    break;
                                }
                            }
                            
                            if ($relatedDie) {
                                // Find related PPS
                                $relatedPps = null;
                                foreach ($samePps as $ppsItem) {
                                    if ($ppsItem['id'] == $relatedDie['pps_id']) {
                                        $relatedPps = $ppsItem;
                                        break;
                                    }
                                }
                                
                                // Merge DCP record with die and PPS details
                                $dcpWithDetails = array_merge($dcpRecord, [
                                    'die_class' => $relatedDie['class'],
                                    'die_process' => $relatedDie['process'],
                                    'die_proses' => $relatedDie['proses'],
                                    'pps_model' => $relatedPps ? $relatedPps['model'] : '',
                                    'pps_cust' => $relatedPps ? $relatedPps['cust'] : '',
                                    'source_pps_id' => $relatedDie['pps_id'],
                                    'source_die_id' => $relatedDie['id']
                                ]);
                                
                                // Check if class matches with current dies
                                $isClassMatched = false;
                                foreach ($dies as $currentDie) {
                                    // Double check: same process AND same class
                                    if ($currentDie['process'] == $relatedDie['process'] && 
                                        $currentDie['class'] == $relatedDie['class']) {
                                        $existingDcpSameClass[] = $dcpWithDetails;
                                        $isClassMatched = true;
                                        break;
                                    }
                                }
                                
                                // If process matches but class different
                                if (!$isClassMatched) {
                                    // Verify process still matches (additional safety check)
                                    $processMatches = false;
                                    foreach ($dies as $currentDie) {
                                        if ($currentDie['process'] == $relatedDie['process']) {
                                            $processMatches = true;
                                            break;
                                        }
                                    }
                                    
                                    if ($processMatches) {
                                        $existingDcpDifferentClass[] = $dcpWithDetails;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    
        $data = [
            'dies' => $dies,
            'dcp'  => $dcp,
            'pps'  => $pps,
            'id' => $id,
            'existingDcpSameClass' => $existingDcpSameClass,
            'existingDcpDifferentClass' => $existingDcpDifferentClass
        ];
    
        return view('pps/list_process_dcp', $data);
    }


    public function fetchMachine()
    {
        $db = \Config\Database::connect();
    
        $process       = $this->request->getPost('process');
        $proses        = $this->request->getPost('proses');
        $proses_join   = $this->request->getPost('proses_join');
        $length_mp     = $this->request->getPost('length_mp');
        $main_pressure = $this->request->getPost('main_pressure');
        $panjang = $this->request->getPost('panjang');
        $lebar = $this->request->getPost('lebar');

        if (!$process || !$proses || !$length_mp || !$main_pressure) {
            return $this->response->setStatusCode(400)->setJSON([
                'error'    => 'Data tidak lengkap, pastikan kolom Process, Proses, Length MP dan Main Pressure tidak kosong.',
                'csrfHash' => csrf_hash()
            ]);
        }
    
        $dieCount = count($process);
        if (count($main_pressure) !== $dieCount) {
            return $this->response->setStatusCode(400)->setJSON([
                'error'    => 'Jumlah nilai Main Pressure tidak sesuai dengan baris input lainnya.',
                'csrfHash' => csrf_hash()
            ]);
        }
    
        for ($i = 0; $i < $dieCount; $i++) {
            if (empty($process[$i]) || empty($proses[$i]) || empty($length_mp[$i]) || empty($main_pressure[$i])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error'    => 'Data tidak boleh kosong pada baris ke-' . ($i + 1),
                    'csrfHash' => csrf_hash()
                ]);
            }
        }
    
        $thresholds = array_map('floatval', $main_pressure);
    
        $selectColumns    = [];
        $joins            = "";
        $whereConditions  = [];
        $total_diff_parts = [];
        $tes = null;
    
        if ($dieCount > 4) {
            $selectColumns[] = "t1.machine AS machine1";
            $selectColumns[] = "t1.capacity AS capacity1";
            $selectColumns[] = "t1.cushion AS cushion1";
            $selectColumns[] = "t1.dh_dies AS dh_dies1";
            $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                 " AND (t1.machine LIKE '%1%') AND (t1.machine LIKE '%G%' OR t1.machine LIKE '%F%')";
            $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
    
            for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                $alias = "t" . $i;
                $selectColumns[] = "$alias.machine AS machine$i";
                $selectColumns[] = "$alias.capacity AS capacity$i";
                $selectColumns[] = "$alias.cushion AS cushion$i";
                $selectColumns[] = "$alias.dh_dies AS dh_dies$i";
                $prevAlias = "t" . ($i - 1);
                $joins .= " JOIN mc_spec $alias ON LEFT(t1.machine, 1) = LEFT($alias.machine, 1) AND $prevAlias.machine < $alias.machine ";
                $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                     " AND (t$i.machine LIKE '%$i%') AND (t$i.machine LIKE '%G%' OR t$i.machine LIKE '%F%')";
                $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
            }
              
            $select = implode(", ", $selectColumns);
            $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
            $select .= ", " . $total_diff;
            $where = implode(" AND ", $whereConditions);
            
            $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1"; 
            $query = $db->query($sql);
        } else {
            $selectColumns[] = "t1.machine AS machine1";
            $selectColumns[] = "t1.capacity AS capacity1";
            $selectColumns[] = "t1.cushion AS cushion1";
            $selectColumns[] = "t1.dh_dies AS dh_dies1";
            $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                 " AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%SP%')";
            $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
            
            for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                $alias = "t" . $i;
                $prevAlias = "t" . ($i - 1);
            
                $selectColumns[] = "$alias.machine AS machine$i";
                $selectColumns[] = "$alias.capacity AS capacity$i";
                $selectColumns[] = "$alias.cushion AS cushion$i";
                $selectColumns[] = "$alias.dh_dies AS dh_dies$i";
            
                // Penyesuaian join jika machine sebelumnya adalah SP
                $joins .= " JOIN mc_spec $alias ON LEFT(t1.machine, 1) = LEFT($alias.machine, 1) AND (
                                $prevAlias.machine LIKE '%SP%' OR $prevAlias.machine < $alias.machine
                            )";
            
                $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                     " AND ($alias.machine LIKE '%$i%' OR $alias.machine LIKE '%SP%')";
            
                $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
            }
            
            $select = implode(", ", $selectColumns);
            $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
            $select .= ", " . $total_diff;
            $where = implode(" AND ", $whereConditions);
            
            $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1";
            $query = $db->query($sql);
            
        }
        if ($query && $query->getNumRows() == 0) {

            $whereConditions = [];
            $total_diff_parts = [];
        
            if ($dieCount > 4) {
                $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                     " AND (t1.machine LIKE '%1%') AND (t1.machine LIKE '%G%' OR t1.machine LIKE '%F%')";
                $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
        
                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                    $alias = "t" . $i;
                    $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                         " AND (t$i.machine LIKE '%$i%') AND (t$i.machine LIKE '%G%' OR t$i.machine LIKE '%F%')";
                    $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
                }
            } else {
                $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                     " AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%SP%')";
                $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
        
                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                    $alias = "t" . $i;
                    $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                         " AND ($alias.machine LIKE '%$i%' OR $alias.machine LIKE '%SP%')";
                    $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
                }
            }
        
            $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
            $select = implode(", ", $selectColumns) . ", " . $total_diff;
            $where = implode(" AND ", $whereConditions);
        
            $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1";
            $query = $db->query($sql);
        }
        
        if ($query && $query->getNumRows() > 0) {
            $result = $query->getRowArray();
            $machineData2 ="TES";
            if (empty($result['machine1'])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error'    => 'Machine tidak boleh kosong.',
                    'csrfHash' => csrf_hash()
                ]);
            }
           
            for ($i = 5; $i <= $dieCount; $i++) {
                $acuanMachine = isset($result['machine3']) ? $result['machine3'] : '';
                if (strpos($acuanMachine, 'F') !== false) {
                    $machineTarget = 'D' . ($i - 4);
                    $sqlNew = "SELECT machine, capacity, cushion, dh_dies FROM mc_spec WHERE machine LIKE ? LIMIT 1";
                    $queryNew = $db->query($sqlNew, [$machineTarget . '%']);
                    if ($queryNew->getNumRows() > 0) {
                        $machinelastData = $queryNew->getRow();
                        $result['machine' . $i] = $machinelastData->machine;
                        $result['capacity' . $i] = $machinelastData->capacity;
                        $result['cushion' . $i]  = $machinelastData->cushion;
                        $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                    }
                } elseif (strpos($acuanMachine, 'G') !== false) {
                    $machineTarget = 'H' . ($i - 4);
                    $sqlNew = "SELECT machine, capacity, cushion, dh_dies FROM mc_spec WHERE machine LIKE ? LIMIT 1";
                    $queryNew = $db->query($sqlNew, [$machineTarget . '%']);
                    if ($queryNew->getNumRows() > 0) {
                        $machinelastData = $queryNew->getRow();
                        $result['machine' . $i] = $machinelastData->machine;
                        $result['capacity' . $i] = $machinelastData->capacity;
                        $result['cushion' . $i]  = $machinelastData->cushion;
                        $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                    }
                } else {
                    if ($i == 5) {
                        $alias = "t5";
                        $prevAlias = "t4";
                        $sqlDefault = "SELECT $alias.machine AS machine, $alias.capacity AS capacity, $alias.cushion AS cushion, $alias.dh_dies AS dh_dies 
                                       FROM mc_spec $alias 
                                       WHERE (0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                       LIMIT 1";
                        $queryDefault = $db->query($sqlDefault, [$thresholds[$i - 1]]);
                        if ($queryDefault->getNumRows() > 0) {
                            $machinelastData = $queryDefault->getRow();
                            $result['machine' . $i] = $machinelastData->machine;
                            $result['capacity' . $i] = $machinelastData->capacity;
                            $result['cushion' . $i]  = $machinelastData->cushion;
                            $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                        }
                        $tes = $result['machine' . $i];
                    } else {
                        $alias = "t" . $i;
                        $prevAlias = "t" . ($i - 1);
                        $sqlDefault = "SELECT $alias.machine AS machine, $alias.capacity AS capacity, $alias.cushion AS cushion, $alias.dh_dies AS dh_dies 
                                       FROM mc_spec $alias 
                                       JOIN mc_spec $prevAlias ON LEFT($prevAlias.machine, 1) = LEFT($alias.machine, 1) AND $prevAlias.machine < $alias.machine 
                                       WHERE (0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                       LIMIT 1";
                        $queryDefault = $db->query($sqlDefault, [$thresholds[$i - 1]]);
                        $tes = $queryDefault;
                        if ($queryDefault->getNumRows() > 0) {
                            $machinelastData = $queryDefault->getRow();
                            $result['machine' . $i] = $machinelastData->machine;
                            $result['capacity' . $i] = $machinelastData->capacity;
                            $result['cushion' . $i]  = $machinelastData->cushion;
                            $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                        }
                    }
                }
            }

            if (isset($proses[0]) && strpos($proses[0], 'BL') !== false) {
                if (isset($result['machine' . $dieCount]) && isset($result['capacity' . $dieCount])) {
                    $machinelast = $result['machine' . $dieCount];
                    $capacitylast = floatval($result['capacity' . $dieCount]);
                    
                    if (($capacitylast * 0.85) >= floatval($main_pressure[0])) {
                        $sqlMachine = "SELECT 
                                            t1.machine AS machine, 
                                            t1.capacity AS capacity, 
                                            t1.cushion AS cushion,
                                            t1.dh_dies AS dh_dies,
                                            ABS((0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) - ?) AS diff
                                    FROM mc_spec t1 
                                    WHERE (0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                        AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%MP%' OR t1.machine LIKE '%4%' OR t1.machine LIKE '%SP%')
                                    ORDER BY diff ASC
                                    LIMIT 1";
                        $queryMachine = $db->query($sqlMachine, [floatval($main_pressure[0]), $thresholds[0]]);
                        
                        if ($queryMachine->getNumRows() > 0) {
                            $machinelastData = $queryMachine->getRow();
                            $checknewt1 = $machinelastData->machine;
                            $checkoldt1 = $result['machine1'];
                        
                            if ($checknewt1 != $checkoldt1) {

                                $tempMachine  = [];
                                $tempCapacity = [];
                                $tempCushion  = [];
                                $tempDhDies   = [];
                                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                                    $tempMachine[$i ]  = $result['machine' . $i- 1];
                                    $tempCapacity[$i] = $result['capacity' . $i- 1];
                                    $tempCushion[$i]  = $result['cushion' . $i- 1];
                                    $tempDhDies[$i]   = $result['dh_dies' . $i- 1];
                                }
                                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                                    $result['machine' . $i] = $tempMachine[$i];
                                    $result['capacity' . $i] = $tempCapacity[$i];
                                    $result['cushion' . $i]  = $tempCushion[$i];
                                    $result['dh_dies' . $i]  = $tempDhDies[$i];
                                }
                            }
                            
                            $result['machine1'] = $machinelastData->machine;
                            $result['capacity1'] = $machinelastData->capacity;
                            $result['cushion1']  = $machinelastData->cushion;
                            $result['dh_dies1']  = $machinelastData->dh_dies;
                        }
                    }
                }
            }
            
            $machineData = [];
            $categoryData = [];
            $bigDieMachines = ['A', 'D', 'E', 'F', 'G'];
            $mediumDieMachines = ['B', 'H', 'C'];
            $smallDieMachines = ['S', 'M'];
            for ($i = 1; $i <= $dieCount; $i++) {
                $machineName = isset($result['machine' . $i]) ? $result['machine' . $i] : null;
                if (!empty($machineName)) {
                $queryMachine = $db->query("
                    SELECT 
                        machine,
                        bolster_length,
                        bolster_width,
                        slide_area_length,
                        slide_area_width,
                        die_height,
                        dh_dies,
                         slide_stroke,
                        cushion_pad_length,
                        cushion_pad_width,
                        cushion_stroke
                    FROM mc_spec 
                    WHERE machine = ?", [$machineName]);
                // $machineData[] = $queryMachine->getRowArray();

                $machineRow = $queryMachine->getRowArray();
                $machineData[] = $machineRow;

                if ($machineRow) {
                    $result['dh_dies' . $i] = $machineRow['dh_dies'];
                }
                } else {
                    $machineData[] = null;
                }
                $machinePrefix = strtoupper(substr($machineName, 0, 1));
                if (in_array($machinePrefix, $bigDieMachines)) {
                    $categoryData[] = "BIG DIE";
                } elseif (in_array($machinePrefix, $mediumDieMachines)) {
                    $categoryData[] = "MEDIUM DIE";
                } elseif (in_array($machinePrefix, $smallDieMachines)) {
                    $categoryData[] = "SMALL DIE";
                }
            }
            
                $dieLengthStandard = [];
                $dieWidthStandard  = [];
                $dieHeightStandard = [];
                $prosesValue = NULL;
                $die_proses_standard_die = [];
                $requiredLenght = [];
                $requiredWidth = [];
                $status = 'normal';
                for ($i = 0; $i < $dieCount; $i++) {
                    $jenis_proses = empty($proses_join[$i]) ? "SINGLE" : "GANG";
                    if ($categoryData[$i] == "BIG DIE") {
                        $jenis_proses = "SINGLE";
                        if ($jenis_proses == "SINGLE") {
                            if (
                                strpos($proses[$i], "DRAW") !== false ||
                                strpos($proses[$i], "FORM") !== false ||
                                strpos($proses[$i], "BEND") !== false ||
                                strpos($proses[$i], "REST") !== false
                            ) {
                                $prosesValue = "DRAW";
                            } elseif (strpos($proses[$i], "CAM-FLANGE") !== false) {
                                $prosesValue = "CAM FLANGE";
                            } elseif (strpos($proses[$i], "FLANGE") !== false) {
                                $prosesValue = "FLANGE";
                            } else {
                                $prosesValue = "TRIM";
                            }
                        }
                    } elseif ($categoryData[$i] == "MEDIUM DIE") {
                        if ($jenis_proses == "SINGLE") {
                            if (
                                strpos($proses[$i], "DRAW") !== false ||
                                strpos($proses[$i], "FORM") !== false ||
                                strpos($proses[$i], "BEND") !== false ||
                                strpos($proses[$i], "REST") !== false
                            ) {
                                $prosesValue = "DRAW";
                            } elseif (strpos($proses[$i], "FLANGE") !== false) {
                                $prosesValue = "FLANGE";
                            }elseif (strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false) {
                                $prosesValue = "CAM PIE";
                            } else {
                                $prosesValue = "TRIM";
                            }
                        } else {
                            if (
                                strpos($proses[$i], "DRAW") !== false ||
                                strpos($proses[$i], "FLANGE") !== false ||
                                strpos($proses[$i], "FORM") !== false ||
                                strpos($proses[$i], "BEND") !== false ||
                                strpos($proses[$i], "REST") !== false
                            ) {
                                $prosesValue = "DRAW";
                            } elseif (
                                strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false
                            ) {
                                if (strpos($proses_join[$i], "FLANGE") !== false) {
                                    $prosesValue = "FLANGE-CAM PIE";
                                }
                            } elseif (strpos($proses[$i], "FLANGE") !== false) {
                                if (strpos($proses_join[$i], "CAM") !== false && strpos($proses_join[$i], "PIE") !== false) {
                                    $prosesValue = "FLANGE-CAM PIE";
                                }
                            } else {
                                $prosesValue = "TRIM";
                            }
                        }
                    } elseif ($categoryData[$i] == "SMALL DIE") {
                        if ($jenis_proses == "SINGLE") {
                            if (strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false) {
                                $prosesValue = "CAM PIE";
                            } 
                            elseif (
                                strpos($proses[$i], "DRAW") !== false ||
                                strpos($proses[$i], "FLANGE") !== false ||
                                strpos($proses[$i], "FORM") !== false ||
                                strpos($proses[$i], "BEND") !== false ||
                                strpos($proses[$i], "PIE") !== false ||
                                strpos($proses[$i], "REST") !== false
                            ) {
                                $prosesValue = "FORMING";
                            } else {
                                $prosesValue = "BLANK";
                            }
                        } elseif ($jenis_proses == "GANG") {
                            if (
                                (isset($proses[$i]) && strpos($proses[$i], "BEND") !== false) || 
                                (isset($proses_join[$i]) && strpos($proses_join[$i], "BEND") !== false)
                            ) {
                                $prosesValue = "BEND 1, BEND 2";
                            } elseif (
                                ((isset($proses[$i]) && strpos($proses[$i], "FORM") !== false) || 
                                (isset($proses_join[$i]) && strpos($proses_join[$i], "FORM") !== false)) &&
                                ((isset($proses[$i]) && strpos($proses[$i], "PIE") !== false) || 
                                (isset($proses_join[$i]) && strpos($proses_join[$i], "PIE") !== false))
                            ) {
                                $prosesValue = "FORMING, PIE";
                            } elseif (
                                ((isset($proses[$i]) && strpos($proses[$i], "BLANK") !== false) || 
                                (isset($proses_join[$i]) && strpos($proses_join[$i], "BLANK") !== false)) &&
                                ((isset($proses[$i]) && strpos($proses[$i], "PIE") !== false) || 
                                (isset($proses_join[$i]) && strpos($proses_join[$i], "PIE") !== false))
                            ) {
                                $prosesValue = "BLANK-PIE";
                            } elseif (
                                (isset($proses[$i]) && preg_match("/TRIM|PIE|BLANK|SEP/", $proses[$i])) || 
                                (isset($proses_join[$i]) && preg_match("/TRIM|PIE|BLANK|SEP/", $proses_join[$i]))
                            ) {
                                $prosesValue = "BLANK-PIE";
                            } else {
                                $prosesValue = "FORM-FLANGE";
                            }
                            
                        }
                    }
                    $category = isset($categoryData[$i]) ? $categoryData[$i] : '';
                    $die_proses_standard_die[$i] = $category . "|" . $jenis_proses . "|" . $prosesValue;
                    if (!empty($prosesValue) && !empty($jenis_proses) && !empty($category)) {
                        $queryStandard = $db->query("
                            SELECT die_length, die_width, die_height
                            FROM standard_die_design 
                            WHERE proses = ? AND jenis_proses = ? AND category = ?",  
                            [$prosesValue, $jenis_proses, $category]
                        );
                        $row = $queryStandard->getRow();
                        $dieLengthStandard[$i] = isset($row->die_length) ? $row->die_length : '';
                        $dieWidthStandard[$i]  = isset($row->die_width) ? $row->die_width : '';
                        $dieHeightStandard[$i] = isset($row->die_height) ? $row->die_height : '';
                    } else {
                        $dieLengthStandard[$i] = '';
                        $dieWidthStandard[$i]  = '';
                        $dieHeightStandard[$i] = '';
                    }
            
                    $inputPanjang = $panjang[$i];
                    $inputLebar = $lebar[$i];
                    $dieLength = $dieLengthStandard[$i];
                    $dieWidth = $dieWidthStandard[$i];
                    $machineRow = $machineData[$i];
        
                    if (!$machineRow) continue;
        
                    $requiredLenght[$i] = $dieLengthStandard[$i] + $inputPanjang;
                    $requiredWidth[$i] = $dieWidthStandard[$i] + $inputLebar;
                    if (strpos($machineName, 'SP') !== false) {
                        $machinePrefix = $machineName; 
                    } else {
                        $machinePrefix = strtoupper(substr($machineName, 0, 1)); 
                    }
                
                    if (
                        ($machineRow['bolster_length'] < $requiredLenght[$i] ) || 
                        ($machineRow['slide_area_length'] < $requiredLenght[$i] ) ||
                        ($machineRow['bolster_width'] < $requiredWidth[$i]) || 
                        ($machineRow['slide_area_width'] < $requiredWidth[$i])
                    ) {

                        $status = 'over';
                    }
                        // if (($machineRow['bolster_width'] < $requiredWidth) || 
                        //     ($machineRow['slide_area_width'] < $requiredWidth)) {
                        //         return $this->fetchMachineSuitable(
                        //             $process,
                        //             $proses,
                        //             $proses_join,
                        //             $length_mp,
                        //             $main_pressure,
                        //             $panjang,
                        //             $lebar,
                        //             $machinePrefix
                        //         );
                        // }
                    
                }
            
                if (
                $status == 'over'
                ) {

                        return $this->fetchMachineSuitable(
                            $process,
                            $proses,
                            $proses_join,
                            $length_mp,
                            $main_pressure,
                            $requiredLenght,
                            $requiredWidth,
                            $machinePrefix
                        );
            
                }
            return $this->response->setStatusCode(200)->setJSON([
                'success'                 => true,
                'data'                    => $result,
                'machine_data'            => $machineData,
                'die_length_standard'     => $dieLengthStandard,
                'die_width_standard'      => $dieWidthStandard,
                'die_height_standard'     => $dieHeightStandard,
                'die_proses_standard_die' => $die_proses_standard_die,
                'jenis_proses'            => $jenis_proses,
                'prosesValue'             => $prosesValue,
                'categoryData'            => $category,
                'tes'                     => $status,
                'requiredWidth'            => $requiredWidth,
                'requiredLenght'            => $requiredLenght,
                'csrfHash'                => csrf_hash()
            ]);
        } else {
            $result = [];
            $machineData = [];
            $dieLengthStandard = [];
            $dieWidthStandard  = [];
            $dieHeightStandard = [];
            $die_proses_standard_die = [];
            $jenis_proses = null;
            $prosesValue = null;
            $category = [];
            
            // Generate data kosong untuk semua baris
            for ($i = 0; $i < $dieCount; $i++) {
                $result['machine' . ($i + 1)] = null;
                $result['capacity' . ($i + 1)] = null;
                $result['cushion' . ($i + 1)] = null;
                $result['dh_dies' . ($i + 1)] = null;
                $machineData[] = null;
                $dieLengthStandard[$i] = null;
                $dieWidthStandard[$i] = null;
                $dieHeightStandard[$i] = null;
                $die_proses_standard_die[$i] = null;
                $category[] = null;
            }
            
            return $this->response->setStatusCode(200)->setJSON([
                'success'                 => true, // Pastikan success tetap true
                'data'                    => $result,
                'machine_data'            => $machineData,
                'die_length_standard'     => $dieLengthStandard,
                'die_width_standard'      => $dieWidthStandard,
                'die_height_standard'     => $dieHeightStandard,
                'die_proses_standard_die' => $die_proses_standard_die,
                'jenis_proses'            => $jenis_proses,
                'prosesValue'             => $prosesValue,
                'categoryData'            => $category,
                'tes'                     => $proses[0] ?? '',
                'csrfHash'                => csrf_hash()
            ]);

        
        }
    }

    public function fetchMachineSuitable($process,
        $proses,
        $proses_join,
        $length_mp,
        $main_pressure,
        $requiredLenght,
        $requiredWidth,
        $machinePrefix  )
    {
        $db = \Config\Database::connect();
       $panjang2 = $requiredLenght;
       $lebar2 = $requiredWidth;
       $panjang = $requiredLenght;
       $lebar = $requiredWidth;
        $dieCount = count($process);
        if (count($main_pressure) !== $dieCount || count($panjang) !== $dieCount || count($lebar) !== $dieCount) {
            return $this->response->setStatusCode(400)->setJSON([
                'error'    => 'Jumlah nilai input tidak sesuai antara kolom yang berbeda.',
                'csrfHash' => csrf_hash()
            ]);
        }

        for ($i = 0; $i < $dieCount; $i++) {
            if (empty($process[$i]) || empty($proses[$i]) || empty($length_mp[$i]) || 
                empty($main_pressure[$i]) || empty($panjang[$i]) || empty($lebar[$i])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error'    => 'Data tidak boleh kosong pada baris ke-' . ($i + 1),
                    'csrfHash' => csrf_hash()
                ]);
            }
        }

        $thresholds = array_map('floatval', $main_pressure);
        $panjang_values = array_map('floatval', $panjang);
        $lebar_values = array_map('floatval', $lebar);

        $selectColumns = [];
        $joins = "";
        $whereConditions = [];
        $total_diff_parts = [];
        $tes = null;

        $addDimensionalConditions = function($alias, $index) use ($panjang_values, $lebar_values) {
            $conditions = [];
            $conditions[] = "$alias.bolster_length >= " . $panjang_values[$index];
            $conditions[] = "$alias.slide_area_length >= " . $panjang_values[$index];
            $conditions[] = "$alias.bolster_width >= " . $lebar_values[$index];
            $conditions[] = "$alias.slide_area_width >= " . $lebar_values[$index];
            return implode(" AND ", $conditions);
        };

        $addDimensionalConditions2 = function($alias, $index) use ($panjang_values, $lebar_values) {
            $conditions = [];
            $conditions[] = "$alias.bolster_length >= " . $panjang_values[$index];
            $conditions[] = "$alias.slide_area_length >= " . $panjang_values[$index];
            $conditions[] = "$alias.bolster_width >= " . $lebar_values[$index];
            $conditions[] = "$alias.slide_area_width >= " . $lebar_values[$index];
            return implode(" AND ", $conditions);
        };
        
        $tesResult = $addDimensionalConditions2('t1', 0);

        
        if ($dieCount > 4) {
            $selectColumns[] = "t1.machine AS machine1";
            $selectColumns[] = "t1.capacity AS capacity1";
            $selectColumns[] = "t1.cushion AS cushion1";
            $selectColumns[] = "t1.dh_dies AS dh_dies1";
            $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                 " AND (t1.machine LIKE '%1%') AND (t1.machine LIKE '%G%' OR t1.machine LIKE '%F%')";
                                 $whereConditions[] = $addDimensionalConditions('t1', 0);
            // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix
            if (!empty($machinePrefix)) {
                // Jika machinePrefix adalah string tunggal, buat kondisi langsung
                if (is_string($machinePrefix)) {
                    $whereConditions[] = "t1.machine NOT LIKE '" . trim($machinePrefix) . "%'";
                } else {
                    // Jika array, loop seperti biasa
                    $machineConditions = [];
                    foreach ($machinePrefix as $prefix) {
                        $prefix = trim($prefix);
                        if (!empty($prefix)) {
                            $machineConditions[] = "t1.machine NOT LIKE '" . $prefix . "%'";
                        }
                    }
                    if (!empty($machineConditions)) {
                        $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
                    }
                }
            }
            
            $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
    
            for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                $alias = "t" . $i;
                $selectColumns[] = "$alias.machine AS machine$i";
                $selectColumns[] = "$alias.capacity AS capacity$i";
                $selectColumns[] = "$alias.cushion AS cushion$i";
                $selectColumns[] = "$alias.dh_dies AS dh_dies$i";
                $prevAlias = "t" . ($i - 1);
                $joins .= " JOIN mc_spec $alias ON LEFT(t1.machine, 1) = LEFT($alias.machine, 1) AND $prevAlias.machine < $alias.machine ";
                $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                     " AND (t$i.machine LIKE '%$i%') AND (t$i.machine LIKE '%G%' OR t$i.machine LIKE '%F%')";
                                     $whereConditions[] = $addDimensionalConditions($alias, $i - 1);
                // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix untuk setiap alias
                if (!empty($machinePrefix)) {
                    // Jika machinePrefix adalah string tunggal, buat kondisi langsung
                    if (is_string($machinePrefix)) {
                        $whereConditions[] = "$alias.machine NOT LIKE '" . trim($machinePrefix) . "%'";
                    } else {
                        // Jika array, loop seperti biasa
                        $machineConditions = [];
                        foreach ($machinePrefix as $prefix) {
                            $prefix = trim($prefix);
                            if (!empty($prefix)) {
                                $machineConditions[] = "$alias.machine NOT LIKE '" . $prefix . "%'";
                            }
                        }
                        if (!empty($machineConditions)) {
                            $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
                        }
                    }
                }
                
                $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
            }
              
            $select = implode(", ", $selectColumns);
            $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
            $select .= ", " . $total_diff;
            $where = implode(" AND ", $whereConditions);
            
            $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1"; 
            $query = $db->query($sql);
        } else {
            $selectColumns[] = "t1.machine AS machine1";
            $selectColumns[] = "t1.capacity AS capacity1";
            $selectColumns[] = "t1.cushion AS cushion1";
            $selectColumns[] = "t1.dh_dies AS dh_dies1";
            $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
                                 " AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%SP%')";
                                 $whereConditions[] = $addDimensionalConditions('t1', 0);
            if (!empty($machinePrefix)) {
                // Jika machinePrefix adalah string tunggal, buat kondisi langsung
                if (is_string($machinePrefix)) {
                    $whereConditions[] = "t1.machine NOT LIKE '" . trim($machinePrefix) . "%'";
                } else {
             
                    $machineConditions = [];
                    foreach ($machinePrefix as $prefix) {
                        $prefix = trim($prefix);
                        if (!empty($prefix)) {
                            $machineConditions[] = "t1.machine NOT LIKE '" . $prefix . "%'";
                        }
                    }
                    if (!empty($machineConditions)) {
                        $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
                    }
                }
            }
            
            $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
            
            for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                $alias = "t" . $i;
                $prevAlias = "t" . ($i - 1);
            
                $selectColumns[] = "$alias.machine AS machine$i";
                $selectColumns[] = "$alias.capacity AS capacity$i";
                $selectColumns[] = "$alias.cushion AS cushion$i";
                $selectColumns[] = "$alias.dh_dies AS dh_dies$i";
            
                // Penyesuaian join jika machine sebelumnya adalah SP
                $joins .= " JOIN mc_spec $alias ON LEFT(t1.machine, 1) = LEFT($alias.machine, 1) AND (
                                $prevAlias.machine LIKE '%SP%' OR $prevAlias.machine < $alias.machine
                            )";
            
                $whereConditions[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
                                     " AND ($alias.machine LIKE '%$i%' OR $alias.machine LIKE '%SP%')";
                                     $whereConditions[] = $addDimensionalConditions($alias, $i - 1);
                // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix untuk setiap alias
                if (!empty($machinePrefix)) {
                    // Jika machinePrefix adalah string tunggal, buat kondisi langsung
                    if (is_string($machinePrefix)) {
                        $whereConditions[] = "$alias.machine NOT LIKE '" . trim($machinePrefix) . "%'";
                    } else {
                        // Jika array, loop seperti biasa
                        $machineConditions = [];
                        foreach ($machinePrefix as $prefix) {
                            $prefix = trim($prefix);
                            if (!empty($prefix)) {
                                $machineConditions[] = "$alias.machine NOT LIKE '" . $prefix . "%'";
                            }
                        }
                        if (!empty($machineConditions)) {
                            $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
                        }
                    }
                }
            
                $total_diff_parts[] = "(0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
            }
            
            $select = implode(", ", $selectColumns);
            $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
            $select .= ", " . $total_diff;
            $where = implode(" AND ", $whereConditions);
            
            $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1";
            $query = $db->query($sql);
            
        }
        // if ($query && $query->getNumRows() == 0) {
        //     // Ubah threshold menjadi 0.95
        //     $whereConditions = [];
        //     $total_diff_parts = [];
        
        //     if ($dieCount > 4) {
        //         $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
        //                              " AND (t1.machine LIKE '%1%') AND (t1.machine LIKE '%G%' OR t1.machine LIKE '%F%')";
                
        //         // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix (threshold 0.95)
        //         if (!empty($machinePrefix)) {
        //             // Jika machinePrefix adalah string tunggal, buat kondisi langsung
        //             if (is_string($machinePrefix)) {
        //                 $whereConditions[] = "t1.machine NOT LIKE '" . trim($machinePrefix) . "%'";
        //             } else {
        //                 // Jika array, loop seperti biasa
        //                 $machineConditions = [];
        //                 foreach ($machinePrefix as $prefix) {
        //                     $prefix = trim($prefix);
        //                     if (!empty($prefix)) {
        //                         $machineConditions[] = "t1.machine NOT LIKE '" . $prefix . "%'";
        //                     }
        //                 }
        //                 if (!empty($machineConditions)) {
        //                     $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
        //                 }
        //             }
        //         }
                
        //         $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
        
        //         for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
        //             $alias = "t" . $i;
        //             $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
        //                                  " AND (t$i.machine LIKE '%$i%') AND (t$i.machine LIKE '%G%' OR t$i.machine LIKE '%F%')";
                    
        //             // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix untuk setiap alias (threshold 0.95)
        //             if (!empty($machinePrefix)) {
        //                 // Jika machinePrefix adalah string tunggal, buat kondisi langsung
        //                 if (is_string($machinePrefix)) {
        //                     $whereConditions[] = "$alias.machine NOT LIKE '" . trim($machinePrefix) . "%'";
        //                 } else {
        //                     // Jika array, loop seperti biasa
        //                     $machineConditions = [];
        //                     foreach ($machinePrefix as $prefix) {
        //                         $prefix = trim($prefix);
        //                         if (!empty($prefix)) {
        //                             $machineConditions[] = "$alias.machine NOT LIKE '" . $prefix . "%'";
        //                         }
        //                     }
        //                     if (!empty($machineConditions)) {
        //                         $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
        //                     }
        //                 }
        //             }
                    
        //             $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
        //         }
        //     } else {
        //         $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[0] .
        //                              " AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%SP%')";
        //                              $whereConditions[] = $addDimensionalConditions('t1', 0);
        //         // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix (threshold 0.95)
        //         if (!empty($machinePrefix)) {
        //             // Jika machinePrefix adalah string tunggal, buat kondisi langsung
        //             if (is_string($machinePrefix)) {
        //                 $whereConditions[] = "t1.machine NOT LIKE '" . trim($machinePrefix) . "%'";
        //             } else {
        //                 // Jika array, loop seperti biasa
        //                 $machineConditions = [];
        //                 foreach ($machinePrefix as $prefix) {
        //                     $prefix = trim($prefix);
        //                     if (!empty($prefix)) {
        //                         $machineConditions[] = "t1.machine NOT LIKE '" . $prefix . "%'";
        //                     }
        //                 }
        //                 if (!empty($machineConditions)) {
        //                     $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
        //                 }
        //             }
        //         }
                
        //         $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[0] . ")";
        
        //         for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
        //             $alias = "t" . $i;
        //             $whereConditions[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= " . $thresholds[$i - 1] .
        //                                  " AND ($alias.machine LIKE '%$i%' OR $alias.machine LIKE '%SP%')";
                    
        //             // Tambahkan kondisi untuk mencegah machine yang sama berdasarkan machinePrefix untuk setiap alias (threshold 0.95)
        //             if (!empty($machinePrefix)) {
        //                 // Jika machinePrefix adalah string tunggal, buat kondisi langsung
        //                 if (is_string($machinePrefix)) {
        //                     $whereConditions[] = "$alias.machine NOT LIKE '" . trim($machinePrefix) . "%'";
        //                 } else {
        //                     // Jika array, loop seperti biasa
        //                     $machineConditions = [];
        //                     foreach ($machinePrefix as $prefix) {
        //                         $prefix = trim($prefix);
        //                         if (!empty($prefix)) {
        //                             $machineConditions[] = "$alias.machine NOT LIKE '" . $prefix . "%'";
        //                         }
        //                     }
        //                     if (!empty($machineConditions)) {
        //                         $whereConditions[] = "(" . implode(" AND ", $machineConditions) . ")";
        //                     }
        //                 }
        //             }
                    
        //             $total_diff_parts[] = "(0.95 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2)) - " . $thresholds[$i - 1] . ")";
        //         }
        //     }
        
        //     // Buat ulang query
        //     $total_diff = "(" . implode(" + ", $total_diff_parts) . ") AS total_diff";
        //     $select = implode(", ", $selectColumns) . ", " . $total_diff;
        //     $where = implode(" AND ", $whereConditions);
        
        //     $sql = "SELECT $select FROM mc_spec t1 $joins WHERE $where ORDER BY total_diff ASC LIMIT 1";
        //     $query = $db->query($sql);
        // }
        
        
        if ($query && $query->getNumRows() > 0) {
            $result = $query->getRowArray();
            $machineData2 ="TES";
            if (empty($result['machine1'])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error'    => 'Machine tidak boleh kosong.',
                    'csrfHash' => csrf_hash()
                ]);
            }
           
            for ($i = 5; $i <= $dieCount; $i++) {
                $acuanMachine = isset($result['machine3']) ? $result['machine3'] : '';
                if (strpos($acuanMachine, 'F') !== false) {
                    $machineTarget = 'D' . ($i - 4);
                    $sqlNew = "SELECT machine, capacity, cushion, dh_dies FROM mc_spec WHERE machine LIKE ? LIMIT 1";
                    $queryNew = $db->query($sqlNew, [$machineTarget . '%']);
                    if ($queryNew->getNumRows() > 0) {
                        $machinelastData = $queryNew->getRow();
                        $result['machine' . $i] = $machinelastData->machine;
                        $result['capacity' . $i] = $machinelastData->capacity;
                        $result['cushion' . $i]  = $machinelastData->cushion;
                        $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                    }
                } elseif (strpos($acuanMachine, 'G') !== false) {
                    $machineTarget = 'H' . ($i - 4);
                    $sqlNew = "SELECT machine, capacity, cushion, dh_dies FROM mc_spec WHERE machine LIKE ? LIMIT 1";
                    $queryNew = $db->query($sqlNew, [$machineTarget . '%']);
                    if ($queryNew->getNumRows() > 0) {
                        $machinelastData = $queryNew->getRow();
                        $result['machine' . $i] = $machinelastData->machine;
                        $result['capacity' . $i] = $machinelastData->capacity;
                        $result['cushion' . $i]  = $machinelastData->cushion;
                        $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                    }
                } else {
                    if ($i == 5) {
                        $alias = "t5";
                        $prevAlias = "t4";
                        $sqlDefault = "SELECT $alias.machine AS machine, $alias.capacity AS capacity, $alias.cushion AS cushion, $alias.dh_dies AS dh_dies 
                                       FROM mc_spec $alias 
                                       WHERE (0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                       LIMIT 1";
                        $queryDefault = $db->query($sqlDefault, [$thresholds[$i - 1]]);
                        if ($queryDefault->getNumRows() > 0) {
                            $machinelastData = $queryDefault->getRow();
                            $result['machine' . $i] = $machinelastData->machine;
                            $result['capacity' . $i] = $machinelastData->capacity;
                            $result['cushion' . $i]  = $machinelastData->cushion;
                            $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                        }
                        $tes = $result['machine' . $i];
                    } else {
                        $alias = "t" . $i;
                        $prevAlias = "t" . ($i - 1);
                        $sqlDefault = "SELECT $alias.machine AS machine, $alias.capacity AS capacity, $alias.cushion AS cushion, $alias.dh_dies AS dh_dies 
                                       FROM mc_spec $alias 
                                       JOIN mc_spec $prevAlias ON LEFT($prevAlias.machine, 1) = LEFT($alias.machine, 1) AND $prevAlias.machine < $alias.machine 
                                       WHERE (0.85 * CAST(REPLACE(REPLACE($alias.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                       LIMIT 1";
                        $queryDefault = $db->query($sqlDefault, [$thresholds[$i - 1]]);
                        $tes = $queryDefault;
                        if ($queryDefault->getNumRows() > 0) {
                            $machinelastData = $queryDefault->getRow();
                            $result['machine' . $i] = $machinelastData->machine;
                            $result['capacity' . $i] = $machinelastData->capacity;
                            $result['cushion' . $i]  = $machinelastData->cushion;
                            $result['dh_dies' . $i]  = $machinelastData->dh_dies;
                        }
                    }
                }
            }
            if (isset($proses[0]) && strpos($proses[0], 'BL') !== false) {
                if (isset($result['machine' . $dieCount]) && isset($result['capacity' . $dieCount])) {
                    $machinelast = $result['machine' . $dieCount];
                    $capacitylast = floatval($result['capacity' . $dieCount]);
                    
                    if (($capacitylast * 0.85) >= floatval($main_pressure[0])) {
                        $sqlMachine = "SELECT 
                                            t1.machine AS machine, 
                                            t1.capacity AS capacity, 
                                            t1.cushion AS cushion,
                                            t1.dh_dies AS dh_dies,
                                            ABS((0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) - ?) AS diff
                                    FROM mc_spec t1 
                                    WHERE (0.85 * CAST(REPLACE(REPLACE(t1.capacity, ',', ''), ' T', '') AS DECIMAL(10,2))) >= ? 
                                        AND (t1.machine LIKE '%1%' OR t1.machine LIKE '%MP%' OR t1.machine LIKE '%4%' OR t1.machine LIKE '%SP%')
                                    ORDER BY diff ASC
                                    LIMIT 1";
                        $queryMachine = $db->query($sqlMachine, [floatval($main_pressure[0]), $thresholds[0]]);
                        
                        if ($queryMachine->getNumRows() > 0) {
                            $machinelastData = $queryMachine->getRow();
                            $checknewt1 = $machinelastData->machine;
                            $checkoldt1 = $result['machine1'];
                        
                            if ($checknewt1 != $checkoldt1) {

                                $tempMachine  = [];
                                $tempCapacity = [];
                                $tempCushion  = [];
                                $tempDhDies   = [];
                                
                                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                                    $tempMachine[$i ]  = $result['machine' . $i- 1];
                                    $tempCapacity[$i] = $result['capacity' . $i- 1];
                                    $tempCushion[$i]  = $result['cushion' . $i- 1];
                                    $tempDhDies[$i]   = $result['dh_dies' . $i- 1];
                                }
                                
                                for ($i = 2; $i <= $dieCount && $i <= 4; $i++) {
                                    $result['machine' . $i] = $tempMachine[$i];
                                    $result['capacity' . $i] = $tempCapacity[$i];
                                    $result['cushion' . $i]  = $tempCushion[$i];
                                    $result['dh_dies' . $i]  = $tempDhDies[$i];
                                }
                            }
                            
                        
                            $result['machine1'] = $machinelastData->machine;
                            $result['capacity1'] = $machinelastData->capacity;
                            $result['cushion1']  = $machinelastData->cushion;
                            $result['dh_dies1']  = $machinelastData->dh_dies;
                        }
                    }
                }
            }
            
            $machineData = [];
            $categoryData = [];
            $bigDieMachines = ['A', 'D', 'E', 'F', 'G'];
            $mediumDieMachines = ['B', 'H', 'C'];
    
            for ($i = 1; $i <= $dieCount; $i++) {
                $machineName = isset($result['machine' . $i]) ? $result['machine' . $i] : null;
                if (!empty($machineName)) {
                $queryMachine = $db->query("
                    SELECT 
                        machine,
                        bolster_length,
                        bolster_width,
                        slide_area_length,
                        slide_area_width,
                        die_height,
                         slide_stroke,
                        cushion_pad_length,
                        cushion_pad_width,
                        cushion_stroke,
                        dh_dies
                    FROM mc_spec 
                    WHERE machine = ?", [$machineName]);
                // $machineData[] = $queryMachine->getRowArray();

                $machineRow = $queryMachine->getRowArray();
                $machineData[] = $machineRow;

                if ($machineRow) {
                    $result['dh_dies' . $i] = $machineRow['dh_dies'];
                }
                } else {
                    $machineData[] = null;
                }
                $machinePrefix = strtoupper(substr($machineName, 0, 1));
                if (in_array($machinePrefix, $bigDieMachines)) {
                    $categoryData[] = "BIG DIE";
                } elseif (in_array($machinePrefix, $mediumDieMachines)) {
                    $categoryData[] = "MEDIUM DIE";
                } else {
                    $categoryData[] = "SMALL DIE";
                }
            }
            
            $dieLengthStandard = [];
            $dieWidthStandard  = [];
            $dieHeightStandard = [];
            $prosesValue = NULL;
            $die_proses_standard_die = [];
            for ($i = 0; $i < $dieCount; $i++) {
                $jenis_proses = empty($proses_join[$i]) ? "SINGLE" : "GANG";
                if ($categoryData[$i] == "BIG DIE") {
                    $jenis_proses = "SINGLE";
                    if ($jenis_proses == "SINGLE") {
                        if (
                            strpos($proses[$i], "DRAW") !== false ||
                            strpos($proses[$i], "FORM") !== false ||
                            strpos($proses[$i], "BEND") !== false ||
                            strpos($proses[$i], "REST") !== false
                        ) {
                            $prosesValue = "DRAW";
                        } elseif (strpos($proses[$i], "CAM-FLANGE") !== false) {
                            $prosesValue = "CAM FLANGE";
                        } elseif (strpos($proses[$i], "FLANGE") !== false) {
                            $prosesValue = "FLANGE";
                        } else {
                            $prosesValue = "TRIM";
                        }
                    }
                } elseif ($categoryData[$i] == "MEDIUM DIE") {
                    if ($jenis_proses == "SINGLE") {
                        if (
                            strpos($proses[$i], "DRAW") !== false ||
                            strpos($proses[$i], "FORM") !== false ||
                            strpos($proses[$i], "BEND") !== false ||
                            strpos($proses[$i], "REST") !== false
                        ) {
                            $prosesValue = "DRAW";
                        } elseif (strpos($proses[$i], "FLANGE") !== false) {
                            $prosesValue = "FLANGE";
                        }elseif (strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false) {
                            $prosesValue = "CAM PIE";
                        } else {
                            $prosesValue = "TRIM";
                        }
                    } else {
                        if (
                            strpos($proses[$i], "DRAW") !== false ||
                            strpos($proses[$i], "FLANGE") !== false ||
                            strpos($proses[$i], "FORM") !== false ||
                            strpos($proses[$i], "BEND") !== false ||
                            strpos($proses[$i], "REST") !== false
                        ) {
                            $prosesValue = "DRAW";
                        } elseif (
                            strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false
                        ) {
                            if (strpos($proses_join[$i], "FLANGE") !== false) {
                                $prosesValue = "FLANGE-CAM PIE";
                            }
                        } elseif (strpos($proses[$i], "FLANGE") !== false) {
                            if (strpos($proses_join[$i], "CAM") !== false && strpos($proses_join[$i], "PIE") !== false) {
                                $prosesValue = "FLANGE-CAM PIE";
                            }
                        } else {
                            $prosesValue = "TRIM";
                        }
                    }
                } elseif ($categoryData[$i] == "SMALL DIE") {
                    if ($jenis_proses == "SINGLE") {
                        if (strpos($proses[$i], "CAM") !== false && strpos($proses[$i], "PIE") !== false) {
                            $prosesValue = "CAM PIE";
                        } 
                        elseif (
                            strpos($proses[$i], "DRAW") !== false ||
                            strpos($proses[$i], "FLANGE") !== false ||
                            strpos($proses[$i], "FORM") !== false ||
                            strpos($proses[$i], "BEND") !== false ||
                            strpos($proses[$i], "PIE") !== false ||
                            strpos($proses[$i], "REST") !== false
                        ) {
                            $prosesValue = "FORMING";
                        } else {
                            $prosesValue = "BLANK";
                        }
                    } elseif ($jenis_proses == "GANG") {
                        if (
                            (isset($proses[$i]) && strpos($proses[$i], "BEND") !== false) || 
                            (isset($proses_join[$i]) && strpos($proses_join[$i], "BEND") !== false)
                        ) {
                            $prosesValue = "BEND 1, BEND 2";
                        } elseif (
                            ((isset($proses[$i]) && strpos($proses[$i], "FORM") !== false) || 
                            (isset($proses_join[$i]) && strpos($proses_join[$i], "FORM") !== false)) &&
                            ((isset($proses[$i]) && strpos($proses[$i], "PIE") !== false) || 
                            (isset($proses_join[$i]) && strpos($proses_join[$i], "PIE") !== false))
                        ) {
                            $prosesValue = "FORMING, PIE";
                        } elseif (
                            ((isset($proses[$i]) && strpos($proses[$i], "BLANK") !== false) || 
                            (isset($proses_join[$i]) && strpos($proses_join[$i], "BLANK") !== false)) &&
                            ((isset($proses[$i]) && strpos($proses[$i], "PIE") !== false) || 
                            (isset($proses_join[$i]) && strpos($proses_join[$i], "PIE") !== false))
                        ) {
                            $prosesValue = "BLANK-PIE";
                        } elseif (
                            (isset($proses[$i]) && preg_match("/TRIM|PIE|BLANK|SEP/", $proses[$i])) || 
                            (isset($proses_join[$i]) && preg_match("/TRIM|PIE|BLANK|SEP/", $proses_join[$i]))
                        ) {
                            $prosesValue = "BLANK-PIE";
                        } else {
                            $prosesValue = "FORM-FLANGE";
                        }
                        
                    }
                }
                $category = isset($categoryData[$i]) ? $categoryData[$i] : '';
                $die_proses_standard_die[$i] = $category . "|" . $jenis_proses . "|" . $prosesValue;
                if (!empty($prosesValue) && !empty($jenis_proses) && !empty($category)) {
                    $queryStandard = $db->query("
                        SELECT die_length, die_width, die_height
                        FROM standard_die_design 
                        WHERE proses = ? AND jenis_proses = ? AND category = ?",  
                        [$prosesValue, $jenis_proses, $category]
                    );
                    $row = $queryStandard->getRow();
                    $dieLengthStandard[$i] = isset($row->die_length) ? $row->die_length : '';
                    $dieWidthStandard[$i]  = isset($row->die_width) ? $row->die_width : '';
                    $dieHeightStandard[$i] = isset($row->die_height) ? $row->die_height : '';
                } else {
                    $dieLengthStandard[$i] = '';
                    $dieWidthStandard[$i]  = '';
                    $dieHeightStandard[$i] = '';
                }
           
         
                   
            }
     
            return $this->response->setStatusCode(200)->setJSON([
                'success'                 => true,
                'data'                    => $result,
                'machine_data'            => $machineData,
                'die_length_standard'     => $dieLengthStandard,
                'die_width_standard'      => $dieWidthStandard,
                'die_height_standard'     => $dieHeightStandard,
                'die_proses_standard_die' => $die_proses_standard_die,
                'jenis_proses'            => $jenis_proses,
                'prosesValue'             => $prosesValue,
                'categoryData'            => $category,
                'tes'                     => $tesResult,
                'panjang2'     => $panjang2,
                'lebar2'      => $lebar2,
                'csrfHash'                => csrf_hash()
            ]);
        } else {
            $result = [];
            $machineData = [];
            $dieLengthStandard = [];
            $dieWidthStandard  = [];
            $dieHeightStandard = [];
            $die_proses_standard_die = [];
            $jenis_proses = null;
            $prosesValue = null;
            $category = [];
            
            // Generate data kosong untuk semua baris
            for ($i = 0; $i < $dieCount; $i++) {
                $result['machine' . ($i + 1)] = "A1";
                $result['capacity' . ($i + 1)] = 1;
                $result['cushion' . ($i + 1)] = 1;
                $result['dh_dies' . ($i + 1)] = 1;
                $machineData[] = 1;
                $dieLengthStandard[$i] = 1;
                $dieWidthStandard[$i] = 1;
                $dieHeightStandard[$i] = 1;
                $die_proses_standard_die[$i] = 1;
                $category[] = 1;
            }
            
        
            return $this->response->setStatusCode(200)->setJSON([
                'success'                 => true, // Pastikan success tetap true
                'data'                    => $result,
                'machine_data'            => $dieCount,
                'die_length_standard'     => $length_mp,
                'die_width_standard'      => $main_pressure,
                'die_height_standard'     => $panjang2,
                'die_proses_standard_die' => $lebar2,
                'jenis_proses'            => $machinePrefix,
                'prosesValue'             => $prosesValue,
                'categoryData'            => $category,
                'tes'                     => $proses,
                'csrfHash'                => csrf_hash()
            ]);

        
        }
    }
    
    public function fetchStandard()
    {
        $db = \Config\Database::connect();
        $standard = $this->request->getPost('standard');
    
        if (empty($standard)) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'error'    => 'Parameter standard tidak boleh kosong.',
                            'csrfHash' => csrf_hash()
                        ]);
        }
        $category     = null;
        $jenis_proses = null;
        $prosesValue  = null;
        $parts = explode("|", $standard);
        if (count($parts) == 3) {
            $category     = trim($parts[0]);
            $jenis_proses = trim($parts[1]);
            $prosesValue  = trim($parts[2]);
        } else {
            $category = $jenis_proses = $prosesValue = '';
        }
        
        if (!empty($prosesValue)) {
            $queryStandard = $db->query("
                SELECT die_length, die_width, die_height
                FROM standard_die_design 
                WHERE proses = ? AND jenis_proses = ? AND category = ?",  
                [$prosesValue, $jenis_proses, $category]
            );
            
            if ($queryStandard->getNumRows() > 0) {
                $row = $queryStandard->getRow();
                return $this->response
                            ->setStatusCode(200)
                            ->setJSON([
                                'success'  => true,
                                'data'     => $row,
                                'csrfHash' => csrf_hash()
                            ]);
            } else {
                return $this->response
                            ->setStatusCode(404)
                            ->setJSON([
                                'error'    => 'Data standar die design tidak ditemukan untuk standard: ' . $standard,
                                'csrfHash' => csrf_hash()
                            ]);
            }
        } else {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON([
                            'error'    => 'Data tidak ditemukan untuk standard: ' . $category,
                            'csrfHash' => csrf_hash()
                        ]);
        }
    }

    public function fetchMachineByMachine()
    {
        $db = \Config\Database::connect();
        $machine = $this->request->getPost('machine');

        if (empty($machine)) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'error'    => 'Parameter machine tidak boleh kosong.',
                            'csrfHash' => csrf_hash()
                        ]);
        }

        $builder = $db->table('master_table');
        $builder->select('capacity, cushion', 'dh_dies');
        $builder->where('machine', $machine);
        $query = $builder->get();

        if ($query && $query->getNumRows() > 0) {
            $result = $query->getRowArray();
            $machineData = null;
            $dh_dies = null;
                    $queryMachine = $db->query("
                        SELECT 
                            machine,
                            bolster_length,
                            bolster_width,
                            slide_area_length,
                            slide_area_width,
                             slide_stroke,
                            die_height,
                            cushion_pad_length,
                            cushion_pad_width,
                            cushion_stroke
                        FROM mc_spec 
                        WHERE machine = ?",  $machine);
                    $machineData = $queryMachine->getRowArray();
             
                    $queryMachine = $db->query("
                    SELECT 
                        dh_dies
                    FROM master_table 
                    WHERE machine = ?",  $machine);
                $dh_dies = $queryMachine->getRowArray();
         
    
            return $this->response
                        ->setStatusCode(200)
                        ->setJSON([
                            'success'      => true,
                            'data'         => $result,
                            'dh_dies'         => $dh_dies,
                            'machine_data' => $machineData,
                            'csrfHash'     => csrf_hash()
                        ]);

        } else {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON([
                            'error'    => 'Data tidak ditemukan untuk machine: ' . $machine,
                            'csrfHash' => csrf_hash()
                        ]);
        }
    }
    
    // public function submitPrint()
    // {
    //     $db = \Config\Database::connect();

    //         $templatePath = FCPATH . 'uploads/template/templatePPS.xlsx';

    //         if (!file_exists($templatePath)) {
    //             return redirect()->back()->with('error', 'Template Excel tidak ditemukan.');
    //         }

    //     $spreadsheet = IOFactory::load($templatePath);
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $uploadPath = FCPATH . 'uploads/pps/';
    //     if (!is_dir($uploadPath)) {
    //         mkdir($uploadPath, 0777, true);
    //     }
        
    //     $clayoutFiles = $this->request->getFileMultiple("c_layout");
    //     $dcFiles = $this->request->getFileMultiple("die_construction_img");
    //     $BlayoutImg = $this->request->getFile("blank_layout_img");

    //     if ($BlayoutImg && $BlayoutImg->isValid() && !$BlayoutImg->hasMoved()) {
    //         $BlayoutImgNew = "blank_layout_" . time() . "." . $BlayoutImg->getExtension();
    //         $BlayoutImg->move($uploadPath, $BlayoutImgNew); 
        
    //         $drawing = new Drawing();
    //         $drawing->setName('Blank Layout Image');
    //         $drawing->setDescription('Blank Layout Image');
    //         $drawing->setPath($uploadPath . $BlayoutImgNew);
    //         $drawing->setOffsetX(10);
    //         $drawing->setOffsetY(10); 
    //         $drawing->setResizeProportional(true);
    //         $drawing->setWidth(100); 
    //         $drawing->setHeight(100); 
    //         $drawing->setCoordinates('CP4'); 
    //         $drawing->setWorksheet($sheet);
    //     }
    
    //     $processLayout = $this->request->getFile("process_layout_img");

    //     if ($processLayout && $processLayout->isValid() && !$processLayout->hasMoved()) {
    //         $processLayoutNew = "blank_layout_" . time() . "." . $processLayout->getExtension();
    //         $processLayout->move($uploadPath, $processLayoutNew);
        
    //         $drawing = new Drawing();
    //         $drawing->setName('Blank Layout Image');
    //         $drawing->setDescription('Blank Layout Image');
    //         $drawing->setPath($uploadPath . $processLayoutNew);
    //         $drawing->setOffsetX(10); 
    //         $drawing->setOffsetY(10); 
    //         $drawing->setResizeProportional(true);
    //         $drawing->setWidth(100); 
    //         $drawing->setHeight(100); 
      
    //         $drawing->setCoordinates('CI16'); 
    //         $drawing->setWorksheet($sheet);
    //     }
    

    //         $sheet->setCellValue('C6', $this->request->getPost('cust'));
    //         $sheet->setCellValue('P6', $this->request->getPost('model'));
    
    //         $today = date('d-m-Y');
    //         $sheet->setCellValue('AQ6',  $this->request->getPost('receive'));
    
    //         $sheet->setCellValue('CG5', $this->request->getPost('total_dies'));
    //         $sheet->setCellValue('CG7', $this->request->getPost('total_mp'));
    //         $sheet->setCellValue('CG9', $this->request->getPost('total_stroke'));
    //         $sheet->setCellValue('CG11', $this->request->getPost('doc_level'));
        
    //         $length = (float) $this->request->getPost('length');
    //         $width = (float) $this->request->getPost('width');
    //         $boq = (float) $this->request->getPost('boq');
    //         $partNo = "Part No :\n" . $this->request->getPost('part_no');
    //         $sheet->setCellValue('CG73', $partNo);
    //         $sheet->getStyle('CG73')->getFont()->setBold(true); 
    //         $sheet->getStyle('CG73')->getAlignment()->setWrapText(true); 

    //         $partName = "Part Name :\n" . $this->request->getPost('part_name');
    //         $sheet->setCellValue('CU73', $partName);
    //         $sheet->getStyle('CU73')->getFont()->setBold(true); 
    //         $sheet->getStyle('CU73')->getAlignment()->setWrapText(true); 

    //         $sheet->setCellValue('CI70', $length);
    //         $sheet->setCellValue('CI71', $width);
    //         $sheet->setCellValue('CI72', $boq);
    //         $sheet->setCellValue('CO71',$this->request->getPost('blank'));
    //         $sheet->setCellValue('DB71',  $this->request->getPost('scrap'));
    //         $sheet->setCellValue('CU71',$this->request->getPost('panel'));
        
    //         $sheet->setCellValue('CO66', $this->request->getPost('cf') . " Unit");

    //         $sheet->setCellValue('CS68', $this->request->getPost('material'));
    //         $session = session(); 
    //         $sheet->setCellValue('DB79', $session->get('nickname'));
            
    //         $opCells      = ['C9',  'C21', 'C33', 'C45', 'C57', 'C70'];
    //         $processCells = ['C12', 'C24', 'C36', 'C48', 'C60', 'C73'];
    //         $procCells    = ['C15', 'C27', 'C39', 'C51', 'C63', 'C76'];
    //         $prosesCells  = ['C18', 'C30', 'C42', 'C54', 'C66', 'C79'];
          
    //         $cgOpProcessCells = ['CG48', 'CG51', 'CG54', 'CG57', 'CG60', 'CG63', ];
    //         $cgProcessCells = ['CG49', 'CG52', 'CG55', 'CG58', 'CG61', 'CG64'];
         
            
        
    //         $totalDies = min(6, (int) $this->request->getPost('total_dies'));
    //         $processArray = $this->request->getPost('process') ?? [];
    //         $prosesArray  = $this->request->getPost('proses') ?? [];

    //         $upperCells      = ['AY18', 'AY30', 'AY42', 'AY54', 'AY67', 'AY80'];
    //         $lowerCells      = ['AY19', 'AY31', 'AY43', 'AY55', 'AY68', 'AY81'];
    //         $padCells        = ['AY20', 'AY33', 'AY45', 'AY57', 'AY70', 'AY83'];
    //         $slidingCells    = ['BJ18', 'BJ30', 'BJ42', 'BJ54', 'BJ67', 'BJ80'];
    //         $guideCells      = ['BJ19', 'BJ31', 'BJ43', 'BJ55', 'BJ68', 'BJ81'];
    //         $padLifterCells  = ['BM19', 'BM32', 'BM44', 'BM56', 'BM69', 'BM82'];
    //         $insertCells     = ['BX18', 'BX30', 'BX42', 'BX54', 'BX67', 'BX80'];
            
    //         $upperTextCells      = ['AU18', 'AU30', 'AU42', 'AU54', 'AU67', 'AU80'];
    //         $lowerTextCells      = ['AU19', 'AU31', 'AU43', 'AU55', 'AU68', 'AU81'];
    //         $padTextCells       = ['AU20', 'AU32', 'AU44', 'AU56', 'AU69', 'AU82'];
    //         $slidingTextCells    = ['BE18', 'BE30', 'BE42', 'BE54', 'BE67', 'BE80'];
    //         $guideTextCells      = ['BE19', 'BE31', 'BE43', 'BE55', 'BE68', 'BE81'];
    //         $padLifterTextCells  = ['BE20', 'BE32', 'BE44', 'BE56', 'BE69', 'BE82'];
    //         $insertTextCells     = ['BT18', 'BT30', 'BT42', 'BT54', 'BT67', 'BT80'];
    //         $dieLengthCells = [];
    //         for ($i = 48; $i <= 63; $i += 3) {
    //             $dieLengthCells[] = 'CW' . $i;
    //         }

    //         $dieWeightCells = [];
    //         for ($i = 49; $i <= 64; $i += 3) {
    //             $dieWeightCells[] = 'CW' . $i;
    //         }

    //         $dieHeightCells = [];
    //         for ($i = 50; $i <= 65; $i += 3) {
    //             $dieHeightCells[] = 'CW' . $i;
    //         }

    //         $qtyDiesProcessCells = ['CL48', 'CL51', 'CL54', 'CL57', 'CL60', 'CL63'];
    //         $dieCushionCells = [];
    //         for ($i = 50; $i <= 65; $i += 3) {
    //             $dieCushionCells[] = 'CO' . $i;
    //         }
    //         $mcCells =  [];
    //         for ($i = 48; $i <= 63; $i += 3) {
    //             $mcCells[] = 'CO' . $i;
    //         }
    //     // Ambil data dari form, pastikan datanya berupa array atau default ke array kosong
    //     $bolsterLengthArr    = is_array($this->request->getPost('bolster_length'))    ? $this->request->getPost('bolster_length')    : [];
    //     $bolsterWeightArr    = is_array($this->request->getPost('bolster_width'))    ? $this->request->getPost('bolster_width')    : [];
    //     $slideAreaLengthArr  = is_array($this->request->getPost('slide_area_length'))  ? $this->request->getPost('slide_area_length')  : [];
    //     $slideAreaWeightArr  = is_array($this->request->getPost('slide_area_width'))  ? $this->request->getPost('slide_area_width')  : [];
    //     $dieHeightMaxArr     = is_array($this->request->getPost('die_height'))         ? $this->request->getPost('die_height')         : [];
    //     $cushionPadLengthArr = is_array($this->request->getPost('cushion_pad_length')) ? $this->request->getPost('cushion_pad_length') : [];
    //     $cushionPadWeightArr = is_array($this->request->getPost('cushion_pad_width')) ? $this->request->getPost('cushion_pad_width') : [];
    //     $cushionStrokeArr    = is_array($this->request->getPost('cushion_stroke'))     ? $this->request->getPost('cushion_stroke')     : [];
    //     $machineSpec         = is_array($this->request->getPost('machine'))            ? $this->request->getPost('machine')            : [];

    //     // Daftar kolom target yang ingin diisi data
    //     $targetColumns = ["CQ", "CU", "CZ", "DE"];
    //     $j = 0; // indeks untuk targetColumns

    //     // Pastikan $totalDies sudah didefinisikan, misal jumlah elemen di salah satu array
    //     $totalDies = count($bolsterLengthArr);

    //     for ($i = 0; $i < $totalDies; $i++) {
    //         $column = $targetColumns[$j] ?? end($targetColumns);
            
    //         // Cek apakah ada baris selanjutnya untuk dibandingkan
    //         if (
    //             ($i < $totalDies - 1) &&
    //             ($bolsterLengthArr[$i]    ?? '') == ($bolsterLengthArr[$i+1]    ?? '') &&
    //             ($bolsterWeightArr[$i]    ?? '') == ($bolsterWeightArr[$i+1]    ?? '') &&
    //             ($slideAreaLengthArr[$i]  ?? '') == ($slideAreaLengthArr[$i+1]  ?? '') &&
    //             ($slideAreaWeightArr[$i]  ?? '') == ($slideAreaWeightArr[$i+1]  ?? '') &&
    //             ($dieHeightMaxArr[$i]     ?? '') == ($dieHeightMaxArr[$i+1]     ?? '') &&
    //             ($cushionPadLengthArr[$i] ?? '') == ($cushionPadLengthArr[$i+1] ?? '') &&
    //             ($cushionPadWeightArr[$i] ?? '') == ($cushionPadWeightArr[$i+1] ?? '') &&
    //             ($cushionStrokeArr[$i]    ?? '') == ($cushionStrokeArr[$i+1]    ?? '')
    //         ) {
    //             // Jika data baris ke-i dan ke-(i+1) identik, gabungkan machineSpec
    //             $mergedMachine = ($machineSpec[$i] ?? '') . ', ' . ($machineSpec[$i+1] ?? '');
                
    //             $sheet->setCellValue("{$column}34", $mergedMachine);
    //             $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
    //             $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
    //             $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
    //             $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
    //             $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
    //             $sheet->setCellValue("{$column}40", $cushionPadLengthArr[$i] ?? '');
    //             $sheet->setCellValue("{$column}41", $cushionPadWeightArr[$i] ?? '');
    //             $sheet->setCellValue("{$column}42", $cushionStrokeArr[$i]    ?? '');
                
    //             // Lewati baris berikutnya karena sudah digabung
    //             $i++; 
    //             $j++;
    //         } else {
    //             // Jika tidak ada pasangan (atau baris berikutnya berbeda), tuliskan data baris ke-i secara individual
    //             $sheet->setCellValue("{$column}34", $machineSpec[$i]         ?? '');
    //             $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
    //             $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
    //             $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
    //             $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
    //             $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
    //             $sheet->setCellValue("{$column}40", $cushionPadLengthArr[$i] ?? '');
    //             $sheet->setCellValue("{$column}41", $cushionPadWeightArr[$i] ?? '');
    //             $sheet->setCellValue("{$column}42", $cushionStrokeArr[$i]    ?? '');
    //             $j++;
    //         }
    //     }




    //         $capacityCells =  [];
    //         for ($i = 49; $i <= 64; $i += 3) {
    //             $capacityCells[] = 'CO' . $i;
    //         }
    //         $ClayoutImageCells = ['H9', 'H21', 'H33', 'H45', 'H57', 'H70'];
    //         $DcLayoutCells = ['AT9', 'AT21', 'AT33', 'AT45', 'AT57', 'AT70'];
    //         $upperArr      = $this->request->getPost('upper') ?? [];
    //         $lowerArr      = $this->request->getPost('lower') ?? [];
    //         $padArr        = $this->request->getPost('pad') ?? [];
    //         $slidingArr    = $this->request->getPost('sliding') ?? [];
    //         $guideArr      = $this->request->getPost('guide') ?? [];
    //         $padLifterArr  = $this->request->getPost('pad_lifter') ?? [];
    //         $insertArr     = $this->request->getPost('insert') ?? [];

    //         $machines   = $this->request->getPost('machine') ?? [];
    //         $capacities = $this->request->getPost('capacity') ?? [];
    //         $cushions   = $this->request->getPost('cushion') ?? [];
    //         $maxWidth = 300;
    //         $maxHeight = 400;
    //         $padding = 10;

    //         for ($i = 0; $i < $totalDies; $i++) {
    //             $sheet->setCellValue($processCells[$i], $processArray[$i] ?? '');
    //             $sheet->setCellValue($prosesCells[$i], $prosesArray[$i] ?? '');
    //             $sheet->setCellValue($opCells[$i], 'OP');
    //             if (isset($qtyDiesProcessCells[$i])) {
    //                 $sheet->setCellValue($qtyDiesProcessCells[$i], 1);
    //             }

    //             if (isset($procCells[$i])) {
    //                 $sheet->setCellValue($procCells[$i], 'PROC.');
    //             }
    
    //             $sheet->setCellValue($cgOpProcessCells[$i], $processArray[$i] ?? '');
    //             $sheet->setCellValue(
    //                 $cgOpProcessCells[$i] ?? '', 
    //                 'OP ' . ($processArray[$i] ?? '')
    //             );
                
    //             $sheet->setCellValue($cgProcessCells[$i],  ($prosesArray[$i] ?? ''));
                
              
    //             $sheet->setCellValue($mcCells[$i], $machines[$i]); 
        
        
    //             $sheet->setCellValue($dieCushionCells[$i], $cushions[$i]); 
            
    //             $sheet->setCellValue($capacityCells[$i], $capacities[$i]); 
             
             
    //             if (isset($upperCells[$i])) {
    //                 $sheet->setCellValue($upperCells[$i], $upperArr[$i] ?? '');
    //             }
        
    //             if (isset($lowerCells[$i])) {
    //                 $sheet->setCellValue($lowerCells[$i], $lowerArr[$i] ?? '');
    //             }
            
    //             if (isset($padCells[$i])) {
    //                 $sheet->setCellValue($padCells[$i], $padArr[$i] ?? '');
    //             }
            
    //             if (isset($slidingCells[$i])) {
    //                 $sheet->setCellValue($slidingCells[$i], $slidingArr[$i] ?? '');
    //             }
            
    //             if (isset($guideCells[$i])) {
    //                 $sheet->setCellValue($guideCells[$i], $guideArr[$i] ?? '');
    //             }
            
    //             if (isset($padLifterCells[$i])) {
    //                 $sheet->setCellValue($padLifterCells[$i], $padLifterArr[$i] ?? '');
    //             }
            
    //             if (isset($insertCells[$i])) {
    //                 $sheet->setCellValue($insertCells[$i], $insertArr[$i] ?? '');
    //             }

    //             if (isset($upperTextCells[$i])) {
    //                 $sheet->setCellValue($upperTextCells[$i], 'UPPER');
    //             }
            
    //             if (isset($lowerTextCells[$i])) {
    //                 $sheet->setCellValue($lowerTextCells[$i], 'LOWER');
    //             }
            
    //             if (isset($padTextCells[$i])) {
    //                 $sheet->setCellValue($padTextCells[$i], 'PAD');
    //             }
            
    //             if (isset($slidingTextCells[$i])) {
    //                 $sheet->setCellValue($slidingTextCells[$i], 'SLIDING');
    //             }
            
    //             if (isset($guideTextCells[$i])) {
    //                 $sheet->setCellValue($guideTextCells[$i], 'GUIDE');
    //             }
            
    //             if (isset($padLifterTextCells[$i])) {
    //                 $sheet->setCellValue($padLifterTextCells[$i], 'PAD LIFTER');
    //             }
            
    //             if (isset($insertTextCells[$i])) {
    //                 $sheet->setCellValue($insertTextCells[$i], 'INSERT');
    //             }
    //             if (isset($clayoutFiles[$i]) && $clayoutFiles[$i]->isValid() && !$clayoutFiles[$i]->hasMoved()) {
    //                 // Generate nama file baru dengan timestamp dan indeks
    //                 $clayoutNewName = "clayout_" . time() . "_" . $i . "." . $clayoutFiles[$i]->getExtension();
                    
    //                 // Pindahkan file ke direktori upload
    //                 $clayoutFiles[$i]->move($uploadPath, $clayoutNewName);
                    
    //                 // Buat objek Drawing untuk menyisipkan gambar
    //                 $drawing = new Drawing();
    //                 $drawing->setName('Clayout Image');
    //                 $drawing->setDescription('Clayout Image');
    //                 $drawing->setPath($uploadPath . $clayoutNewName);
    //                 $drawing->setOffsetX(10); 
    //                 $drawing->setOffsetY(10); 
                    
    //                 // Set ukuran gambar secara proporsional
    //                 $drawing->setResizeProportional(true);
    //                 $drawing->setWidth(400);  // Set lebar gambar (tinggi akan disesuaikan secara proporsional)
                    
    //                 // Pastikan $ClayoutImageCells[$i] berisi koordinat yang valid, misalnya "H9", "H21", dll.
    //                 if (isset($ClayoutImageCells[$i])) {
    //                     $drawing->setCoordinates($ClayoutImageCells[$i]);
    //                 } else {
    //                     // Jika tidak ada koordinat yang valid, tampilkan pesan atau lakukan tindakan lainnya
    //                     echo "Koordinat gambar tidak valid untuk indeks $i.";
    //                 }
                    
    //                 // Tentukan worksheet untuk menyisipkan gambar
    //                 $drawing->setWorksheet($sheet);
    //             }
                
    //            if (isset($dcFiles[$i]) && $dcFiles[$i]->isValid() && !$dcFiles[$i]->hasMoved()) {
    //                 $dcNewName = "die_construction_" . time() . "_" . $i . "." . $dcFiles[$i]->getExtension();
    //                 $dcFiles[$i]->move($uploadPath, $dcNewName);
            
    //                 $drawing = new Drawing();
    //                 $drawing->setName('Die Construction Image');
    //                 $drawing->setDescription('Die Construction Image');
    //                 $drawing->setPath($uploadPath . $dcNewName);
    //                 $drawing->setOffsetX($padding);
    //                 $drawing->setOffsetY($padding); 
    //                 $drawing->setResizeProportional(true);
    //                 $drawing->setWidth($maxWidth);
    //                 $drawing->setHeight($maxHeight);
    //                 $drawing->setCoordinates($DcLayoutCells[$i]);
    //                 $drawing->setWorksheet($sheet);
    //             }
                
    //         }
    
    //         $cuCells = [];
    //         $dieSizeCell = [];
    //         for ($i = 48; $i <= 65; $i++) {
    //             $cuCells[] = "CU{$i}";
    //             $dieSizeCell[] = "CW{$i}";
    //         }
            
    //         $diesWeightCells = [];
    //         for ($i = 48; $i <= 63; $i += 3) {
    //             $diesWeightCells[] = "DB{$i}";
    //         }
            
    //         $mainPressCells = ['DB50', 'DB53', 'DB56', 'DB59', 'DB62', 'DB65'];
    //         $dieLengthArray = $this->request->getPost('die_length') ?? [];
    //         $dieWidthArray  = $this->request->getPost('die_width') ?? [];
           
    //         $dieHeightArray = $this->request->getPost('die_height') ?? [];
    //         $dieWeightArray = $this->request->getPost('die_weight') ?? [];
    //         $mainPressureArray = $this->request->getPost('main_pressure') ?? [];
    //         $prosesDieStandardArray  = $this->request->getPost('proses_standard_die') ?? [];
            
    //         $class = []; 
    //         $dieLenghtStandard = [];
    //         $dieWidthStandard = [];
      
    //         $values = ['L', 'W', 'H'];
    //         $totalDies = count($dieHeightArray); 
            
    //         for ($j = 0; $j < $totalDies; $j++) {
    //             for ($i = 0; $i < 3; $i++) {
    //                 if (isset($cuCells[$i + ($j * 3)])) {
    //                     $sheet->setCellValue($cuCells[$i + ($j * 3)], $values[$i]);
    //                 }
            
    //                 if (isset($dieSizeCell[$i + ($j * 3)])) {
    //                     $value = '';
    //                     if ($i == 0 && isset($dieLengthArray[$j])) {
    //                         $value = $dieLengthArray[$j]; 
    //                     } elseif ($i == 1 && isset($dieWeightArray[$j])) {
    //                         $value = $dieWeightArray[$j]; 
    //                     } elseif ($i == 2 && isset($dieHeightArray[$j])) {
    //                         $value = $dieHeightArray[$j]; 
    //                     }
    //                     $sheet->setCellValue($dieSizeCell[$i + ($j * 3)], $value);
    //                 }
    //             }
            
            
    //             if (isset($diesWeightCells[$j]) && isset($dieWeightArray[$j])) {
    //                 $sheet->setCellValue($diesWeightCells[$j], $dieWeightArray[$j]);
    //             }
            
    //             if (isset($mainPressCells[$j]) && isset($mainPressureArray[$j])) {
    //                 $sheet->setCellValue($mainPressCells[$j], $mainPressureArray[$j]);
    //             }
    //             // if (isset($nullCells[$i])) {
    //             //     $sheet->setCellValue($nullCells[$i], '-');
    //             // }
            
    //             // Mengisi mcCells dengan nilai dari dropdown machine[]
    //             // if (isset($mcCells[$i])) {
    //             //     $sheet->setCellValue($mcCells[$i], $_POST['machine'][$i] ?? '');
    //             // }
            
    //             // // Mengisi capacityCells dengan nilai dari input capacity[]
    //             // if (isset($capacityCells[$i])) {
    //             //     $sheet->setCellValue($capacityCells[$i], $_POST['capacity'][$i] ?? '');
    //             // }

            
    //         }
          
        
    //         $newFilePath = WRITEPATH . 'uploads/generated_' . time() . '.xlsx';
    //         $writer = new Xlsx($spreadsheet);
    //         $writer->save($newFilePath);
    
    //         return $this->response->download($newFilePath, null)->setFileName('generated.xlsx');
    
    // }
    // public function submit()
    // {
    //     $validation = \Config\Services::validation();
    //     $session = session();
        
    //     // // Validasi input
    //     // $validation->setRules([
    //     //     'cust' => 'required',
    //     //     'model' => 'required',
    //     //     'total_dies' => 'required|numeric',
    //     // ]);

    //     $blankLayoutName = null;
    //     $processLayoutName = null;
        
    //    // === Blank Layout ===
    //     $blankLayoutFile = $this->request->getFile('blank_layout_img');
    //     $blankLayoutSelected = $this->request->getPost('blank_layout_selected');

    //     if ($blankLayoutFile && $blankLayoutFile->isValid()) {
    //         $blankLayoutName = $blankLayoutFile->getRandomName();
    //         $blankLayoutFile->move(ROOTPATH . 'public/uploads/blank_layout', $blankLayoutName);
    //     } elseif ($blankLayoutSelected) {
    //         // Ambil path relatif dari URL
    //         $parsedPath = parse_url($blankLayoutSelected, PHP_URL_PATH);
    //         $relativePath = str_replace('/uploads/', '', $parsedPath); // contoh: dcp/nama_file.png
    //         $sourcePath = ROOTPATH . 'public/uploads/' . $relativePath;

    //         if (file_exists($sourcePath)) {
    //             $blankLayoutName = uniqid() . '_' . basename($sourcePath);
    //             copy($sourcePath, ROOTPATH . 'public/uploads/blank_layout/' . $blankLayoutName);
    //         }
    //     }

    //     // === Process Layout ===
    //     $processLayoutFile = $this->request->getFile('process_layout_img');
    //     $processLayoutSelected = $this->request->getPost('process_layout_selected');

    //     if ($processLayoutFile && $processLayoutFile->isValid()) {
    //         $processLayoutName = $processLayoutFile->getRandomName();
    //         $processLayoutFile->move(ROOTPATH . 'public/uploads/process_layout', $processLayoutName);
    //     } elseif ($processLayoutSelected) {
    //         // Ambil path relatif dari URL
    //         $parsedPath = parse_url($processLayoutSelected, PHP_URL_PATH);
    //         $relativePath = str_replace('/uploads/', '', $parsedPath); // contoh: dcp/nama_file.png
    //         $sourcePath = ROOTPATH . 'public/uploads/' . $relativePath;

    //         if (file_exists($sourcePath)) {
    //             $processLayoutName = uniqid() . '_' . basename($sourcePath);
    //             copy($sourcePath, ROOTPATH . 'public/uploads/process_layout/' . $processLayoutName);
    //         }
    //     }


    //     $mainData = [
    //         'cust' => $this->request->getPost('cust'),
    //         'model' => $this->request->getPost('model'),
    //         'receive' => $this->request->getPost('receive'),
    //         'part_no' => $this->request->getPost('part_no'),
    //         'part_name' => $this->request->getPost('part_name'),
    //         'cf' => $this->request->getPost('cf'),
    //         'material' => $this->request->getPost('material'),
    //         'tonasi' => $this->request->getPost('tonasi'),
    //         'length' => $this->request->getPost('length'),
    //         'width' => $this->request->getPost('width'),
    //         'boq' => $this->request->getPost('boq'),
    //         'blank' => $this->request->getPost('blank'),
    //         'panel' => $this->request->getPost('panel'),
    //         'scrap' => $this->request->getPost('scrap'),
    //         'total_mp' => $this->request->getPost('total_mp'),
    //         'doc_level' => $this->request->getPost('doc_level'),
    //         'total_stroke' => $this->request->getPost('total_stroke'),
    //         'blank_layout' => $blankLayoutName,
    //         'process_layout' => $processLayoutName,
    //         'created_at' => date('Y-m-d')
    //     ];
    
    //         $ppsId = $this->ppsModel->insert($mainData);
        
    //         $processes = $this->request->getPost('process');
    //         $diesData = [];
            
    //         foreach ($processes as $index => $process) {
    //             $cLayoutFile = $this->request->getFileMultiple('c_layout')[$index] ?? null;
    //             $dieConstrFile = $this->request->getFileMultiple('die_construction_img')[$index] ?? null;
                
    //             $cLayoutName = null;
    //             $dieConstrName = null;
    //             if ($cLayoutFile && $cLayoutFile->isValid()) {
    //                 // Jika upload file
    //                 $cLayoutName = $cLayoutFile->getRandomName();
    //                 $cLayoutFile->move(ROOTPATH . 'public/uploads/c_layout', $cLayoutName);
    //             } else {
    //                 // Jika pilih dari gambar yang ada
    //                 $selectedClayout = $this->request->getPost('c_layout_selected')[$index] ?? null;
    //                 if ($selectedClayout) {
    //                     // Ambil path setelah domain, contoh: /uploads/dcp/nama_file.png
    //                     $parsedUrl = parse_url($selectedClayout, PHP_URL_PATH);
                
    //                     // Pastikan path dimulai dari '/uploads/', lalu ambil path relatifnya
    //                     $relativePath = str_replace('/uploads/', '', $parsedUrl);
                
    //                     // Bangun path lengkap ke file sumber
    //                     $fullSourcePath = ROOTPATH . 'public/uploads/' . $relativePath;
                
    //                     if (file_exists($fullSourcePath)) {
    //                         // Generate nama baru agar tidak bentrok
    //                         $cLayoutName = uniqid() . '_' . basename($fullSourcePath);
    //                         $destinationPath = ROOTPATH . 'public/uploads/c_layout/' . $cLayoutName;
                
    //                         // Salin file
    //                         copy($fullSourcePath, $destinationPath);
    //                     }
    //                 }
    //             }
                
            
    //             // ==== HANDLE DIE CONSTRUCTION ====
    //             if ($dieConstrFile && $dieConstrFile->isValid()) {
    //                 $dieConstrName = $dieConstrFile->getRandomName();
    //                 $dieConstrFile->move(ROOTPATH . 'public/uploads/die_construction', $dieConstrName);
    //             } else {
    //                 $selectedDieConstr = $this->request->getPost('die_cons_selected')[$index] ?? null;
    //                 if ($selectedDieConstr) {
    //                     $originalPath = parse_url($selectedDieConstr, PHP_URL_PATH);
    //                     $fullSourcePath = ROOTPATH . 'public' . $originalPath;
            
    //                     if (file_exists($fullSourcePath)) {
    //                         $dieConstrName = uniqid() . '_' . basename($fullSourcePath);
    //                         $destinationPath = ROOTPATH . 'public/uploads/die_construction/' . $dieConstrName;
    //                         copy($fullSourcePath, $destinationPath);
    //                     }
    //                 }
    //             }
    //             $weight =   $this->request->getPost('die_weight')[$index];
    //             $class = null;
    //             if ($weight > 6971) {
    //                 $class = "A";
    //             } else if ($weight > 3914 && $weight <= 6971) {
    //                 $class = "B";
    //             } else if ($weight > 1961 && $weight <= 3914) {
    //                 $class = "C";
    //             } else if ($weight > 848 && $weight <= 1961) {
    //                 $class = "D";
    //             } else if ($weight > 397 && $weight <= 848) {
    //                 $class = "E";
    //             } else if ($weight <= 397) {
    //                 $class = "F";
    //             }

    //             $diesData[] = [
    //                 'pps_id' => $ppsId,
    //                 'process' => $process,
    //                 'process_join' => $this->request->getPost('process_join')[$index],
    //                 'proses' => $this->request->getPost('proses')[$index],
    //                 'length_mp' => $this->request->getPost('length_mp')[$index],
    //                 'main_pressure' => $this->request->getPost('main_pressure')[$index],
    //                 'machine' => $this->request->getPost('machine')[$index],
    //                 'capacity' => $this->request->getPost('capacity')[$index],
    //                 'cushion' => $this->request->getPost('cushion')[$index],
    //                 'die_length' => $this->request->getPost('die_length')[$index],
    //                 'die_width' => $this->request->getPost('die_width')[$index],
    //                 'die_height' => $this->request->getPost('die_height')[$index],
    //                 'casting_plate' => $this->request->getPost('casting_plate')[$index],
    //                 'die_weight' => $this->request->getPost('die_weight')[$index],
    //                 'upper' => $this->request->getPost('upper')[$index],
    //                 'lower' => $this->request->getPost('lower')[$index],
    //                 'pad' => $this->request->getPost('pad')[$index],
    //                 'pad_lifter' => $this->request->getPost('pad_lifter')[$index],
    //                 'sliding' => $this->request->getPost('sliding')[$index],
    //                 'guide' => $this->request->getPost('guide')[$index],
    //                 'insert' => $this->request->getPost('insert')[$index],
    //                 'heat_treatment' => $this->request->getPost('heat_treatment')[$index],
    //                 'panjang' => $this->request->getPost('panjang')[$index],
    //                 'lebar' => $this->request->getPost('lebar')[$index],
    //                 'clayout_img' => $cLayoutName,
    //                 'die_construction_img' => $dieConstrName,
    //                 'class' => $class,
    //             ];
    //         }

    //         $this->ppsDiesModel->insertBatch($diesData);

    //         $session->setFlashdata('success', 'Data berhasil disimpan');
    //         return redirect()->to('/pps');

      
    // }
    public function edit($id, $mode = 'edit')
    {
        $ppsModel = new PpsModel();
        $ppsDiesModel = new PpsDiesModel();
    
        $machineOptions = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        
        foreach ($letters as $letter) {
            $max = ($letter == 'C') ? 2 : 4; 
            for ($i = 1; $i <= $max; $i++) {
                $machineOptions[] = $letter . $i;
            }
        }
        $machineOptions = array_merge($machineOptions, ['MP', 'SP1', 'SP2', 'SP3']);
    
        $pps = $ppsModel->find($id);
        if (!$pps) {
            return redirect()->to('/pps')->with('error', 'Data tidak ditemukan');
        }
        $materialData = (new \App\Models\MaterialModel())
        ->where('status', 1)
        ->orderBy('name_material', 'ASC')
        ->findAll();
    
        
        $dies = $ppsDiesModel->where('pps_id', $id)->findAll();

    
        $projects = (new ProjectModel())
        ->where('status', 1)
        ->where('jenis !=', 'Others')
        ->orderBy('model')
        ->orderBy('part_no')
        ->findAll();
 
        $data = [
            'pps'            => $pps,
            'dies'           => $dies,
            'projects'       => $projects,
            'machineOptions' => $machineOptions,
           'materialData'   => $materialData, 
            'isCopy'         => $mode === 'copy',
        ];
    
        // Tentukan view berdasarkan mode
        $viewName = $mode === 'copy' ? 'pps/edit_copy' : 'pps/edit';
    
        return view($viewName, $data);
    }
    

    public function editNew($id)
    {
        $ppsModel = new PpsModel();
        $ppsDiesModel = new PpsDiesModel();
    
        $machineOptions = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($letters as $letter) {
            
            for ($i = 1; $i <= 4; $i++) {
                $machineOptions[] = $letter . $i;
            }
        }
        $machineOptions = array_merge($machineOptions, ['MP', 'SP1', 'SP2', 'SP3']);
    
        $pps = $ppsModel->find($id);
        if (!$pps) {
            return redirect()->to('/pps')->with('error', 'Data tidak ditemukan');
        }

        $dies = $ppsDiesModel->where('pps_id', $id)->findAll();
  
        $data = [
            'pps'            => $pps,
            'dies'           => $dies,
            'machineOptions' => $machineOptions,
        ];
        return view('pps/edit', $data);
    }
    public function update()
    {
        $action = $this->request->getPost('action');

        if ($action === 'save_as_new') {
            return $this->updateNew(); // panggil method copy data
        }
        $ppsModel = new PpsModel();
        $ppsDiesModel = new PpsDiesModel();
    
        $id = $this->request->getPost('id');
        $oldData = $ppsModel->where('id', $id)->first() ;
        
        $dataPps = [
            'cust'         => $this->request->getPost('cust'),
            'model'        => $this->request->getPost('model'),
            'receive'      => $this->request->getPost('receive'),
            'part_no'      => $this->request->getPost('part_no'),
            'part_name'    => $this->request->getPost('part_name'),
            'cf'           => $this->request->getPost('cf'),
            'material'     => $this->request->getPost('material'),
            'tonasi'       => $this->request->getPost('tonasi'),
            'length'       => $this->request->getPost('length'),
            'width'        => $this->request->getPost('width'),
            'boq'          => $this->request->getPost('boq'),
            'blank'        => $this->request->getPost('blank'),
            'panel'        => $this->request->getPost('panel'),
            'scrap'        => $this->request->getPost('scrap'),
            'total_mp'     => $this->request->getPost('total_mp'),
            'doc_level'    => $this->request->getPost('doc_level'),
            'total_stroke' => $this->request->getPost('total_stroke'),
            'process_layout' => $this->request->getPost('process_layout'),
            'blank_layout'   => $this->request->getPost('blank_layout'),
            'created_by'   => session()->get('user_id')
        ];
        $uploadPath = FCPATH . 'uploads/pps/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        
        $blankLayout = $this->request->getFile('blank_layout');
        if ($blankLayout && $blankLayout->isValid() && !$blankLayout->hasMoved()) {
            if (!empty($oldData['blank_layout'])) {
                @unlink($uploadPath . $oldData['blank_layout']);
            }
            $blankLayoutName = "blank_layout_" . time() . "." . $blankLayout->getExtension();
            $blankLayout->move($uploadPath, $blankLayoutName);
            $dataPps['blank_layout'] = $blankLayoutName;
        } else {
            $dataPps['blank_layout'] = $this->request->getPost('old_blank_layout');
        }
        

        $processLayout = $this->request->getFile('process_layout_img');
        $processLayoutSelected = $this->request->getPost('process_layout_selected');
        $oldImage = $this->request->getPost('old_process_layout');
        
        if ($processLayout && $processLayout->isValid() && !$processLayout->hasMoved()) {
            $processLayoutName = "process_layout_" . time() . "." . $processLayout->getExtension();
            $processLayout->move($uploadPath, $processLayoutName);
            $dataPps['process_layout'] = $processLayoutName;
    
        } elseif ($processLayoutSelected) {
            $processLayoutSelected = urldecode($this->request->getPost('process_layout_selected')); 
            $parsedPath = parse_url($processLayoutSelected, PHP_URL_PATH); 
            $sourcePath = FCPATH . ltrim($parsedPath, '/'); 
            
     
            if (file_exists($sourcePath)) {
                $processLayoutName = "process_layout_" . time() . "_" . basename($sourcePath);
                copy($sourcePath, $uploadPath . $processLayoutName);
                $dataPps['process_layout'] = $processLayoutName;

              
            } else {
                $dataPps['process_layout'] = $oldImage;
          
            }
        
        } else {
            // Tidak ada upload & tidak pilih dari list → pakai gambar lama
            $dataPps['process_layout'] = $oldImage;
        }
     
        $ppsModel->update($id, $dataPps);
        $oldDiesData = $ppsDiesModel->where('pps_id', $id)->findAll();

        $oldImages = [];
        foreach ($oldDiesData as $i => $die) {
            $oldImages[$i] = [
                'clayout_img' => $die['clayout_img'],
                'die_construction_img' => $die['die_construction_img']
            ];
        }
        $ppsDiesModel->where('pps_id', $id)->delete(); 
        
    
        $dies = $this->request->getPost('dies');
    
        if (!empty($dies) && is_array($dies)) {
            foreach ($dies as $index => $die) {

                $class = null;
                $die_weight = $die['die_weight'] ?? null;
            
                if ($die_weight > 6971) {
                    $class = "A";
                } else if ($die_weight > 3914 && $die_weight <= 6971) {
                    $class = "B";
                } else if ($die_weight > 1961 && $die_weight <= 3914) {
                    $class = "C";
                } else if ($die_weight > 848 && $die_weight <= 1961) {
                    $class = "D";
                } else if ($die_weight > 397 && $die_weight <= 848) {
                    $class = "E";
                } else if ($die_weight <= 397) {
                    $class = "F";
                }


                 $dieData = [
                    'pps_id'            => $id,
                    'process'           => $die['process'] ?? null,
                    'process_join'      => $die['process_join'] ?? null,
                    'proses'            => $die['proses'] ?? null,
                    'proses_gang'            => $die['proses_gang'] ?? null,
                    'length_mp'         => $die['length_mp'] ?? null,
                    'main_pressure'     => $die['main_pressure'] ?? null,
                    'panjang'           => $die['panjang'] ?? null,
                    'lebar'           => $die['lebar'] ?? null,
                    'machine'           => $die['machine'] ?? null,
                    'capacity'          => $die['capacity'] ?? null,
                    'cushion'           => $die['cushion'] ?? null,
                    'die_length'        => $die['die_length'] ?? null,
                    'die_width'         => $die['die_width'] ?? null,
                    'die_height'        => $die['die_height'] ?? null,
                    'casting_plate'     => $die['casting_plate'] ?? null,
                    'die_weight'        => $die['die_weight'] ?? null,
                    'dc_process'        => $die['dc_process'] ?? null,
                    'dc_machine'        => $die['dc_machine'] ?? null,
                    'upper'             => $die['upper'] ?? null,
                    'lower'             => $die['lower'] ?? null,
                    'pad'               => $die['pad'] ?? null,
                    'pad_lifter'        => $die['pad_lifter'] ?? null,
                    'sliding'           => $die['sliding'] ?? null,
                    'guide'             => $die['guide'] ?? null,
                    'insert'            => $die['insert'] ?? null,
                    'heat_treatment'    => $die['heat_treatment'] ?? null,
                    'slide_stroke'      => $die['slide_stroke'] ?? null,
                    'cushion_stroke'    => $die['cushion_stroke'] ?? null,
                    'die_cushion_pad'   => $die['die_cushion_pad'] ?? null,
                    'bolster_length'    => $die['bolster_length'] ?? null,
                    'bolster_width'    => $die['bolster_width'] ?? null,
                    'slide_area_length' => $die['slide_area_length'] ?? null,
                    'slide_area_width' => $die['slide_area_width'] ?? null,
                    'cushion_pad_length'=> $die['cushion_pad_length'] ?? null,
                    'cushion_pad_width'=> $die['cushion_pad_width'] ?? null,
                    'class'             => $die['die_class'] ?? null,
                    'die_height_max'    => $die['die_height_max'] ?? null,
                     'cbPanjangProses'   =>  $die['cbPanjangProses'] == '1' ? 1 : 0,
                    'cbPie'             => $die['cbPie'] == '1' ? 1 : 0,
                    'cbPanjangLebar'    => $die['cbPanjangLebar'] == '1' ? 1 : 0,
              
                ];
        $oldClayoutImg = $oldImages[$index]['clayout_img'] ?? null;
      
        $oldDieConstructionImg = $oldImages[$index]['die_construction_img'] ?? null;

        $clayoutFile = $this->request->getFile("dies.{$index}.clayout_img");
        if ($clayoutFile && $clayoutFile->getError() === UPLOAD_ERR_OK) {
            $clayoutName = "clayout_" . time() . "_$index." . $clayoutFile->getExtension();
            $clayoutFile->move($uploadPath, $clayoutName);
            $dieData['clayout_img'] = $clayoutName;
        } else {
            $dieData['clayout_img'] = $oldClayoutImg;
        }

        // Cek upload baru untuk die construction
        $dieConstructionFile = $this->request->getFile("dies.{$index}.die_construction_img");
        if ($dieConstructionFile && $dieConstructionFile->getError() === UPLOAD_ERR_OK) {
            $dieConstrName = "die_constr_" . time() . "_$index." . $dieConstructionFile->getExtension();
            $dieConstructionFile->move($uploadPath, $dieConstrName);
            $dieData['die_construction_img'] = $dieConstrName;
        } else {
            $dieData['die_construction_img'] = $oldDieConstructionImg;
        }
                $ppsDiesModel->insert($dieData);
            }
        
        } 
    
        return redirect()->to(site_url('pps'))->with('success', 'Data berhasil diupdate');
    }
    
    public function submitAndDownload()
    {
        $db = \Config\Database::connect();
        $validation = \Config\Services::validation();
        $session = session();

        $validation->setRules([
            'cust' => 'required',
            'model' => 'required',
            'total_dies' => 'required|numeric',
            'part_no' => 'required'
        ]);
        if (!$this->request->getPost('cust') || !$this->request->getPost('model')) {
            return redirect()->back()->with('error', 'Data penting tidak boleh kosong');
        }
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $uploadPath = FCPATH . 'uploads/pps/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // === Blank Layout ===
        $BlayoutImg = $this->request->getFile("blank_layout_img");
        $blankLayoutSelected = $this->request->getPost("blank_layout_selected");
        $blankLayoutName = null;
        
        if ($BlayoutImg && $BlayoutImg->isValid() && !$BlayoutImg->hasMoved()) {
            $blankLayoutName = "blank_layout_" . time() . "." . $BlayoutImg->getExtension();
            $BlayoutImg->move($uploadPath, $blankLayoutName);
        } elseif ($blankLayoutSelected) {
            $parsedPath = parse_url($blankLayoutSelected, PHP_URL_PATH); // contoh: /uploads/dcp/nama_file.png
            $sourcePath = FCPATH . ltrim($parsedPath, '/'); // hilangkan '/' depan
        
            if (file_exists($sourcePath)) {
                $blankLayoutName = "blank_layout_" . time() . "_" . basename($sourcePath);
                copy($sourcePath, $uploadPath . $blankLayoutName);
            }
        }
        
        // === Process Layout ===
        $processLayout = $this->request->getFile("process_layout_img");
        $processLayoutSelected = $this->request->getPost("process_layout_selected");
        $processLayoutName = null;
   
        if ($processLayout && $processLayout->isValid() && !$processLayout->hasMoved()) {
            $processLayoutName = "process_layout_" . time() . "." . $processLayout->getExtension();
            $processLayout->move($uploadPath, $processLayoutName);
        } 
       else if ($processLayoutSelected) {
            $parsedPath = parse_url($processLayoutSelected, PHP_URL_PATH);
            $sourcePath = FCPATH . ltrim($parsedPath, '/');

            if (file_exists($sourcePath)) {
                $processLayoutName = "process_layout_" . time();
                copy($sourcePath, $uploadPath . $processLayoutName);
            }
        }
        // $dieConstrName = null;
        // $dieConstrSelected = $this->request->getPost('die_cons_selected')[$index] ?? null;

        // if (isset($dcFiles[$index]) && $dcFiles[$index]->isValid() && !$dcFiles[$index]->hasMoved()) {
        //     $dieConstrName = "die_constr_" . time() . "_$index." . $dcFiles[$index]->getExtension();
        //     $dcFiles[$index]->move($uploadPath, $dieConstrName);
        // } elseif ($dieConstrSelected) {
        //     $parsedPath = parse_url($dieConstrSelected, PHP_URL_PATH);
        //     $sourcePath = FCPATH . ltrim($parsedPath, '/');
        //     // print_r( $sourcePath);
        //     // if (file_exists($sourcePath)) {
               
        //     $parsedPath = parse_url($dieConstrSelected, PHP_URL_PATH);

        //     // Decode URL-encoded path
        //     $sourcePath = FCPATH . urldecode(ltrim($parsedPath, '/')); // Dekode URL-encoded path
            
        //     // Pastikan file tersebut ada
        //     if (file_exists($sourcePath)) {
        //         $dieConstrName = "die_constr_" . time() . "_$index." . pathinfo($sourcePath, PATHINFO_EXTENSION);
        //         copy($sourcePath, $uploadPath . $dieConstrName);
        //     } else {
        //         // Jika file tidak ditemukan, beri pesan kesalahan
        //         echo "File tidak ditemukan: $sourcePath<br>";
        //     }
            
        //     // }
        // }
          
        $mainData = [
            'cust' => $this->request->getPost('cust'),
            'model' => $this->request->getPost('model'),
            'receive' => $this->request->getPost('receive'),
            'part_no' => $this->request->getPost('part_no'),
            'part_name' => $this->request->getPost('part_name'),
            'panjang' => $this->request->getPost('panjang'),
            'lebar' => $this->request->getPost('lebar'),
            'cf' => $this->request->getPost('cf'),
            'material' => $this->request->getPost('material'),
            'tonasi' => $this->request->getPost('tonasi'),
            'length' => $this->request->getPost('length'),
            'width' => $this->request->getPost('width'),
            'boq' => $this->request->getPost('boq'),
            'blank' => $this->request->getPost('blank'),
            'panel' => $this->request->getPost('panel'),
            'scrap' => $this->request->getPost('scrap'),
            'total_dies' => $this->request->getPost('total_dies'),
            'total_mp' => $this->request->getPost('total_mp'),
            'doc_level' => $this->request->getPost('doc_level'),
            'total_stroke' => $this->request->getPost('total_stroke'),
            'blank_layout' => $blankLayoutName,
            'process_layout' => $processLayoutName,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session()->get('user_id'),
            'status' => 1,
        ];


         $ppsId = $this->ppsModel->insert($mainData);

        $diesData = [];
        $clayoutFiles = $this->request->getFileMultiple("c_layout");
        $dcFiles = $this->request->getFileMultiple("die_construction_img");
     
        foreach ($this->request->getPost('process') as $index => $process) {
            print_r( $this->request->getPost('qty')[$index] ?? null);

            $clayoutName = null;
            $clayoutSelected = $this->request->getPost('c_layout_selected')[$index] ?? null;
            
            if (isset($clayoutFiles[$index]) && $clayoutFiles[$index]->isValid() && !$clayoutFiles[$index]->hasMoved()) {
                $clayoutName = "clayout_" . time() . "_$index." . $clayoutFiles[$index]->getExtension();
                $clayoutFiles[$index]->move($uploadPath, $clayoutName);
            } elseif ($clayoutSelected) {
                $parsedPath = parse_url($clayoutSelected, PHP_URL_PATH);
                $sourcePath = FCPATH . ltrim($parsedPath, '/');
                
                if (file_exists($sourcePath)) {
                    $clayoutName = "clayout_" . time() . "_$index." . pathinfo($sourcePath, PATHINFO_EXTENSION);
                    copy($sourcePath, $uploadPath . $clayoutName);
                }
            }
            
            $dieConstrName = null;
            $dieConstrSelected = $this->request->getPost('die_cons_selected')[$index] ?? null;
    
            if (isset($dcFiles[$index]) && $dcFiles[$index]->isValid() && !$dcFiles[$index]->hasMoved()) {
                $dieConstrName = "die_constr_" . time() . "_$index." . $dcFiles[$index]->getExtension();
                $dcFiles[$index]->move($uploadPath, $dieConstrName);
            } elseif ($dieConstrSelected) {
                $parsedPath = parse_url($dieConstrSelected, PHP_URL_PATH);
                $sourcePath = FCPATH . ltrim($parsedPath, '/');
                // print_r( $sourcePath);
                // if (file_exists($sourcePath)) {
                   
                $parsedPath = parse_url($dieConstrSelected, PHP_URL_PATH);

                // Decode URL-encoded path
                $sourcePath = FCPATH . urldecode(ltrim($parsedPath, '/')); // Dekode URL-encoded path
                
                // Pastikan file tersebut ada
                if (file_exists($sourcePath)) {
                    $dieConstrName = "die_constr_" . time() . "_$index." . pathinfo($sourcePath, PATHINFO_EXTENSION);
                    copy($sourcePath, $uploadPath . $dieConstrName);
                } else {
                    // Jika file tidak ditemukan, beri pesan kesalahan
                    echo "File tidak ditemukan: $sourcePath<br>";
                }
                
                // }
            }
            
            $die_weight = $this->request->getPost('die_weight')[$index] ?? null;
            $class = null;
            if ($die_weight > 6971) {
                $class = "A";
            } else if ($die_weight > 3914 && $die_weight <= 6971) {
                $class = "B";
            } else if ($die_weight > 1961 && $die_weight <= 3914) {
                $class = "C";
            } else if ($die_weight > 848 && $die_weight <= 1961) {
                $class = "D";
            } else if ($die_weight > 397 && $die_weight <= 848) {
                $class = "E";
            } else if ($die_weight > 0 && $die_weight <= 397) {
                $class = "F";
            }

            $diesData[] = [
                'pps_id' => $ppsId,
                'process' => $process,
                'proses' => $this->request->getPost('proses')[$index] ?? null,
                'proses_gang' =>$this->request->getPost('proses_gang')[$index] ?? null,
                'process_join' => $this->request->getPost('process_join')[$index] ?? null,
                'length_mp' => $this->request->getPost('length_mp')[$index] ?? null,
                'main_pressure' => $this->request->getPost('main_pressure')[$index] ?? null,
                'qty' => $this->request->getPost('qty_dies')[$index] ?? null,
              
                'machine' => $this->request->getPost('machine')[$index] ?? null,
                'capacity' => $this->request->getPost('capacity')[$index] ?? null,
                'cushion' => $this->request->getPost('cushion')[$index] ?? null,
                'die_length' => $this->request->getPost('die_length')[$index] ?? null,
                'die_width' => $this->request->getPost('die_width')[$index] ?? null,
                'die_height' => $this->request->getPost('die_height')[$index] ?? null,
                'die_weight' => $this->request->getPost('die_weight')[$index] ?? null,
                'upper' => $this->request->getPost('upper')[$index] ?? null,
                'lower' => $this->request->getPost('lower')[$index] ?? null,
                'pad' => $this->request->getPost('pad')[$index] ?? null,
                'sliding' => $this->request->getPost('sliding')[$index] ?? null,
                'guide' => $this->request->getPost('guide')[$index] ?? null,
                'pad_lifter' => $this->request->getPost('pad_lifter')[$index] ?? null,
                'insert' => $this->request->getPost('insert')[$index] ?? null,
                'heat_treatment' => $this->request->getPost('heat_treatment')[$index] ?? null,
                'clayout_img' => $clayoutName,
                'die_construction_img' => $dieConstrName,
                'bolster_length'       => $this->request->getPost('bolster_length')[$index] ?? null,
                'bolster_width'       => $this->request->getPost('bolster_width')[$index] ?? null,
                'slide_area_length'    => $this->request->getPost('slide_area_length')[$index] ?? null,
                'slide_area_width'    => $this->request->getPost('slide_area_width')[$index] ?? null,
                'slide_stroke'    => $this->request->getPost('slide_stroke')[$index] ?? null,
                'die_height_max'       => $this->request->getPost('die_height_max')[$index] ?? null,
                'cushion_pad_length'   => $this->request->getPost('cushion_pad_length')[$index] ?? null,
                'cushion_pad_width'   => $this->request->getPost('cushion_pad_width')[$index] ?? null,
                'cushion_stroke'       => $this->request->getPost('cushion_stroke')[$index] ?? null,
                'panjang'   => $this->request->getPost('panjang')[$index] ?? null,
                'lebar'       => $this->request->getPost('lebar')[$index] ?? null,
                'class'       => $this->request->getPost('die_class')[$index] ?? null,
                'panjangProses'       => $this->request->getPost('panjangProses')[$index] ?? null,
                'diameterPie'       => $this->request->getPost('diameter')[$index] ?? null,
                'jumlahPie'       => $this->request->getPost('jumlahPie')[$index] ?? null,
                'dc_process'   =>  $this->request->getPost('die_proses_standard_die')[$index] ?? null,
                'cbPanjangProses'       => $this->request->getPost('cbPanjangProses')[$index] ?? null,
                'cbPanjangLebar'       => $this->request->getPost('cbPanjangLebar')[$index] ?? null,
                'cbPie'   =>  $this->request->getPost('cbPie')[$index] ?? null,
            ];
        }

        $this->ppsDiesModel->insertBatch($diesData);

   
        // $templatePath = FCPATH . 'uploads/template/templatePPS.xlsx';
        // if (!file_exists($templatePath)) {
        //     return redirect()->back()->with('error', 'Template Excel tidak ditemukan.');
        // }

        // $spreadsheet = IOFactory::load($templatePath);
        // $sheet = $spreadsheet->getActiveSheet();
        // $uploadPath = FCPATH . 'uploads/pps/';
        // if (!is_dir($uploadPath)) {
        //     mkdir($uploadPath, 0777, true);
        // }
        
        // $clayoutFiles = $this->request->getFileMultiple("c_layout");
        // $dcFiles = $this->request->getFileMultiple("die_construction_img");
        // $BlayoutImg = $this->request->getFile("blank_layout_img");

        // if ($BlayoutImg && $BlayoutImg->isValid() && !$BlayoutImg->hasMoved()) {
        //     $BlayoutImgNew = "blank_layout_" . time() . "." . $BlayoutImg->getExtension();
        //     $BlayoutImg->move($uploadPath, $BlayoutImgNew); 
        
        //     $drawing = new Drawing();
        //     $drawing->setName('Blank Layout Image');
        //     $drawing->setDescription('Blank Layout Image');
        //     $drawing->setPath($uploadPath . $BlayoutImgNew);
        //     $drawing->setOffsetX(10);
        //     $drawing->setOffsetY(10); 
        //     $drawing->setResizeProportional(true);
        //     $drawing->setWidth(100); 
        //     $drawing->setHeight(100); 
        //     $drawing->setCoordinates('CP4'); 
        //     $drawing->setWorksheet($sheet);
        // }
    
        // $processLayout = $this->request->getFile("process_layout_img");

        // if ($processLayout && $processLayout->isValid() && !$processLayout->hasMoved()) {
        //     $processLayoutNew = "process_layout_" . time() . "." . $processLayout->getExtension();
        //     $processLayout->move($uploadPath, $processLayoutNew);
        
        //     $drawing = new Drawing();
        //     $drawing->setName('Blank Layout Image');
        //     $drawing->setDescription('Blank Layout Image');
        //     $drawing->setPath($uploadPath . $processLayoutNew);
        //     $drawing->setOffsetX(10); 
        //     $drawing->setOffsetY(10); 
        //     $drawing->setResizeProportional(true);
        //     $drawing->setWidth(100); 
        //     $drawing->setHeight(100); 
      
        //     $drawing->setCoordinates('CI16'); 
        //     $drawing->setWorksheet($sheet);
        // }
    
        //     $sheet->setCellValue('C6', $this->request->getPost('cust'));
        //     $sheet->setCellValue('P6', $this->request->getPost('model'));

        //     $today = date('d-m-Y');
        //     $sheet->setCellValue('AQ6',  $this->request->getPost('receive'));
        //     $sheet->setCellValue('AB6',  $this->request->getPost('receive'));

        //     $sheet->setCellValue('CG5', $this->request->getPost('total_dies'));
        //     $sheet->setCellValue('CG7', $this->request->getPost('total_mp'));
        //     $sheet->setCellValue('CG9', $this->request->getPost('total_stroke'));
        //     $sheet->setCellValue('CG11', $this->request->getPost('doc_level'));
        
        //     $length = (float) $this->request->getPost('length');
        //     $width = (float) $this->request->getPost('width');
        //     $boq = (float) $this->request->getPost('boq');
        //     $sheet->setCellValue('DE68', $this->request->getPost('tonasi'));
        //     $partNo = "Part No :\n" . $this->request->getPost('part_no');
        //     $sheet->setCellValue('CG73', $partNo);
        //     $sheet->getStyle('CG73')->getFont()->setBold(true);
        //     $sheet->getStyle('CG73')->getAlignment()->setWrapText(true); 

        //     $partName = "Part Name :\n" . $this->request->getPost('part_name');
        //     $sheet->setCellValue('CU73', $partName);
        //     $sheet->getStyle('CU73')->getFont()->setBold(true); 
        //     $sheet->getStyle('CU73')->getAlignment()->setWrapText(true); 

        //     $sheet->setCellValue('CI70', $length);
        //     $sheet->setCellValue('CI71', $width);
        //     $sheet->setCellValue('CI72', $boq);
        //     $sheet->setCellValue('CO71',$this->request->getPost('blank'));
        //     $sheet->setCellValue('DB71',  $this->request->getPost('scrap'));
        //     $sheet->setCellValue('CU71',$this->request->getPost('panel'));
        
        //     $sheet->setCellValue('CO66', $this->request->getPost('cf') . " Unit");

        //     $sheet->setCellValue('CS68', $this->request->getPost('material'));
        //     $session = session(); 
        //     $sheet->setCellValue('DB79', $session->get('nickname'));
            
            
        //     $opCells      = ['C9',  'C21', 'C33', 'C45', 'C57', 'C70'];
        //     $processCells = ['C12', 'C24', 'C36', 'C48', 'C60', 'C73'];
        //     $procCells    = ['C15', 'C27', 'C39', 'C51', 'C63', 'C76'];
        //     $prosesCells  = ['C18', 'C30', 'C42', 'C54', 'C66', 'C79'];
        
        //     $cgOpProcessCells = ['CG48', 'CG51', 'CG54', 'CG57', 'CG60', 'CG63', ];
        //     $cgProcessCells = ['CG49', 'CG52', 'CG55', 'CG58', 'CG61', 'CG64'];
        
            
        
        //     $totalDies = min(6, (int) $this->request->getPost('total_dies'));
        //     $processArray = $this->request->getPost('process') ?? [];
        //     $prosesArray  = $this->request->getPost('proses') ?? [];


            
        //     $upperCells      = ['AY18', 'AY30', 'AY42', 'AY54', 'AY67', 'AY80'];
        //     $lowerCells      = ['AY19', 'AY31', 'AY43', 'AY55', 'AY68', 'AY81'];
        //     $padCells        = ['AY20', 'AY33', 'AY45', 'AY57', 'AY70', 'AY83'];
        //     $slidingCells    = ['BJ18', 'BJ30', 'BJ42', 'BJ54', 'BJ67', 'BJ80'];
        //     $guideCells      = ['BJ19', 'BJ31', 'BJ43', 'BJ55', 'BJ68', 'BJ81'];
        //     $padLifterCells  = ['BM19', 'BM32', 'BM44', 'BM56', 'BM69', 'BM82'];
        //     $insertCells     = ['BX18', 'BX30', 'BX42', 'BX54', 'BX67', 'BX80'];
            
        //     $upperTextCells      = ['AU18', 'AU32', 'AU44', 'AU56', 'AU69', 'AU82'];
        //     $lowerTextCells      = ['AU19', 'AU31', 'AU43', 'AU55', 'AU68', 'AU81'];
        //     $padTextCells       = ['AU20', 'AU33', 'AU45', 'AU57', 'AU70', 'AU83'];
        //     $slidingTextCells    = ['BE18', 'BE30', 'BE42', 'BE54', 'BE67', 'BE80'];
        //     $guideTextCells      = ['BE19', 'BE31', 'BE43', 'BE55', 'BE68', 'BE81'];
        //     $padLifterTextCells  = ['BE19', 'BE32', 'BE44', 'BE56', 'BE69', 'BE82'];
        //     $insertTextCells     = ['BT18', 'BT30', 'BT42', 'BT54', 'BT67', 'BT80'];
        //     $dieLengthCells = [];
        //     for ($i = 48; $i <= 63; $i += 3) {
        //         $dieLengthCells[] = 'CW' . $i;
        //     }

        //     $dieWeightCells = [];
        //     for ($i = 49; $i <= 64; $i += 3) {
        //         $dieWeightCells[] = 'CW' . $i;
        //     }

        //     $dieHeightCells = [];
        //     for ($i = 50; $i <= 65; $i += 3) {
        //         $dieHeightCells[] = 'CW' . $i;
        //     }

        //     $qtyDiesProcessCells = ['CL48', 'CL51', 'CL54', 'CL57', 'CL60', 'CL63'];
        //     $dieCushionCells = [];
        //     for ($i = 50; $i <= 65; $i += 3) {
        //         $dieCushionCells[] = 'CO' . $i;
        //     }
        //     $mcCells =  [];
        //     for ($i = 48; $i <= 63; $i += 3) {
        //         $mcCells[] = 'CO' . $i;
        //     }
        //     $bolsterLengthArr     = is_array($this->request->getPost('bolster_length'))     ? $this->request->getPost('bolster_length')     : [];
        //     $bolsterWeightArr     = is_array($this->request->getPost('bolster_width'))     ? $this->request->getPost('bolster_width')     : [];
        //     $slideAreaLengthArr   = is_array($this->request->getPost('slide_area_length'))   ? $this->request->getPost('slide_area_length')   : [];
        //     $slideAreaWeightArr   = is_array($this->request->getPost('slide_area_width'))   ? $this->request->getPost('slide_area_width')   : [];
        //     $dieHeightMaxArr         = is_array($this->request->getPost('die_height'))          ? $this->request->getPost('die_height')          : [];
        //     $cushionPadLengthArr  = is_array($this->request->getPost('cushion_pad_length'))  ? $this->request->getPost('cushion_pad_length')  : [];
        //     $cushionPadWeightArr  = is_array($this->request->getPost('cushion_pad_width'))  ? $this->request->getPost('cushion_pad_width')  : [];
        //     $cushionStrokeArr     = is_array($this->request->getPost('cushion_stroke'))      ? $this->request->getPost('cushion_stroke')      : [];
        //     $machineSpec          = is_array($this->request->getPost('machine'))             ? $this->request->getPost('machine')             : [];

        //     $n = count($machineSpec);
        //     $composites = [];
        //     for ($i = 0; $i < $n; $i++) {
        //         $composites[$i] = 
        //             (isset($bolsterLengthArr[$i]) ? $bolsterLengthArr[$i] : "") . "|" .
        //             (isset($bolsterWeightArr[$i]) ? $bolsterWeightArr[$i] : "") . "|" .
        //             (isset($slideAreaLengthArr[$i]) ? $slideAreaLengthArr[$i] : "") . "|" .
        //             (isset($slideAreaWeightArr[$i]) ? $slideAreaWeightArr[$i] : "") . "|" .
        //             (isset($dieHeightMaxArr[$i]) ? $dieHeightMaxArr[$i] : "") . "|" .
        //             (isset($cushionPadLengthArr[$i]) ? $cushionPadLengthArr[$i] : "") . "|" .
        //             (isset($cushionPadWeightArr[$i]) ? $cushionPadWeightArr[$i] : "") . "|" .
        //             (isset($cushionStrokeArr[$i]) ? $cushionStrokeArr[$i] : "");
        //     }

           
        //     $groups = [];
        //     $details = [];
        //     for ($i = 0; $i < $n; $i++) {
        //         $comp = $composites[$i];
        //         if (!isset($groups[$comp])) {
        //             $groups[$comp] = [];
        //             $details[$comp] = [
        //                 'bolster_length'     => isset($bolsterLengthArr[$i]) ? $bolsterLengthArr[$i] : "",
        //                 'bolster_width'     => isset($bolsterWeightArr[$i]) ? $bolsterWeightArr[$i] : "",
        //                 'slide_area_length'  => isset($slideAreaLengthArr[$i]) ? $slideAreaLengthArr[$i] : "",
        //                 'slide_area_width'  => isset($slideAreaWeightArr[$i]) ? $slideAreaWeightArr[$i] : "",
        //                 'die_height_max'         => isset($dieHeightMaxArr[$i]) ? $dieHeightMaxArr[$i] : "",
        //                 'cushion_pad_length' => isset($cushionPadLengthArr[$i]) ? $cushionPadLengthArr[$i] : "",
        //                 'cushion_pad_width' => isset($cushionPadWeightArr[$i]) ? $cushionPadWeightArr[$i] : "",
        //                 'cushion_stroke'     => isset($cushionStrokeArr[$i]) ? $cushionStrokeArr[$i] : "",
        //             ];
        //         }
        //         $groups[$comp][] = $machineSpec[$i];
        //     }

           
        //         $targetColumns = ["CQ", "CW", "DC"];
        //         $colIdx = 0;

        //         foreach ($groups as $comp => $machines) {
        //             if ($colIdx >= count($targetColumns)) {
                        
        //                 break;
        //             }
        //             $column = $targetColumns[$colIdx];
        //             $machineGroupStr = implode(" - ", $machines);
        //             $sheet->setCellValue("{$column}34", $machineGroupStr);
                    
        //             $d = $details[$comp];
                
        //             $sheet->setCellValue("{$column}35", $d['bolster_length']);
        //             $sheet->setCellValue("{$column}36", $d['bolster_width']);
        //             $sheet->setCellValue("{$column}37", $d['slide_area_length']);
        //             $sheet->setCellValue("{$column}38", $d['slide_area_width']);
        //             $sheet->setCellValue("{$column}39", $d['die_height_max']);
        //             $sheet->setCellValue("{$column}40", $d['cushion_pad_length']);
        //             $sheet->setCellValue("{$column}41", $d['cushion_pad_width']);
        //             $sheet->setCellValue("{$column}42", $d['cushion_stroke']);
                    
        //             $colIdx++;
        //         }


        //     $capacityCells =  [];
        //     for ($i = 49; $i <= 64; $i += 3) {
        //         $capacityCells[] = 'CO' . $i;
        //     }
        //     $ClayoutImageCells = ['H9', 'H21', 'H33', 'H45', 'H57', 'H70'];
        //     $DcLayoutCells = ['AT9', 'AT21', 'AT33', 'AT45', 'AT57', 'AT70'];
        //     $upperArr      = $this->request->getPost('upper') ?? [];
        //     $lowerArr      = $this->request->getPost('lower') ?? [];
        //     $padArr        = $this->request->getPost('pad') ?? [];
        //     $slidingArr    = $this->request->getPost('sliding') ?? [];
        //     $guideArr      = $this->request->getPost('guide') ?? [];
        //     $padLifterArr  = $this->request->getPost('pad_lifter') ?? [];
        //     $insertArr     = $this->request->getPost('insert') ?? [];

        //     $machines   = $this->request->getPost('machine') ?? [];
        //     $capacities = $this->request->getPost('capacity') ?? [];
        //     $cushions   = $this->request->getPost('cushion') ?? [];
        //     $maxWidth = 140;
        //     $maxHeight = 120;
        //     $padding = 10;

        //     for ($i = 0; $i < $totalDies; $i++) {
        //         $sheet->setCellValue($processCells[$i], $processArray[$i] ?? '');
        //         $sheet->setCellValue($prosesCells[$i], $prosesArray[$i] ?? '');
        //         $sheet->setCellValue($opCells[$i], 'OP');
        //         if (isset($qtyDiesProcessCells[$i])) {
        //             $sheet->setCellValue($qtyDiesProcessCells[$i], 1);
        //         }

        //         if (isset($procCells[$i])) {
        //             $sheet->setCellValue($procCells[$i], 'PROC.');
        //         }

        //         $sheet->setCellValue($cgOpProcessCells[$i], $processArray[$i] ?? '');
        //         $sheet->setCellValue(
        //             $cgOpProcessCells[$i] ?? '', 
        //             'OP ' . ($processArray[$i] ?? '')
        //         );
                
        //         $sheet->setCellValue($cgProcessCells[$i],  ($prosesArray[$i] ?? ''));
                
            
        //         $sheet->setCellValue($mcCells[$i], $machines[$i]); 
        
        
        //         $sheet->setCellValue($dieCushionCells[$i], $cushions[$i]);
            
        //         $sheet->setCellValue($capacityCells[$i], $capacities[$i]); 
            
            
        //         if (isset($upperCells[$i])) {
        //             $sheet->setCellValue($upperCells[$i], $upperArr[$i] ?? '');
        //         }
        
        //         if (isset($lowerCells[$i])) {
        //             $sheet->setCellValue($lowerCells[$i], $lowerArr[$i] ?? '');
        //         }
            
        //         if (isset($padCells[$i])) {
        //             $sheet->setCellValue($padCells[$i], $padArr[$i] ?? '');
        //         }
            
        //         if (isset($slidingCells[$i])) {
        //             $sheet->setCellValue($slidingCells[$i], $slidingArr[$i] ?? '');
        //         }
            
        //         if (isset($guideCells[$i])) {
        //             $sheet->setCellValue($guideCells[$i], $guideArr[$i] ?? '');
        //         }
            
        //         if (isset($padLifterCells[$i])) {
        //             $sheet->setCellValue($padLifterCells[$i], $padLifterArr[$i] ?? '');
        //         }
            
        //         if (isset($insertCells[$i])) {
        //             $sheet->setCellValue($insertCells[$i], $insertArr[$i] ?? '');
        //         }

        //         if (isset($upperTextCells[$i])) {
        //             $sheet->setCellValue($upperTextCells[$i], 'UPPER');
        //         }
            
        //         if (isset($lowerTextCells[$i])) {
        //             $sheet->setCellValue($lowerTextCells[$i], 'LOWER');
        //         }
            
        //         if (isset($padTextCells[$i])) {
        //             $sheet->setCellValue($padTextCells[$i], 'PAD');
        //         }
            
        //         if (isset($slidingTextCells[$i])) {
        //             $sheet->setCellValue($slidingTextCells[$i], 'SLIDING');
        //         }
            
        //         if (isset($guideTextCells[$i])) {
        //             $sheet->setCellValue($guideTextCells[$i], 'GUIDE');
        //         }
            
        //         if (isset($padLifterTextCells[$i])) {
        //             $sheet->setCellValue($padLifterTextCells[$i], 'PAD LIFTER');
        //         }
            
        //         if (isset($insertTextCells[$i])) {
        //             $sheet->setCellValue($insertTextCells[$i], 'INSERT');
        //         }
        //         if (isset($clayoutFiles[$i]) && $clayoutFiles[$i]->isValid() && !$clayoutFiles[$i]->hasMoved()) {
        //             $clayoutNewName = "clayout_" . time() . "_" . $i . "." . $clayoutFiles[$i]->getExtension();
        //             $clayoutFiles[$i]->move($uploadPath, $clayoutNewName);
            
        //             $drawing = new Drawing();
        //             $drawing->setName('Clayout Image');
        //             $drawing->setDescription('Clayout Image');
        //             $drawing->setPath($uploadPath . $clayoutNewName);
        //             $drawing->setOffsetX($padding);
        //             $drawing->setOffsetY($padding); 
        //             $drawing->setResizeProportional(true);
        //             $drawing->setWidth($maxWidth);
        //             $drawing->setHeight($maxHeight);
        //             $drawing->setCoordinates($ClayoutImageCells[$i]);
        //             $drawing->setWorksheet($sheet);
        //         }
            
        //         if (isset($dcFiles[$i]) && $dcFiles[$i]->isValid() && !$dcFiles[$i]->hasMoved()) {
        //             $dcNewName = "die_construction_" . time() . "_" . $i . "." . $dcFiles[$i]->getExtension();
        //             $dcFiles[$i]->move($uploadPath, $dcNewName);
            
        //             $drawing = new Drawing();
        //             $drawing->setName('Die Construction Image');
        //             $drawing->setDescription('Die Construction Image');
        //             $drawing->setPath($uploadPath . $dcNewName);
        //             $drawing->setOffsetX($padding); 
        //             $drawing->setOffsetY($padding); 
        //             $drawing->setResizeProportional(true);
        //             $drawing->setWidth($maxWidth);
        //             $drawing->setHeight($maxHeight);
        //             $drawing->setCoordinates($DcLayoutCells[$i]);
        //             $drawing->setWorksheet($sheet);
        //         }
        //     }

        //     $cuCells = [];
        //     $dieSizeCell = [];
        //     for ($i = 48; $i <= 65; $i++) {
        //         $cuCells[] = "CU{$i}";
        //         $dieSizeCell[] = "CW{$i}";
        //     }
            
        //     $diesWeightCells = [];
        //     for ($i = 48; $i <= 63; $i += 3) {
        //         $diesWeightCells[] = "DB{$i}";
        //     }
            
        //     $mainPressCells = ['DB50', 'DB53', 'DB56', 'DB59', 'DB62', 'DB65'];
        //     $dieLengthArray = $this->request->getPost('die_length') ?? [];
        //     $dieWidthArray  = $this->request->getPost('die_width') ?? [];
        
        //     $dieHeightArray = $this->request->getPost('die_height') ?? [];
        //     $dieWeightArray = $this->request->getPost('die_weight') ?? [];
        //     $mainPressureArray = $this->request->getPost('main_pressure') ?? [];

        //     $class = []; 
        //     $dieLenghtStandard = [];
        //     $dieWidthStandard = [];

            
        //     $values = ['L', 'W', 'H'];
        //     $totalDies = count($dieHeightArray); 
            
        //     for ($j = 0; $j < $totalDies; $j++) {
        //         for ($i = 0; $i < 3; $i++) {
        //             if (isset($cuCells[$i + ($j * 3)])) {
        //                 $sheet->setCellValue($cuCells[$i + ($j * 3)], $values[$i]);
        //             }
            
        //             if (isset($dieSizeCell[$i + ($j * 3)])) {
        //                 $value = '';
        //                 if ($i == 0 && isset($dieLengthArray[$j])) {
        //                     $value = $dieLengthArray[$j]; 
        //                 } elseif ($i == 1 && isset($dieWeightArray[$j])) {
        //                     $value = $dieWeightArray[$j]; 
        //                 } elseif ($i == 2 && isset($dieHeightArray[$j])) {
        //                     $value = $dieHeightArray[$j];
        //                 }
        //                 $sheet->setCellValue($dieSizeCell[$i + ($j * 3)], $value);
        //             }
        //         }
            
            
        //         if (isset($diesWeightCells[$j]) && isset($dieWeightArray[$j])) {
        //             $sheet->setCellValue($diesWeightCells[$j], $dieWeightArray[$j]);
        //         }
            
        //         if (isset($mainPressCells[$j]) && isset($mainPressureArray[$j])) {
        //             $sheet->setCellValue($mainPressCells[$j], $mainPressureArray[$j]);
        //         }
           
        //     }

        //     $partNo = $this->request->getPost('part_no');
        //     $partName = $this->request->getPost('part_name');
            

            
        //     $fileName = "PPS_" . $partNo . "_" . $partName . ".xlsx";
            
        //     $newFilePath = WRITEPATH . 'uploads/' . $fileName;
        //     $writer = new Xlsx($spreadsheet);
        //     $writer->save($newFilePath);
            
        //     return $this->response->download($newFilePath, null)->setFileName($fileName);
        return redirect()->to(site_url('pps'))->with('success', 'Data berhasil diupdate');
   
    }

    // public function generateExcel($ppsId)
    // {
    //     // Inisialisasi model untuk mengambil data PPS dan PPS Dies
    //     $ppsModel = new PpsModel();
    //     $ppsDiesModel = new PpsDiesModel();

    //     // Ambil data PPS utama berdasarkan ID
    //     $ppsData = $ppsModel->find($ppsId);
    //     if (!$ppsData) {
    //         // Jika data PPS tidak ditemukan, kembalikan error atau lakukan handling yang sesuai
    //         return redirect()->back()->with('error', 'Data PPS tidak ditemukan.');
    //     }

    //     // Ambil data PPS Dies berdasarkan pps_id
    //     $diesData = $ppsDiesModel->getDiesByPps($ppsId);

    //     // Tentukan path template Excel yang akan digunakan
    //     $templatePath = FCPATH . 'uploads/template/templatePPS.xlsx';
    //     if (!file_exists($templatePath)) {
    //         return redirect()->back()->with('error', 'Template Excel tidak ditemukan.');
    //     }

    //     // Load file template Excel
    //     $spreadsheet = IOFactory::load($templatePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Tentukan folder untuk menyimpan file hasil generate
    //     $uploadPath = FCPATH . 'uploads/pps/';
    //     if (!is_dir($uploadPath)) {
    //         // Membuat folder upload jika belum ada
    //         mkdir($uploadPath, 0777, true);
    //     }

    //     // --- Pengisian Data PPS Utama ---
    //     // Mengisi data PPS utama dari $ppsData
    //     $sheet->setCellValue('C6', $ppsData['cust']);
    //     $sheet->setCellValue('P6', $ppsData['model']);
    //     $sheet->setCellValue('AQ6', $ppsData['receive']);
    //     $sheet->setCellValue('CG7', $ppsData['total_mp']); // Pastikan field sesuai dengan kebutuhan
    //     $sheet->setCellValue('CG11', $ppsData['doc_level']);
    //     $sheet->setCellValue('CG9', $ppsData('total_stroke'));
    //     $sheet->setCellValue('CG5', $ppsData('total_dies'));
            
    //     // Konversi nilai numerik
    //     $length = (float)$ppsData['length'];
    //     $width  = (float)$ppsData['width'];
    //     $boq    = (float)$ppsData['boq'];

    //     // Menuliskan Part No dan Part Name
    //     $partNo = "Part No :\n" . $ppsData['part_no'];
    //     $sheet->setCellValue('CG73', $partNo);
    //     $sheet->getStyle('CG73')->getFont()->setBold(true);
    //     $sheet->getStyle('CG73')->getAlignment()->setWrapText(true);

    //     $partName = "Part Name :\n" . $ppsData['part_name'];
    //     $sheet->setCellValue('CU73', $partName);
    //     $sheet->getStyle('CU73')->getFont()->setBold(true);
    //     $sheet->getStyle('CU73')->getAlignment()->setWrapText(true);

    //     $sheet->setCellValue('CI70', $length);
    //     $sheet->setCellValue('CI71', $width);
    //     $sheet->setCellValue('CI72', $boq);
    //     $sheet->setCellValue('CO71', $ppsData['blank']);
    //     $sheet->setCellValue('DB71', $ppsData['scrap']);
    //     $sheet->setCellValue('CU71', $ppsData['panel']);
    //     $sheet->setCellValue('CO66', $ppsData['cf'] . " Unit");
    //     $sheet->setCellValue('CS68', $ppsData['material']);
    //     $sheet->setCellValue('DB79', $session->get('nickname'));
            
    //     // Jika terdapat field gambar untuk blank_layout dan process_layout, tampilkan di Excel
    //     if (!empty($ppsData['blank_layout'])) {
    //         $blankLayoutFile = $uploadPath . $ppsData['blank_layout'];
    //         if (file_exists($blankLayoutFile)) {
    //             $drawing = new Drawing();
    //             $drawing->setName('Blank Layout Image');
    //             $drawing->setDescription('Blank Layout Image');
    //             $drawing->setPath($blankLayoutFile);
    //             $drawing->setOffsetX(10);
    //             $drawing->setOffsetY(10);
    //             $drawing->setResizeProportional(true);
    //             $drawing->setWidth(100);
    //             $drawing->setHeight(100);
    //             $drawing->setCoordinates('CP4');
    //             $drawing->setWorksheet($sheet);
    //         }
    //     }
        
    //     if (!empty($ppsData['process_layout'])) {
    //         $processLayoutFile = $uploadPath . $ppsData['process_layout'];
    //         if (file_exists($processLayoutFile)) {
    //             $drawing = new Drawing();
    //             $drawing->setName('Process Layout Image');
    //             $drawing->setDescription('Process Layout Image');
    //             $drawing->setPath($processLayoutFile);
    //             $drawing->setOffsetX(10);
    //             $drawing->setOffsetY(10);
    //             $drawing->setResizeProportional(true);
    //             $drawing->setWidth(100);
    //             $drawing->setHeight(100);
    //             $drawing->setCoordinates('CI16');
    //             $drawing->setWorksheet($sheet);
    //         }
    //     }

    //     // --- Pengisian Data PPS Dies ---
    //     // Contoh cell target untuk beberapa field (sesuaikan dengan layout Excel template)
    //     $opCells      = ['C9',  'C21', 'C33', 'C45', 'C57', 'C70'];
    //     $processCells = ['C12', 'C24', 'C36', 'C48', 'C60', 'C73'];
    //     $procCells    = ['C15', 'C27', 'C39', 'C51', 'C63', 'C76'];
    //     $prosesCells  = ['C18', 'C30', 'C42', 'C54', 'C66', 'C79'];
    //     $cgOpProcessCells = ['CG48', 'CG51', 'CG54', 'CG57', 'CG60', 'CG63'];
    //     $cgProcessCells   = ['CG49', 'CG52', 'CG55', 'CG58', 'CG61', 'CG64'];

    //     // Tentukan cell untuk machine; contoh menggunakan range CO48, CO51, dst.
    //     $mcCells = [];
    //     for ($i = 48; $i <= 63; $i += 3) {
    //         $mcCells[] = 'CO' . $i;
    //     }

    //     // Misal, kita mengisi data dies secara berurutan (sesuaikan jumlah dies dengan cell target)
    //     $padding = 10;
    //     $maxWidth = 140;
    //     $maxHeight = 120;
    //     $ClayoutImageCells = ['H9', 'H21', 'H33', 'H45', 'H57', 'H70'];
    //     $DcLayoutCells     = ['AT9', 'AT21', 'AT33', 'AT45', 'AT57', 'AT70'];

    //     // Pengisian data PPS Dies dengan perulangan, sesuaikan indeks cell jika diperlukan
    //     foreach ($diesData as $index => $die) {
    //         // Batasi pengisian data jika jumlah dies melebihi jumlah cell yang sudah didefinisikan
    //         if ($index >= count($processCells)) {
    //             break;
    //         }

    //         // Pengisian cell proses dan machine
    //         $sheet->setCellValue($processCells[$index], $die['process']);
    //         $sheet->setCellValue($cgOpProcessCells[$index], 'OP ' . $die['process']);
    //         $sheet->setCellValue($cgProcessCells[$index], $die['proses']);
    //         $sheet->setCellValue($opCells[$index], 'OP');
    //         if (isset($mcCells[$index])) {
    //             $sheet->setCellValue($mcCells[$index], $die['machine']);
    //         }

    //         // Pengisian data dimensi die (contoh: die_length, die_weight, die_height)
    //         // Penyesuaian cell index dapat dilakukan sesuai kebutuhan template
    //         $sheet->setCellValue('CI' . (70 + $index), $die['die_length']);
    //         $sheet->setCellValue('CI' . (71 + $index), $die['die_weight']);
    //         $sheet->setCellValue('CI' . (72 + $index), $die['die_height']);

    //         // Jika terdapat file gambar untuk clayout_img dan die_construction_img, tampilkan di Excel
    //         if (!empty($die['clayout_img'])) {
    //             $clayoutFile = $uploadPath . $die['clayout_img'];
    //             if (file_exists($clayoutFile)) {
    //                 $drawing = new Drawing();
    //                 $drawing->setName('Clayout Image');
    //                 $drawing->setDescription('Clayout Image');
    //                 $drawing->setPath($clayoutFile);
    //                 $drawing->setOffsetX($padding);
    //                 $drawing->setOffsetY($padding);
    //                 $drawing->setResizeProportional(true);
    //                 $drawing->setWidth($maxWidth);
    //                 $drawing->setHeight($maxHeight);
    //                 $drawing->setCoordinates($ClayoutImageCells[$index]);
    //                 $drawing->setWorksheet($sheet);
    //             }
    //         }
    //         if (!empty($die['die_construction_img'])) {
    //             $dieConFile = $uploadPath . $die['die_construction_img'];
    //             if (file_exists($dieConFile)) {
    //                 $drawing = new Drawing();
    //                 $drawing->setName('Die Construction Image');
    //                 $drawing->setDescription('Die Construction Image');
    //                 $drawing->setPath($dieConFile);
    //                 $drawing->setOffsetX($padding);
    //                 $drawing->setOffsetY($padding);
    //                 $drawing->setResizeProportional(true);
    //                 $drawing->setWidth($maxWidth);
    //                 $drawing->setHeight($maxHeight);
    //                 $drawing->setCoordinates($DcLayoutCells[$index]);
    //                 $drawing->setWorksheet($sheet);
    //             }
    //         }
    //     }

    //     // --- Pengisian Data Tambahan (jika ada) ---
    //     // Bagian selanjutnya dapat diadaptasi sesuai kebutuhan, misal mengisi data untuk bolster, slide, cushion, dll.
    //     // Kode di bawah ini dapat dikembangkan lebih lanjut berdasarkan struktur data PPS Dies.

    //     // --- Simpan File Excel yang Telah Digenerate ---
    //     $newFilePath = WRITEPATH . 'uploads/generated_' . time() . '.xlsx';
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save($newFilePath);

    //     // Mengembalikan file hasil generate untuk didownload
    //     return $this->response->download($newFilePath, null)->setFileName('generated.xlsx');
    // }

    public function generateExcel($ppsId)
    {
        $db = \Config\Database::connect();

        // Load models
        $ppsModel = new \App\Models\PpsModel();
        $ppsDiesModel = new \App\Models\PpsDiesModel();

        // Get PPS data
        $ppsData = $ppsModel
        ->select('pps.*, users.nickname as creator_nickname')
        ->join('users', 'pps.created_by = users.id')
        ->where('pps.id', $ppsId)
        ->first();
    
        if (!$ppsData) {
            return redirect()->back()->with('error', 'Data PPS tidak ditemukan.');
        }

        $ppsDiesData = $ppsDiesModel->getDiesByPps($ppsId);

        $templatePath = FCPATH . 'uploads/template/templatePPS.xlsx';
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getSheetByName('Sheet1');

        $uploadPath = FCPATH . 'uploads/pps/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
for ($row = 2; $row <= 83; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(15); // Sesuaikan nilai 15 dengan height template asli
}
        $sheet->setCellValue('DE68',  $ppsData['tonasi']);
        $sheet->setCellValue('C6', $ppsData['cust']);
        $sheet->setCellValue('P6', $ppsData['model']);
        $sheet->setCellValue('AB6', date('d/m/Y', strtotime($ppsData['receive'])));

        $formattedDate = date('d/m/Y', strtotime($ppsData['created_at']));
        $sheet->setCellValue('AQ6', $formattedDate);
        
        // $sheet->setCellValue('CG5', $ppsData['total_dies']);
            $sheet->setCellValue('CG7', $ppsData['total_mp'] . " M/P");
            $sheet->setCellValue('CG9', $ppsData['total_stroke'] . " STROKE");

        $sheet->setCellValue('CG11', $ppsData['doc_level']);
        $sheet->setCellValue('CI70', $ppsData['length']);
        $sheet->setCellValue('CI71', $ppsData['width']);
        $sheet->setCellValue('CI72', $ppsData['boq']);
        $sheet->setCellValue('CO71', $ppsData['blank']);
        $sheet->setCellValue('DB71', $ppsData['scrap']);
        $sheet->setCellValue('CU71', $ppsData['panel']);
        $sheet->setCellValue('CG65', "C/F");
        $sheet->setCellValue('CO66', $ppsData['cf'] . " Unit");
        $sheet->setCellValue('CS68', $ppsData['material']);
        $sheet->setCellValue('CG67', "LOCATION");
        $sheet->setCellValue('CU67', "MAJ TAMBUN");
        $session = session(); 
        $sheet->setCellValue('DB79', $ppsData['creator_nickname']);

        $partNo = "Part No :\n" . $ppsData['part_no'];
        $sheet->setCellValue('CG73', $partNo);
        $sheet->getStyle('CG73')->getFont()->setBold(true);
        $sheet->getStyle('CG73')->getAlignment()->setWrapText(true);

        $partName = "Part Name :\n" . $ppsData['part_name'];
        $sheet->setCellValue('CU73', $partName);
        $sheet->getStyle('CU73')->getFont()->setBold(true);
        $sheet->getStyle('CU73')->getAlignment()->setWrapText(true);

        // Set images if available
        if ($ppsData['blank_layout']) {
            $drawing = new Drawing();
            $drawing->setName('Blank Layout Image');
            $drawing->setDescription('Blank Layout Image');
            $drawing->setPath(FCPATH . 'uploads/pps/' . $ppsData['blank_layout']);
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(10);
            $drawing->setResizeProportional(false);
            $drawing->setWidth(200);
            $drawing->setHeight(300);
            $drawing->setCoordinates('CH16');
            $drawing->setWorksheet($sheet);
        }

        if ($ppsData['process_layout']) {
            $drawing = new Drawing();
            $drawing->setName('Process Layout Image');
            $drawing->setDescription('Process Layout Image');
            $drawing->setPath(FCPATH . 'uploads/pps/' . $ppsData['process_layout']);
            $drawing->setOffsetX(20);
            $drawing->setOffsetY(10);
            $drawing->setResizeProportional(false);
            $drawing->setWidth(130);
            $drawing->setHeight(180);
            $drawing->setCoordinates('CQ4');
            $drawing->setWorksheet($sheet);
        }

        // Set values from PPS Dies data
        $totalDies = count($ppsDiesData);
        $sheet->setCellValue('CG5', $totalDies . " SET DIES");
        $opCells = ['C9', 'C21', 'C33', 'C45', 'C57', 'C70'];
        $processCells = ['C12', 'C24', 'C36', 'C48', 'C60', 'C73'];
        $procCells = ['C15', 'C27', 'C39', 'C51', 'C63', 'C76'];
        $prosesCells = ['C18', 'C30', 'C42', 'C54', 'C66', 'C79'];
        $cgOpProcessCells = ['CG48', 'CG51', 'CG54', 'CG57', 'CG60', 'CG63'];
        $cgProcessCells = ['CG49', 'CG52', 'CG55', 'CG58', 'CG61', 'CG64'];
        $qtyDiesProcessCells = ['CL48', 'CL51', 'CL54', 'CL57', 'CL60', 'CL63'];

        $lengthCells = ['CU48', 'CU51', 'CU54', 'CU57', 'CU60', 'CU63'];
        $widthCells = ['CU49', 'CU52', 'CU55', 'CU58', 'CU61', 'CU64'];
        $heightCells = ['CU50', 'CU53', 'CU56', 'CU59', 'CU62', 'CU65'];
        $mcCells = [];
        for ($i = 48; $i <= 63; $i += 3) {
            $mcCells[] = 'CO' . $i;
        }
        $capacityCells = [];
        for ($i = 49; $i <= 64; $i += 3) {
            $capacityCells[] = 'CO' . $i;
        }
        $dieCushionCells = [];
        for ($i = 50; $i <= 65; $i += 3) {
            $dieCushionCells[] = 'CO' . $i;
        }

        $upperTextCells      = ['AU18', 'AU30', 'AU42', 'AU54', 'AU67', 'AU80'];
        $lowerTextCells      = ['AU19', 'AU31', 'AU43', 'AU55', 'AU68', 'AU81'];
        $padTextCells       = ['AU20', 'AU32', 'AU44', 'AU56', 'AU69', 'AU82'];
        $slidingTextCells    = ['BE18', 'BE30', 'BE42', 'BE54', 'BE67', 'BE80'];
        $guideTextCells      = ['BE19', 'BE31', 'BE43', 'BE55', 'BE68', 'BE81'];
        $padLifterTextCells  = ['BE20', 'BE32', 'BE44', 'BE56', 'BE69', 'BE82'];
        $insertTextCells     = ['BT18', 'BT30', 'BT42', 'BT54', 'BT67', 'BT80'];

        
        $bolsterLengthArr = [];
        $bolsterWeightArr = [];
        $slideAreaLengthArr = [];
        $slideAreaWeightArr = [];
        $dieHeightMaxArr = [];
        $cushionPadLengthArr = [];
        $cushionPadWeightArr = [];
        $cushionStrokeArr = [];
        $machineSpec = [];

        // Isi array dengan data dari database
        foreach ($ppsDiesData as $die) {
            $bolsterLengthArr[] = $die['bolster_length'];
            $bolsterWeightArr[] = $die['bolster_width'];
            $slideAreaLengthArr[] = $die['slide_area_length'];
            $slideAreaWeightArr[] = $die['slide_area_width'];
            $dieHeightMaxArr[] = $die['die_height_max'];
            $cushionPadLengthArr[] = $die['cushion_pad_length'];
            $cushionPadWeightArr[] = $die['cushion_pad_width'];
            $cushionStrokeArr[] = $die['cushion_stroke'];
            $machineSpec[] = $die['machine'];
            $slideStrokeArr[] = $die['slide_stroke'];
          
        }

        $targetColumns = ["CQ", "CU", "CZ", "DE"];
        $j = 0;
        if($totalDies > 6){
            $maxLoop = 6;
        }else{
            $maxLoop = $totalDies;
        }
        for ($i = 0; $i < $maxLoop; $i++) {
            $dieData = $ppsDiesData[$i];

            $column = $targetColumns[$j] ?? end($targetColumns);
        
            // Cek apakah ada baris selanjutnya untuk dibandingkan
            if (
                ($i < $maxLoop - 1) &&
                ($bolsterLengthArr[$i]    ?? '') == ($bolsterLengthArr[$i+1]    ?? '') &&
                ($bolsterWeightArr[$i]    ?? '') == ($bolsterWeightArr[$i+1]    ?? '') &&
                ($slideAreaLengthArr[$i]  ?? '') == ($slideAreaLengthArr[$i+1]  ?? '') &&
                ($slideAreaWeightArr[$i]  ?? '') == ($slideAreaWeightArr[$i+1]  ?? '') &&
                ($dieHeightMaxArr[$i]     ?? '') == ($dieHeightMaxArr[$i+1]     ?? '') &&
                ($cushionPadLengthArr[$i] ?? '') == ($cushionPadLengthArr[$i+1] ?? '') &&
                ($cushionPadWeightArr[$i] ?? '') == ($cushionPadWeightArr[$i+1] ?? '') &&
                ($slideStrokeArr[$i] ?? '') == ($slideStrokeArr[$i+1] ?? '') &&
                ($cushionStrokeArr[$i]    ?? '') == ($cushionStrokeArr[$i+1]    ?? '')
            ) {
                // Jika data baris ke-i dan ke-(i+1) identik, gabungkan machineSpec
                $mergedMachine = ($machineSpec[$i] ?? '') . ', ' . ($machineSpec[$i+1] ?? '');
                
                $sheet->setCellValue("{$column}34", $mergedMachine);
                $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
                $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
                $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
                $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
                $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
                $sheet->setCellValue("{$column}40", $slideStrokeArr[$i]     ?? '');
                $sheet->setCellValue("{$column}41", $cushionPadLengthArr[$i] ?? '');
                $sheet->setCellValue("{$column}42", $cushionPadWeightArr[$i] ?? '');
                $sheet->setCellValue("{$column}43", $cushionStrokeArr[$i]    ?? '');
                
                // Lewati baris berikutnya karena sudah digabung
                $i++;
                $j++;
            } else {
                // Jika tidak ada pasangan (atau baris berikutnya berbeda), tuliskan data baris ke-i secara individual
                $sheet->setCellValue("{$column}34", $machineSpec[$i]         ?? '');
                $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
                $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
                $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
                $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
                $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
                $sheet->setCellValue("{$column}40", $slideStrokeArr[$i]     ?? '');
                $sheet->setCellValue("{$column}41", $cushionPadLengthArr[$i] ?? '');
                $sheet->setCellValue("{$column}42", $cushionPadWeightArr[$i] ?? '');
                $sheet->setCellValue("{$column}43", $cushionStrokeArr[$i]    ?? '');
                $j++;
            }
        }
            for ($i = 0; $i < $maxLoop; $i++) {
                $dieData = $ppsDiesData[$i];
    
            $processValue = str_replace("OP", "", $dieData['process']);
            $processJoinValue = str_replace("OP", "", $dieData['process_join']);
            $prosesValue = str_replace("OP", "", $dieData['proses']);
            $prosesGangValue = str_replace("OP", "", $dieData['proses_gang']);
         
            $sheet->setCellValue(
                $processCells[$i],
                $processValue . ($processJoinValue != null ? ", " . $processJoinValue : "")
            );
            $sheet->setCellValue(
                $prosesCells[$i],
                $prosesValue . ($prosesGangValue != null ? ", " . $prosesGangValue : "")
            );

            $sheet->setCellValue($opCells[$i], 'OP');
            $sheet->setCellValue($procCells[$i], 'PROC.');
            $cgOpProcessValue     = str_replace("OP", "", $dieData['process']);
            $cgOpProcessJoinValue = str_replace("OP", "", $dieData['process_join']);
            $cgProcessValue       = str_replace("OP", "", $dieData['proses']);
            $cgProcessGangValue   = str_replace("OP", "", $dieData['proses_gang']);

            $sheet->setCellValue(
                $cgOpProcessCells[$i],
                $cgOpProcessValue . ($cgOpProcessJoinValue != null ? ", " . $cgOpProcessJoinValue : "")
            );
            $sheet->setCellValue(
                $cgProcessCells[$i],
                $cgProcessValue . ($cgProcessGangValue != null ? ", " . $cgProcessGangValue : "")
            );

            $sheet->setCellValue($mcCells[$i], $dieData['machine']);
            $sheet->setCellValue($capacityCells[$i], $dieData['capacity']);
            $sheet->setCellValue($dieCushionCells[$i], $dieData['cushion']);
            $sheet->setCellValue($qtyDiesProcessCells[$i], $dieData['qty']);
    
            // Set die dimensions
            $sheet->setCellValue('CW' . (48 + ($i * 3)), $dieData['die_length']);
            $sheet->setCellValue('CW' . (49 + ($i * 3)), $dieData['die_width']);
            $sheet->setCellValue('CW' . (50 + ($i * 3)), $dieData['die_height']);
            $sheet->setCellValue('DB' . (48 + ($i * 3)), $dieData['die_weight']);
            $sheet->setCellValue('DB' . (50 + ($i * 3)), $dieData['main_pressure']);
       
            // Set other die-specific data
            $sheet->setCellValue('AY' . (18 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['upper']);
            $sheet->setCellValue('AY' . (19 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['lower']);
            $sheet->setCellValue('AY' . (20 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['pad']);
            $sheet->setCellValue('BJ' . (18 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['sliding']);
            $sheet->setCellValue('BJ' . (19 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['guide']);
            $sheet->setCellValue('BM' . (20 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['pad_lifter']);
            $sheet->setCellValue('BX' . (18 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['insert']);
            $sheet->setCellValue('BS' . (19 + ($i * 12) + ($i > 3 ? $i - 3 : 0)), $dieData['heat_treatment']);
            
      

            if (isset($lengthCells[$i])) {
                $sheet->setCellValue($lengthCells[$i], 'L');
            }
            
            if (isset($widthCells[$i])) {
                $sheet->setCellValue($widthCells[$i], 'W');
            }
            
            if (isset($heightCells[$i])) {
                $sheet->setCellValue($heightCells[$i], 'H');
            }
            if (isset($upperTextCells[$i])) {
                $sheet->setCellValue($upperTextCells[$i], 'UPPER');
            
            }
            if (isset($lowerTextCells[$i])) {
                $sheet->setCellValue($lowerTextCells[$i], 'LOWER');
            }
        
            if (isset($padTextCells[$i])) {
                $sheet->setCellValue($padTextCells[$i], 'PAD');
            }
        
            if (isset($slidingTextCells[$i])) {
                $sheet->setCellValue($slidingTextCells[$i], 'SLIDING');
            }
        
            if (isset($guideTextCells[$i])) {
                $sheet->setCellValue($guideTextCells[$i], 'GUIDE');
            }
        
            if (isset($padLifterTextCells[$i])) {
                $sheet->setCellValue($padLifterTextCells[$i], 'PAD LIFTER');
            }
        
            if (isset($insertTextCells[$i])) {
                $sheet->setCellValue($insertTextCells[$i], 'INSERT');
            }
        
          // Array posisi koordinat
            $rowClayoutImg = ['H9', 'H21', 'H33', 'H45', 'H57', 'H70'];
            $rowDcImg = ['AT9', 'AT21', 'AT33', 'AT45', 'AT57', 'AT70'];

            // CLayout image
            if ($dieData['clayout_img']) {
                $drawing = new Drawing();
                $drawing->setName('Clayout Image');
                $drawing->setDescription('Clayout Image');
                $drawing->setPath(FCPATH . 'uploads/pps/' . $dieData['clayout_img']);
                $drawing->setOffsetX(40);
                $drawing->setOffsetY(20);
                $drawing->setResizeProportional(false);
                $drawing->setWidth(320);
                $drawing->setHeight(190);
                $drawing->setCoordinates($rowClayoutImg[$i] ?? 'H9');
                $drawing->setWorksheet($sheet);
            }

            // Die Construction image
            if ($dieData['die_construction_img']) {
                $drawing = new Drawing();
                $drawing->setName('Die Construction Image');
                $drawing->setDescription('Die Construction Image');
                $drawing->setPath(FCPATH . 'uploads/pps/' . $dieData['die_construction_img']);
                $drawing->setOffsetX(30);
                $drawing->setOffsetY(20);
                $drawing->setResizeProportional(false);
                $drawing->setWidth(340);
                $drawing->setHeight(145);
                // Ambil dari array berdasarkan index $i
                $drawing->setCoordinates($rowDcImg[$i] ?? 'AT9');
                $drawing->setWorksheet($sheet);
            }
    
        }
        // foreach ($spreadsheet->getAllSheets() as $sheet) {
       
        //     $sheet->getProtection()->setSheet(true);
        //     $sheet->getProtection()->setPassword('rnd');
            
        //     $sheet->getProtection()->setSelectLockedCells(true);
        //     $sheet->getProtection()->setSelectUnlockedCells(true);
        // }
        // Save the generated Excel file

        if($totalDies >6){
            
            $sheet = $spreadsheet->getSheetByName('Sheet2');

            $uploadPath = FCPATH . 'uploads/pps/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Set values from PPS data
            $sheet->setCellValue('DE68',  $ppsData['tonasi']);
            $sheet->setCellValue('C6', $ppsData['cust']);
            $sheet->setCellValue('P6', $ppsData['model']);
            $sheet->setCellValue('AB6', date('d/m/Y', strtotime($ppsData['receive'])));

            $formattedDate = date('d/m/Y', strtotime($ppsData['created_at']));
            $sheet->setCellValue('AQ6', $formattedDate);
            
            // $sheet->setCellValue('CG5', $ppsData['total_dies'] . " SET DIES");
            $sheet->setCellValue('CG7', $ppsData['total_mp'] . " M/P");
            $sheet->setCellValue('CG9', $ppsData['total_stroke'] . " STROKE");
            $sheet->setCellValue('CG11', $ppsData['doc_level']);
            $sheet->setCellValue('CI70', $ppsData['length']);
            $sheet->setCellValue('CI71', $ppsData['width']);
            $sheet->setCellValue('CI72', $ppsData['boq']);
            $sheet->setCellValue('CO71', $ppsData['blank']);
            $sheet->setCellValue('DB71', $ppsData['scrap']);
            $sheet->setCellValue('CU71', $ppsData['panel']);
            $sheet->setCellValue('CG65', "C/F");
            $sheet->setCellValue('CO66', $ppsData['cf'] . " Unit");
            $sheet->setCellValue('CS68', $ppsData['material']);
            $sheet->setCellValue('CG67', "LOCATION");
            $sheet->setCellValue('CU67', "MAJ TAMBUN");
            $session = session(); 
            $sheet->setCellValue('DB79', $ppsData['creator_nickname']);

            // Set part no and part name
            $partNo = "Part No :\n" . $ppsData['part_no'];
            $sheet->setCellValue('CG73', $partNo);
            $sheet->getStyle('CG73')->getFont()->setBold(true);
            $sheet->getStyle('CG73')->getAlignment()->setWrapText(true);

            $partName = "Part Name :\n" . $ppsData['part_name'];
            $sheet->setCellValue('CU73', $partName);
            $sheet->getStyle('CU73')->getFont()->setBold(true);
            $sheet->getStyle('CU73')->getAlignment()->setWrapText(true);

            // Set images if available
            if ($ppsData['blank_layout']) {
                $drawing = new Drawing();
                $drawing->setName('Blank Layout Image');
                $drawing->setDescription('Blank Layout Image');
                $drawing->setPath(FCPATH . 'uploads/pps/' . $ppsData['blank_layout']);
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawing->setResizeProportional(false);
                $drawing->setWidth(200);
                $drawing->setHeight(300);
                $drawing->setCoordinates('CH16');
                $drawing->setWorksheet($sheet);
            }

            if ($ppsData['process_layout']) {
                $drawing = new Drawing();
                $drawing->setName('Process Layout Image');
                $drawing->setDescription('Process Layout Image');
                $drawing->setPath(FCPATH . 'uploads/pps/' . $ppsData['process_layout']);
                $drawing->setOffsetX(20);
                $drawing->setOffsetY(10);
                $drawing->setResizeProportional(false);
                $drawing->setWidth(130);
                $drawing->setHeight(180);
                $drawing->setCoordinates('CQ4');
                $drawing->setWorksheet($sheet);
            }

            $totalDies = count($ppsDiesData);
            $sheet->setCellValue('CG5', $totalDies . " SET DIES");
            $opCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1',  'C9', 'C9', 'C21', 'C33', 'C45', 'C57', 'C70'];
            $processCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'C12', 'C24', 'C36', 'C48', 'C60', 'C73'];
            $procCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'C15', 'C27', 'C39', 'C51', 'C63', 'C76'];
            $prosesCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'C18', 'C30', 'C42', 'C54', 'C66', 'C79'];
            $cgOpProcessCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CG48', 'CG51', 'CG54', 'CG57', 'CG60', 'CG63'];
            $cgProcessCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CG49', 'CG52', 'CG55', 'CG58', 'CG61', 'CG64'];
            $qtyDiesProcessCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CL48', 'CL51', 'CL54', 'CL57', 'CL60', 'CL63'];

            $lengthCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CU48', 'CU51', 'CU54', 'CU57', 'CU60', 'CU63'];
            $widthCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CU49', 'CU52', 'CU55', 'CU58', 'CU61', 'CU64'];
            $heightCells = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'CU50', 'CU53', 'CU56', 'CU59', 'CU62', 'CU65'];
            $mcCells = [
                'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1',    
                'CO48', 'CO51', 'CO54', 'CO57', 'CO60', 'CO63'
            ];
            
            $capacityCells = [
                'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 
                'CO49', 'CO52', 'CO55', 'CO58', 'CO61', 'CO64'
            ];
            
            $dieCushionCells = [
                'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 
                'CO50', 'CO53', 'CO56', 'CO59', 'CO62', 'CO65'
            ];

            $upperTextCells      = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'AU18', 'AU30', 'AU42', 'AU54', 'AU67', 'AU80'];
            $lowerTextCells      = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'AU19', 'AU31', 'AU43', 'AU55', 'AU68', 'AU81'];
            $padTextCells       = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'AU20', 'AU32', 'AU44', 'AU56', 'AU69', 'AU82'];
            $slidingTextCells    = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'BE18', 'BE30', 'BE42', 'BE54', 'BE67', 'BE80'];
            $guideTextCells      = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'BE19', 'BE31', 'BE43', 'BE55', 'BE68', 'BE81'];
            $padLifterTextCells  = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'BE20', 'BE32', 'BE44', 'BE56', 'BE69', 'BE82'];
            $insertTextCells     = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'BT18', 'BT30', 'BT42', 'BT54', 'BT67', 'BT80'];

    

            $lengthCells = [
                'XX1','XX1', 'XX1','XX1','XX1','XX1',   
                'CW48','CW51','CW54','CW57','CW60','CW63'
            ];
            $widthCells = [
                'XX1','XX1','XX1','XX1','XX1','XX1',
                'CW49','CW52','CW55','CW58','CW61','CW64'
            ];
            $heightCells = [
                'XX1','XX1','XX1','XX1','XX1','XX1',
                'CW50','CW53','CW56','CW59','CW62','CW65'
            ];
            $weightCells = [
                'XX1','XX1','XX1','XX1','XX1','XX1',
                'DB48','DB51','DB54','DB57','DB60','DB63'
            ];
            $pressureCells = [
                'XX1','XX1','XX1','XX1','XX1','XX1',
                'DB50','DB53','DB56','DB59','DB62','DB65'
            ];
            $upperCells     = ['XX1','XX1','XX1','XX1','XX1','XX1','AY18','AY30','AY42','AY54','AY67','AY80'];
            $lowerCells     = ['XX1','XX1','XX1','XX1','XX1','XX1','AY19','AY31','AY43','AY55','AY68','AY81'];
            $padCells       = ['XX1','XX1','XX1','XX1','XX1','XX1','AY20','AY33','AY45','AY57','AY70','AY83'];
            $slidingCells   = ['XX1','XX1','XX1','XX1','XX1','XX1','BJ18','BJ30','BJ42','BJ54','BJ67','BJ80'];
            $guideCells     = ['XX1','XX1','XX1','XX1','XX1','XX1','BJ19','BJ31','BJ43','BJ55','BJ68','BJ81'];
            $padLifterCells = ['XX1','XX1','XX1','XX1','XX1','XX1','BM19','BM32','BM44','BM56','BM69','BM82'];
            $insertCells    = ['XX1','XX1','XX1','XX1','XX1','XX1','BX18','BX30','BX42','BX54','BX67','BX80'];
            $heatCells     = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'BS19', 'BS31', 'BS43', 'BS55', 'BS68', 'BS81'];
            // Inisialisasi array untuk menyimpan data
            $bolsterLengthArr = [];
            $bolsterWeightArr = [];
            $slideAreaLengthArr = [];
            $slideAreaWeightArr = [];
            $dieHeightMaxArr = [];
            $cushionPadLengthArr = [];
            $cushionPadWeightArr = [];
            $cushionStrokeArr = [];
            $machineSpec = [];

            // Isi array dengan data dari database
            foreach ($ppsDiesData as $die) {
                $bolsterLengthArr[] = $die['bolster_length'];
                $bolsterWeightArr[] = $die['bolster_width'];
                $slideAreaLengthArr[] = $die['slide_area_length'];
                $slideAreaWeightArr[] = $die['slide_area_width'];
                $dieHeightMaxArr[] = $die['die_height_max'];
                $cushionPadLengthArr[] = $die['cushion_pad_length'];
                $cushionPadWeightArr[] = $die['cushion_pad_width'];
                $cushionStrokeArr[] = $die['cushion_stroke'];
                $machineSpec[] = $die['machine'];
                $slideStrokeArr[] = $die['slide_stroke'];
            
            }

            // Daftar kolom target yang ingin diisi data
            $targetColumns = ["CQ", "CU", "CZ", "DE"];
            $j = 0;
            
            for ($i = 5; $i < $totalDies; $i++) {
                $dieData = $ppsDiesData[$i];

                $column = $targetColumns[$j] ?? end($targetColumns);
            
                // Cek apakah ada baris selanjutnya untuk dibandingkan
                if (
                    ($i < $totalDies - 1) &&
                    ($bolsterLengthArr[$i]    ?? '') == ($bolsterLengthArr[$i+1]    ?? '') &&
                    ($bolsterWeightArr[$i]    ?? '') == ($bolsterWeightArr[$i+1]    ?? '') &&
                    ($slideAreaLengthArr[$i]  ?? '') == ($slideAreaLengthArr[$i+1]  ?? '') &&
                    ($slideAreaWeightArr[$i]  ?? '') == ($slideAreaWeightArr[$i+1]  ?? '') &&
                    ($dieHeightMaxArr[$i]     ?? '') == ($dieHeightMaxArr[$i+1]     ?? '') &&
                    ($cushionPadLengthArr[$i] ?? '') == ($cushionPadLengthArr[$i+1] ?? '') &&
                    ($cushionPadWeightArr[$i] ?? '') == ($cushionPadWeightArr[$i+1] ?? '') &&
                    ($slideStrokeArr[$i] ?? '') == ($slideStrokeArr[$i+1] ?? '') &&
                    ($cushionStrokeArr[$i]    ?? '') == ($cushionStrokeArr[$i+1]    ?? '')
                ) {
                    // Jika data baris ke-i dan ke-(i+1) identik, gabungkan machineSpec
                    $mergedMachine = ($machineSpec[$i] ?? '') . ', ' . ($machineSpec[$i+1] ?? '');
                    
                    $sheet->setCellValue("{$column}34", $mergedMachine);
                    $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
                    $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
                    $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
                    $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
                    $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
                    $sheet->setCellValue("{$column}40", $slide_stroke[$i]     ?? '');
                    $sheet->setCellValue("{$column}41", $cushionPadLengthArr[$i] ?? '');
                    $sheet->setCellValue("{$column}42", $cushionPadWeightArr[$i] ?? '');
                    $sheet->setCellValue("{$column}43", $cushionStrokeArr[$i]    ?? '');
                    
                    // Lewati baris berikutnya karena sudah digabung
                    $i++;
                    $j++;
                } else {
                    // Jika tidak ada pasangan (atau baris berikutnya berbeda), tuliskan data baris ke-i secara individual
                    $sheet->setCellValue("{$column}34", $machineSpec[$i]         ?? '');
                    $sheet->setCellValue("{$column}35", $bolsterLengthArr[$i]    ?? '');
                    $sheet->setCellValue("{$column}36", $bolsterWeightArr[$i]    ?? '');
                    $sheet->setCellValue("{$column}37", $slideAreaLengthArr[$i]  ?? '');
                    $sheet->setCellValue("{$column}38", $slideAreaWeightArr[$i]  ?? '');
                    $sheet->setCellValue("{$column}39", $dieHeightMaxArr[$i]     ?? '');
                    $sheet->setCellValue("{$column}40", $slide_stroke[$i]     ?? '');
                    $sheet->setCellValue("{$column}41", $cushionPadLengthArr[$i] ?? '');
                    $sheet->setCellValue("{$column}42", $cushionPadWeightArr[$i] ?? '');
                    $sheet->setCellValue("{$column}43", $cushionStrokeArr[$i]    ?? '');
                    $j++;
                }
            }
                for ($i = 5; $i < $totalDies; $i++) {
                    $dieData = $ppsDiesData[$i];
        
                $processValue = str_replace("OP", "", $dieData['process']);
                $processJoinValue = str_replace("OP", "", $dieData['process_join']);
                $prosesValue = str_replace("OP", "", $dieData['proses']);
                $prosesGangValue = str_replace("OP", "", $dieData['proses_gang']);
            
                $sheet->setCellValue(
                    $processCells[$i],
                    $processValue . ($processJoinValue != null ? ", " . $processJoinValue : "")
                );
                $sheet->setCellValue(
                    $prosesCells[$i],
                    $prosesValue . ($prosesGangValue != null ? ", " . $prosesGangValue : "")
                );

                $sheet->setCellValue($opCells[$i], 'OP');
                $sheet->setCellValue($procCells[$i], 'PROC.');
                $cgOpProcessValue     = str_replace("OP", "", $dieData['process']);
                $cgOpProcessJoinValue = str_replace("OP", "", $dieData['process_join']);
                $cgProcessValue       = str_replace("OP", "", $dieData['proses']);
                $cgProcessGangValue   = str_replace("OP", "", $dieData['proses_gang']);

                $sheet->setCellValue(
                    $cgOpProcessCells[$i],
                    $cgOpProcessValue . ($cgOpProcessJoinValue != null ? ", " . $cgOpProcessJoinValue : "")
                );
                $sheet->setCellValue(
                    $cgProcessCells[$i],
                    $cgProcessValue . ($cgProcessGangValue != null ? ", " . $cgProcessGangValue : "")
                );

                $sheet->setCellValue($mcCells[$i], $dieData['machine']);
                $sheet->setCellValue($capacityCells[$i], $dieData['capacity']);
                $sheet->setCellValue($dieCushionCells[$i], $dieData['cushion']);
                $sheet->setCellValue($qtyDiesProcessCells[$i], $dieData['qty']);
        
                // Set die dimensions
                $sheet->setCellValue($lengthCells[$i],   $dieData['die_length']);
                $sheet->setCellValue($widthCells[$i],    $dieData['die_width']);
                $sheet->setCellValue($heightCells[$i],   $dieData['die_height']);
                $sheet->setCellValue($weightCells[$i],   $dieData['die_weight']);
                $sheet->setCellValue($pressureCells[$i], $dieData['main_pressure']);
                
                // Set other die-specific data
                $sheet->setCellValue($upperCells[$i],     $dieData['upper']);
                $sheet->setCellValue($lowerCells[$i],     $dieData['lower']);
                $sheet->setCellValue($padCells[$i],       $dieData['pad']);
                $sheet->setCellValue($slidingCells[$i],   $dieData['sliding']);
                $sheet->setCellValue($guideCells[$i],     $dieData['guide']);
                $sheet->setCellValue($padLifterCells[$i], $dieData['pad_lifter']);
                $sheet->setCellValue($insertCells[$i],    $dieData['insert']);
                $sheet->setCellValue($heatCells[$i],    $dieData['heat_treatment']);
        

                if (isset($lengthCells[$i])) {
                    $sheet->setCellValue($lengthCells[$i], 'L');
                }
                
                if (isset($widthCells[$i])) {
                    $sheet->setCellValue($widthCells[$i], 'W');
                }
                
                if (isset($heightCells[$i])) {
                    $sheet->setCellValue($heightCells[$i], 'H');
                }
                if (isset($upperTextCells[$i])) {
                    $sheet->setCellValue($upperTextCells[$i], 'UPPER');
                
                }
                if (isset($lowerTextCells[$i])) {
                    $sheet->setCellValue($lowerTextCells[$i], 'LOWER');
                }
            
                if (isset($padTextCells[$i])) {
                    $sheet->setCellValue($padTextCells[$i], 'PAD');
                }
            
                if (isset($slidingTextCells[$i])) {
                    $sheet->setCellValue($slidingTextCells[$i], 'SLIDING');
                }
            
                if (isset($guideTextCells[$i])) {
                    $sheet->setCellValue($guideTextCells[$i], 'GUIDE');
                }
            
                if (isset($padLifterTextCells[$i])) {
                    $sheet->setCellValue($padLifterTextCells[$i], 'PAD LIFTER');
                }
            
                if (isset($insertTextCells[$i])) {
                    $sheet->setCellValue($insertTextCells[$i], 'INSERT');
                }
            
            // Array posisi koordinat
                $rowClayoutImg = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'H9', 'H21', 'H33', 'H45', 'H57', 'H70'];
                $rowDcImg = ['XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'XX1', 'AT9', 'AT21', 'AT33', 'AT45', 'AT57', 'AT70'];

                // CLayout image
                if ($dieData['clayout_img']) {
                    $drawing = new Drawing();
                    $drawing->setName('Clayout Image');
                    $drawing->setDescription('Clayout Image');
                    $drawing->setPath(FCPATH . 'uploads/pps/' . $dieData['clayout_img']);
                    $drawing->setOffsetX(40);
                    $drawing->setOffsetY(20);
                    $drawing->setResizeProportional(false);
                    $drawing->setWidth(310);
                    $drawing->setHeight(190);
                    // Ambil dari array berdasarkan index $i
                    $drawing->setCoordinates($rowClayoutImg[$i] ?? 'H9');
                    $drawing->setWorksheet($sheet);
                }

                // Die Construction image
                if ($dieData['die_construction_img']) {
                    $drawing = new Drawing();
                    $drawing->setName('Die Construction Image');
                    $drawing->setDescription('Die Construction Image');
                    $drawing->setPath(FCPATH . 'uploads/pps/' . $dieData['die_construction_img']);
                    $drawing->setOffsetX(40);
                    $drawing->setOffsetY(20);
                    $drawing->setResizeProportional(false);
                    $drawing->setWidth(340);
                    $drawing->setHeight(145);
                    // Ambil dari array berdasarkan index $i
                    $drawing->setCoordinates($rowDcImg[$i] ?? 'AT9');
                    $drawing->setWorksheet($sheet);
                }
        
            }
        }
        $newFilePath = WRITEPATH . 'uploads/generated_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($newFilePath);

        return $this->response->download($newFilePath, null)
        ->setFileName($ppsData['part_no'] . '-' . $ppsData['part_name'] . '.xlsx');
    
    }
    public function checkMatch()
    {
        $input = $this->request->getJSON(true);
    
        $mainPressures = $input['main_pressures'] ?? [];
        $dieLengths    = $input['die_lengths'] ?? [];
        $dieWidths     = $input['die_widths'] ?? [];
    
        if (!is_array($mainPressures) || !is_array($dieLengths) || !is_array($dieWidths)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Input tidak valid.'
            ])->setStatusCode(400);
        }
    
        $model = new McSpecModel();
        $machines = $model->findAll();
        $result = [];
    
        foreach ($mainPressures as $index => $mainPressure) {
            $dieLength = $dieLengths[$index] ?? 0;
        $dieWidth  = $dieWidths[$index] ?? 0;
    
            $matches = [];
            $closestIndex = null;
            $closestDiff = PHP_INT_MAX;
    
            foreach ($machines as $i => $machine) {
                $capacity = floatval($machine['capacity']);
                $threshold = 0.85 * $capacity;
    
                // Validasi ukuran die
                $bolsterLength = floatval($machine['bolster_length']);
                $bolsterWidth  = floatval($machine['bolster_width']);
                $slideLength   = floatval($machine['slide_area_length']);
                $slideWidth    = floatval($machine['slide_area_width']);
    
                $isSizeMatch = ($dieLength < $bolsterLength && $dieLength < $slideLength) &&
                ($dieWidth < $bolsterWidth && $dieWidth < $slideWidth);
 
                $isPressureMatch = $capacity > 0 && $mainPressure < $threshold;
                
                $isMatch = $isPressureMatch && $isSizeMatch;
                
                $reason = '';
                if (!$isPressureMatch) {
                    $reason .= "Main Pressure melebihi 85% kapasitas mesin. ";
                }
                if (!$isSizeMatch) {
                    if ($dieLength >= $bolsterLength || $dieLength >= $slideLength) {
                        $reason .= "Die Length melebihi Bolster/Slide. ";
                    }
                    if ($dieWidth >= $bolsterWidth || $dieWidth >= $slideWidth) {
                        $reason .= "Die Width melebihi Bolster/Slide. ";
                    }
                }
 
                $matches[] = [
                    'machine' => $machine['machine'],
                    'capacity' => $capacity,
                    'cushion' => $machine['cushion'],
                    'bolster_length' => $bolsterLength,
                    'bolster_width'  => $bolsterWidth,
                    'slide_area_length' => $slideLength,
                    'slide_area_width'  => $slideWidth,
                    'match' => $isMatch,
                    'highlight' => false,
                    'reason' => $isMatch ? '✅ Match' : trim($reason)
                ];
    
                if ($isMatch) {
                    $diff = abs($mainPressure - $threshold);
                    if ($diff < $closestDiff) {
                        $closestDiff = $diff;
                        $closestIndex = $i;
                    }
                }
            }
    
            if ($closestIndex !== null) {
                $matches[$closestIndex]['highlight'] = true;
            }
    
            $result[] = [
                'main_pressure' => $mainPressure,
                'die_length' => $dieLength,
                'die_width' => $dieWidth,
                'matches' => $matches, // tambahkan ini
                'reason' => $isMatch ? '✅ Match' : trim($reason)
            ];
            
        }
    
        return $this->response->setJSON($result);
    }
    
    public function listPpsImages()
    {
        $path = FCPATH . 'uploads/process_layout/';
        $files = scandir($path);
        $images = [];
    
        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = base_url('uploads/process_layout/' . $file);
            }
        }
    
        return $this->response->setJSON($images);
    }

    public function listPpsImages3()
    {
        $maxOp = intval($this->request->getGet('maxOp'));
    
        $path  = FCPATH . 'uploads/process_layout/';

        $files = array_diff(scandir($path), ['.','..']);
        $images = [];
    
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (! in_array($ext, ['jpg','jpeg','png','gif'])) {
                continue;
            }
    
            $prefix = substr($file, 0, 2);
            if (ctype_digit($prefix) && intval($prefix) === $maxOp) {
                $images[] = base_url('uploads/process_layout/' . $file);
            }
        }
    
        return $this->response->setJSON($images);
    }
    

    public function listDieConsImg()
    {
        $process = $this->request->getGet('process');
        $path    = FCPATH . 'uploads/die_cons/';
        $files   = array_diff(scandir($path), ['.', '..']);
        $images  = [];
    
        if ($process) {
            $process = str_replace('-', ' ', $process);
            $keywords = preg_split('/\s+/', $process);
        } else {
            $keywords = [];
        }
    
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                continue;
            }
    
            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    if ($keyword && stripos($file, $keyword) !== false) {
                        $images[] = base_url('uploads/die_cons/' . $file);
                        break; 
                    }
                }
            } else {
                $images[] = base_url('uploads/die_cons/' . $file);
            }
        }
    
        return $this->response->setJSON($images);
    }
    
    
    
   public function updateNew()
    {
        $ppsModel = new PpsModel();
        $ppsDiesModel = new PpsDiesModel();

        $id = $this->request->getPost('id');
        $oldData = $ppsModel->where('id', $id)->first();
        $oldDiesData = $ppsDiesModel->where('pps_id', $id)->findAll();

        $oldImages = [];
        foreach ($oldDiesData as $i => $die) {
            $oldImages[$i] = [
                'clayout_img' => $die['clayout_img'],
                'die_construction_img' => $die['die_construction_img']
            ];
        }

        $insertedId = null;
        $dataPps = [
            'cust'         => $this->request->getPost('cust'),
            'model'        => $this->request->getPost('model'),
            'receive'      => $this->request->getPost('receive'),
            'part_no'      => $this->request->getPost('part_no'),
            'part_name'    => $this->request->getPost('part_name'),
            'cf'           => $this->request->getPost('cf'),
            'material'     => $this->request->getPost('material'),
            'tonasi'       => $this->request->getPost('tonasi'),
            'length'       => $this->request->getPost('length'),
            'width'        => $this->request->getPost('width'),
            'boq'          => $this->request->getPost('boq'),
            'blank'        => $this->request->getPost('blank'),
            'panel'        => $this->request->getPost('panel'),
            'scrap'        => $this->request->getPost('scrap'),
            'total_mp'     => $this->request->getPost('total_mp'),
            'doc_level'    => $this->request->getPost('doc_level'),
            'total_stroke' => $this->request->getPost('total_stroke'),
            'process_layout' => $this->request->getPost('process_layout'),
            'blank_layout'   => $this->request->getPost('blank_layout'),
            'created_by'   => session()->get('user_id'),
            'status' => 1,
        ];
        $uploadPath = FCPATH . 'uploads/pps/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Update Blank Layout
        $blankLayout = $this->request->getFile('blank_layout');
        if ($blankLayout && $blankLayout->isValid() && !$blankLayout->hasMoved()) {
            if (!empty($oldData['blank_layout'])) {
                @unlink($uploadPath . $oldData['blank_layout']);
            }
            $blankLayoutName = "blank_layout_" . time() . "." . $blankLayout->getExtension();
            $blankLayout->move($uploadPath, $blankLayoutName);
            $dataPps['blank_layout'] = $blankLayoutName;
        } else {
            $dataPps['blank_layout'] = $this->request->getPost('old_blank_layout');
        }
        


        // $processLayout = $this->request->getFile('process_layout');
        // if ($processLayout && $processLayout->isValid() && !$processLayout->hasMoved()) {
        //     if (!empty($oldData['process_layout'])) {
        //         @unlink($uploadPath . $oldData['process_layout']);
        //     }
        //     $processLayoutName = "process_layout_" . time() . "." . $processLayout->getExtension();
        //     $processLayout->move($uploadPath, $processLayoutName);
        //     $dataPps['process_layout'] = $processLayoutName;
        // } else {
        //     $dataPps['process_layout'] = $this->request->getPost('old_process_layout');
        // }
        
        $processLayoutFile     = $this->request->getFile('process_layout_img');        // file upload baru
        $processLayoutSelected = $this->request->getPost('process_layout_selected');   // URL gambar yang dipilih
        $oldProcessLayout      = $this->request->getPost('old_process_layout');        // nama file lama
        $processLayoutName     = $oldProcessLayout;                                    // default = data lama
        
        $uploadProcessPath = FCPATH . 'uploads/pps/';
        if (! is_dir($uploadProcessPath)) {
            mkdir($uploadProcessPath, 0777, true);
        }
        
        if ($processLayoutFile && $processLayoutFile->isValid() && ! $processLayoutFile->hasMoved()) {
            // hapus file lama jika ada
            // if ($oldProcessLayout) {
            //     @unlink($uploadProcessPath . $oldProcessLayout);
            // }
            $processLayoutName = 'process_layout_' . time() . '.' . $processLayoutFile->getExtension();
            $processLayoutFile->move($uploadProcessPath, $processLayoutName);
            $dataPps['process_layout'] = $processLayoutName;
    
        } elseif ($processLayoutSelected) {
            $parsed = parse_url($processLayoutSelected, PHP_URL_PATH);
            $source = FCPATH . ltrim($parsed, '/');
            print_r( $source);
            
            if (file_exists($source)) {
                $processLayoutName = 'process_layout_' . time() . '.' . pathinfo($source, PATHINFO_EXTENSION);
                copy($source, $uploadProcessPath . $processLayoutName);
                $dataPps['process_layout'] = $processLayoutName;
            }
        
        }else {
            $dataPps['process_layout'] = $this->request->getPost('old_process_layout');
        }

        
        $ppsModel->insert($dataPps);
        $idNew = $ppsModel->getInsertID(); 

        $dies = $this->request->getPost('dies');

        if (!empty($dies) && is_array($dies)) {
            foreach ($dies as $index => $die) {
                // $class = null;
                // $die_weight = $die['die_weight'] ?? null;
                // if($die_weight > 6971) {
                //     $class = "A";
                // } else if($die_weight > 3914 && $die_weight <= 6971) {
                //     $class = "B";
                // } else if($die_weight > 1961 && $die_weight <= 3914) {
                //     $class = "C";
                // } else if($die_weight > 848 && $die_weight <= 1961) {
                //     $class = "D";
                // } else if($die_weight > 397 && $die_weight <= 848) {
                //     $class = "E";
                // } else if($die_weight <= 397) {
                //     $class = "F";
                // }

        //   print_r($die['panjangProses'] );exit();
                $dieData = [
                    'pps_id'            => $idNew,
                    'process'           => $die['process'] ?? null,
                    'process_join'      => $die['process_join'] ?? null,
                    'proses'            => $die['proses'] ?? null,
                    'proses_gang'       => $die['proses_gang'] ?? null,
                    'qty'        => $die['qty_dies'] ?? null,
                    'length_mp'         => $die['length_mp'] ?? null,
                    'main_pressure'     => $die['main_pressure'] ?? null,
                    'panjang'           => $die['panjang'] ?? null,
                    'lebar'             => $die['lebar'] ?? null,
                    'machine'           => $die['machine'] ?? null,
                    'capacity'          => $die['capacity'] ?? null,
                    'cushion'           => $die['cushion'] ?? null,
                    'die_length'        => $die['die_length'] ?? null,
                    'die_width'         => $die['die_width'] ?? null,
                    'die_height'        => $die['die_height'] ?? null,
                    'casting_plate'     => $die['casting_plate'] ?? null,
                    'die_weight'        => $die['die_weight'] ?? null,
                    'dc_process'        => $die['dc_process'] ?? null,
                    'dc_machine'        => $die['dc_machine'] ?? null,
                    'upper'             => $die['upper'] ?? null,
                    'lower'             => $die['lower'] ?? null,
                    'pad'               => $die['pad'] ?? null,
                    'pad_lifter'        => $die['pad_lifter'] ?? null,
                    'sliding'           => $die['sliding'] ?? null,
                    'guide'             => $die['guide'] ?? null,
                    'insert'            => $die['insert'] ?? null,
                    'heat_treatment'    => $die['heat_treatment'] ?? null,
                    'slide_stroke'      => $die['slide_stroke'] ?? null,
                    'cushion_stroke'    => $die['cushion_stroke'] ?? null,
                    'die_cushion_pad'   => $die['die_cushion_pad'] ?? null,
                    'bolster_length'    => $die['bolster_length'] ?? null,
                    'bolster_width'     => $die['bolster_width'] ?? null,
                    'slide_area_length' => $die['slide_area_length'] ?? null,
                    'slide_area_width'  => $die['slide_area_width'] ?? null,
                    'cushion_pad_length'=> $die['cushion_pad_length'] ?? null,
                    'cushion_pad_width' => $die['cushion_pad_width'] ?? null,
                    'class'             => $die['die_class'] ?? null,
                    'die_height_max'    => $die['die_height_max'] ?? null,
                    'cbPanjangProses' => ($die['cbPanjangProses'] ?? '0') == '1' ? 1 : 0,
                    'cbPie'           => ($die['cbPie'] ?? '0') == '1' ? 1 : 0,
                    'cbPanjangLebar'  => ($die['cbPanjangLebar'] ?? '0') == '1' ? 1 : 0,
                        'diameterPie'   =>  $die['diameter']  ?? null,
                    'jumlahPie'             => $die['jumlahPie']  ?? null,
                    'panjangProses'    => $die['panjangProses']  ?? null,
                    
                ];
                
                // $clayoutFile = $this->request->getFile("dies.{$index}.clayout_img");
                // if ($clayoutFile && $clayoutFile->isValid() && !$clayoutFile->hasMoved()) {
                //     // Jika ada file lama, hapus file tersebut
                //     $oldClayout = $this->request->getPost("dies.{$index}.old_clayout_img");
                //     if (!empty($oldClayout)) {
                //         @unlink(WRITEPATH . 'uploads/pps/' . $oldClayout);
                //     }
                //     // Gunakan file yang diambil dari getFile, bukan array lain
                //     $clayoutName = "clayout_" . time() . "_$index." . $clayoutFile->getExtension();
                //     $clayoutFile->move($uploadPath, $clayoutName);
                //     $dieData['clayout_img'] = $clayoutName;
                // } else {
                //     // Jika tidak ada file baru, gunakan file lama
                //     $dieData['clayout_img'] = $this->request->getPost("dies.{$index}.old_clayout_img");
                // }
                
                // $dieConstructionFile = $this->request->getFile("dies.{$index}.die_construction_img");
                // if ($dieConstructionFile && $dieConstructionFile->isValid() && !$dieConstructionFile->hasMoved()) {
                //     $oldDieConstruction = $this->request->getPost("dies.{$index}.old_die_construction_img");
                //     if (!empty($oldDieConstruction)) {
                //         @unlink(WRITEPATH . 'uploads/pps/' . $oldDieConstruction);
                //     }
                //     $dieConstrName = "die_constr_" . time() . "_$index." . $dieConstructionFile->getExtension();
                //     $dieConstructionFile->move($uploadPath, $dieConstrName);
                //     $dieData['die_construction_img'] = $dieConstrName;
                // } else {
                //     $dieData['die_construction_img'] = $this->request->getPost("dies.{$index}.old_die_construction_img");
                // }

                $oldClayoutImg = $oldImages[$index]['clayout_img'] ?? null;
            
                
                $clayoutFile = $this->request->getFile("dies.{$index}.clayout_img");
                if ($clayoutFile && $clayoutFile->isValid() && !$clayoutFile->hasMoved()) {
                    $clayoutName = "clayout_" . time() . "_$index." . $clayoutFile->getExtension();
                    $clayoutFile->move($uploadPath, $clayoutName);
                    $dieData['clayout_img'] = $clayoutName;
                } else {
                    $dieData['clayout_img'] = $oldClayoutImg;
                }
        
                $oldDieConstructionImg = $oldImages[$index]['die_construction_img'] ?? null;
            
                $dieConstructionFile = $this->request->getFile("dies.{$index}.die_construction_img");
                
            
                $selectedImg = $this->request->getPost("dies")[$index]['selected_die_construction_img'] ?? null;
                
                
                $uploadPath = FCPATH . 'uploads/pps/'; 
                
                if ($dieConstructionFile && $dieConstructionFile->isValid() && !$dieConstructionFile->hasMoved()) {
        
                    $dieConstrName = "die_constr_" . time() . "_$index." . $dieConstructionFile->getExtension();
                    if ($dieConstructionFile->move($uploadPath, $dieConstrName)) {
                        $dieData['die_construction_img'] = $dieConstrName;
                    } else {
                        echo "Gagal memindahkan file ke folder: " . $uploadPath;
                    }
                
                } else if (!empty($selectedImg)) {
                    $parsedPath = parse_url($selectedImg, PHP_URL_PATH);
                
                    $sourcePath = FCPATH . urldecode(ltrim($parsedPath, '/')); 
            
                    if (file_exists($sourcePath)) {
                        $dieConstrName = "die_constr_" . time() . "_$index." . pathinfo($sourcePath, PATHINFO_EXTENSION);
                
                        if (copy($sourcePath, $uploadPath . $dieConstrName)) {
                            $dieData['die_construction_img'] = $dieConstrName;
                        } else {
                            echo "Gagal menyalin file ke folder tujuan: " . $uploadPath . $dieConstrName;
                        }
                    } else {
                        echo "File tidak ditemukan: $sourcePath<br>";
                    }
                
                } else {
                    $dieData['die_construction_img'] = $oldDieConstructionImg;
                }
                
                $ppsDiesModel->insert($dieData);
            
                    $insertedId = $ppsDiesModel->insertID();
            }
            // Function to safely copy data from one model to another
            // $copyModelData = function($sourceModel, $id, $targetModel, $additionalData = []) {
            //     $oldData = $sourceModel->find($id);
                
            //     // Skip if data not found
            //     if (!$oldData) {
            //         return false;
            //     }
                
            //     // Remove id to create a new entry
            //     unset($oldData['id']);
                
            //     // Add common fields
            //     $oldData['created_at'] = date('Y-m-d H:i:s');
            //     $oldData['created_by'] = session()->get('user_id');
                
            //     // Merge additional data if any
            //     if (!empty($additionalData)) {
            //         $oldData = array_merge($oldData, $additionalData);
            //     }
                
            //     // Insert and return the new ID
            //     $targetModel->insert($oldData);
            //     return $targetModel->insertID();
            // };
            
            // // Copy sketch file if exists
            // $copySketchFile = function($oldData) {
            //     if (!empty($oldData['sketch']) && file_exists(FCPATH . 'uploads/dcp/' . $oldData['sketch'])) {
            //         $fileExt = pathinfo($oldData['sketch'], PATHINFO_EXTENSION);
            //         $newSketchName = uniqid('sketch_') . '.' . $fileExt;
            //         copy(FCPATH . 'uploads/dcp/' . $oldData['sketch'], FCPATH . 'uploads/dcp/' . $newSketchName);
            //         return $newSketchName;
            //     }
            //     return null;
            // };
            
            // // Copy overview data
            // $oldOverviewData = $this->overviewModel->find($id);
            // if ($oldOverviewData) {
            //     $newSketchName = $copySketchFile($oldOverviewData);
                
            //     // Remove id and update fields
            //     unset($oldOverviewData['id']);
            //     $oldOverviewData['created_at'] = date('Y-m-d H:i:s');
            //     $oldOverviewData['created_by'] = session()->get('user_id');
            //     $oldOverviewData['id_pps_dies'] = $insertedId;
                
            //     // Update sketch if exists
            //     if ($newSketchName) {
            //         $oldOverviewData['sketch'] = $newSketchName;
            //     }
                
            //     // Insert and get the new ID
            //     $this->overviewModel->insert($oldOverviewData);
            //     $newOverviewId = $this->overviewModel->insertID();
                
            //     // Now safely copy data from other models
            //     $copyModelData($this->designProgramModel, $id, $this->designProgramModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->polyModel, $id, $this->polyModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->finishing3Model, $id, $this->finishing3Model, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->finishingModel, $id, $this->finishingModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->finishing2Model, $id, $this->finishing2Model, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->mainMaterialModel, $id, $this->mainMaterialModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->machiningModel, $id, $this->machiningModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->machining2Model, $id, $this->machining2Model, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->dieSpotModel1, $id, $this->dieSpotModel1, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->dieSpotModel3, $id, $this->dieSpotModel3, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->dieSpotModel2, $id, $this->dieSpotModel2, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->toolCostModel, $id, $this->toolCostModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->heatTreatmentModel, $id, $this->heatTreatmentModel, ['overview_id' => $newOverviewId]);
            //     $copyModelData($this->aksesorisModel, $id, $this->aksesorisModel, ['overview_id' => $newOverviewId]);
            // }
        } 

        return redirect()->to(site_url('pps'))->with('success', 'Data berhasil disalin sebagai data baru');
    }
    public function logAktivitas()
    {
        $partNo   = $this->request->getGet('part_no');
        $ppsModel = new PpsModel();
        $userModel = new UserModel();
    
        $log = $ppsModel->where('part_no', $partNo)->findAll();
    
        if (count($log) > 1) {
            $threshold = date('Y-m-d H:i:s', strtotime('-90 days'));
            $ppsModel
                ->where('part_no', $partNo)
                ->where('updated_at <', $threshold)
                ->set(['status' => 0])
                ->update();
        }
    
        foreach ($log as &$item) {
            $user = $userModel->find($item['created_by']);
            $item['pembuat'] = $user ? $user['nickname'] : '-';
        }
    
        $data = [
            'partNo' => $partNo,
            'log'    => $log
        ];
    
        return view('pps/log_aktivitas', $data);
    }
}