<?php

namespace App\Controllers;
use App\Models\ActualActivityModel;
use App\Models\ActivityModel;
use App\Models\ProjectModel;
use App\Models\ActualActivityDetailModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ActualActivity extends BaseController
{
    protected $actualActivityModel;
    protected $detailModel;
    protected $activityModel;
    public function __construct()
    {
        $this->actualActivityModel = new ActualActivityModel();
        $this->detailModel = new ActualActivityDetailModel();
        $this->activityModel = new ActivityModel();
    }
    public function index()
    {
        // Retrieve filter parameters from GET; if missing, default to current month
        $start_date = $this->request->getGet('start_date') ?: date('Y-m-01'); // First day of current month
        $end_date   = $this->request->getGet('end_date')   ?: date('Y-m-t');  // Last day of current month
    
        // Build the query with the date filter
        $builder = $this->actualActivityModel
            ->select('actual_activity.*, users.nama AS created_by_name')
            ->join('users', 'users.id = actual_activity.created_by', 'left')
            ->where('users.status', 1)
            ->whereIn('actual_activity.status', [1, 7])
            ->where("DATE(actual_activity.dates) >=", $start_date)
            ->where("DATE(actual_activity.dates) <=", $end_date)
            ->orderBy('actual_activity.dates', 'DESC')
            ->orderBy('actual_activity.modified_at', 'ASC');
    
        $data['activities'] = $builder->findAll();
    
        // Pass filter parameters to view
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
    
        return view('actual_activity/index', $data);
    }
    

    public function indexPersonal()
    {
        $data['activities'] = $this->actualActivityModel
        ->select('actual_activity.*, users.nickname as comment_by_name')
        ->join('users', 'users.id = actual_activity.comment_by', 'left')
        ->whereIn('actual_activity.status', [1, 2, 7])
        ->where('actual_activity.created_by', session()->get('user_id'))
        ->orderBy('actual_activity.dates', 'DESC')
        ->findAll();
        return view('actual_activity/indexPersonal', $data);
    }
    public function create()
    {
         $defaultActivity = (new ActivityModel())
                            ->where('name', 'BRIEFING PAGI')
                            ->first();
        $defaultActivityId = $defaultActivity ? $defaultActivity['id'] : '';
    
        $defaultProject = (new ProjectModel())
                          ->where('another_project', 'DAILY')
                          ->first();
        $defaultProjectId = $defaultProject ? $defaultProject['jenis'] . '-' . $defaultProject['id'] . '-' : '';
    
        $data['activities'] = (new ActivityModel())
                               ->where('status', 1)
                               ->orderBy('name')
                               ->findAll();
    
        $data['projects'] = (new ProjectModel())
                             ->where('status', 1)
                             ->orderBy('another_project')
                             ->orderBy('jenis_tooling')
                             ->findAll();
    
       $data['defaultActivityId'] = $defaultActivityId;
        $data['defaultProjectId'] = $defaultProjectId;
    
        $data['remarkSuggestions'] = (new ActualActivityDetailModel())
                                     ->where('created_by', session()->get('user_id'))
                                     ->where('created_at >=', date('Y-m-d', strtotime('-14 days')))
                                     ->findAll();
    
        return view('actual_activity/create', $data);
    }
    
    public function fetchActivities()
    {
        $project_id = $this->request->getVar('project_id');
        
        $activities = $this->activityModel->where('project_id', $project_id)->findAll();

        return $this->response->setJSON($activities);
    }
    public function fetchModels()
    {
        $project_type = $this->request->getGet('project_type');
        $tooling_type = $this->request->getGet('tooling_type');
        $modelModel = new ProjectModel();
    
        $model = $modelModel->select('jenis')
                            ->where('jenis', $project_type)
                            ->first(); 
    
        if ($model) {
            $jenis = $model['jenis'];
    
            $models = $modelModel->select(['model', 'jenis_tooling'])
            ->where('jenis', $jenis)
            ->where('jenis_tooling', $tooling_type)
            ->where('status', 1)    
            ->groupBy(['model', 'jenis_tooling']) 
            ->findAll();
        

        } else {
            $models = [];
        }
    
        return $this->response->setJSON($models);
    }
    
    

    public function fetchPartNoProcess()
    {
        $model= $this->request->getVar('model_id');
        $jenis_tooling = $this->request->getGet('jenis_tooling');
        
        $partNoProcessModel = new ProjectModel();
        $partNoProcesses = $partNoProcessModel
        ->like('model', $model) 
        ->like('jenis_tooling', $jenis_tooling)
        ->where('status', 1)
        ->findAll();
    
        return $this->response->setJSON($partNoProcesses);
    }
    public function store() 
    {
        $db = \Config\Database::connect();
        $submitStatus = $this->request->getPost('submit_status');
        try {

            if ($submitStatus === 'submit') {
                $status = 1; 
            } else {
                $status = 2;
            }
            $createdBy = session()->get('user_id'); 
            $details = $this->request->getPost('details');
            $date = $this->request->getPost('dates');
          
            if (!$details || count($details) === 0) {
                return redirect()->back()->withInput()->with('error', 'Silakan tambahkan minimal satu detail aktivitas.');
            }
    
            $actualActivityData = [
                'status'      => $status,
                'created_by'  => $createdBy,
                'dates' => $date,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
    
            $this->actualActivityModel->insert($actualActivityData);
            $actualActivityId = $this->actualActivityModel->insertID();
    
            foreach ($details as $detail) {
                if (empty($detail['activity_id']) || empty($detail['project_id']) ) {
                    throw new \Exception('Data detail tidak lengkap.');
                }
   

                $startTime = $detail['start_time'];
                $endTime = $detail['end_time'];
            
                // if (strtotime($endTime) <= strtotime($startTime)) {
                //     throw new \Exception('Waktu selesai harus lebih besar dari waktu mulai.');
                // }
                $totalTime = $this->calculateTotalTime($startTime, $endTime);
        
                $project_id =null;
                
           
              
                if (strpos($detail['project_id'], '-') !== false) {
                    $parts = explode('-', $detail['project_id']);
                    print_r($parts );
                    if (strpos(trim($parts[0]), "Tooling Project") === false) {
                        $project_id = $parts[1];
                    } else {
                        $project_id = explode('-', $detail['part_no'])[0];
                    }                    
                } else {
                    $project_id = explode('-', $detail['part_no'])[0];
                }
           
                
                $detailData = [
                    'actual_activity_id' => $actualActivityId,
                    'activity_id'        => $detail['activity_id'],
                    'project_id'         => $project_id,
                    'remark'             => $detail['remark'],
                    'start_time'         => $startTime,
                    'end_time'           => $endTime,
                    'total_time'         => $totalTime,
                    'progress'           => $detail['progress'],
                    'created_by' =>  $createdBy,
                ];
            
                 $this->detailModel->insert($detailData);
            }
            // $db->transComplete(); // Selesaikan transaksi database
    
            // if ($db->transStatus() === false) {
            //     throw new \Exception('Terjadi kesalahan saat menyimpan data.');
            // }
    
            return redirect()->to(site_url('actual-activity/personal'))->with('success', 'Data berhasil disimpan.');
    
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $actualActivity = $this->actualActivityModel->find($id);
        if (!$actualActivity) {
            return redirect()->to(site_url('actual-activity'))->with('error', 'Data tidak ditemukan.');
        }
        $details = $this->detailModel
            ->select('actual_activity_detail.*,actual_activity_detail.id as id_detail, activities.name as activity_name, projects.*')
            ->join('activities', 'activities.id = actual_activity_detail.activity_id')
            ->join('projects', 'projects.id = actual_activity_detail.project_id')
            ->where('actual_activity_detail.actual_activity_id', $id)
            ->where('actual_activity_detail.status', 1)
            ->orderBy('actual_activity_detail.start_time')
            ->findAll();
            
        $activities = $this->activityModel->where('status',1)->orderBy('name')->findAll();
        $projects   = (new ProjectModel())
            ->where('status', 1)
            ->orderBy('another_project')
            ->orderBy('jenis_tooling')
            ->findAll();
    
        $remarkSuggestions = (new ActualActivityDetailModel())
            ->where('created_by', session()->get('user_id'))
            ->where('created_at >=', date('Y-m-d', strtotime('-14 days')))
            ->findAll();
    
        return view('actual_activity/edit', [
            'actualActivity'    => $actualActivity,
            'details'           => $details,
            'activities'        => $activities,
            'projects'          => $projects,
            'remarkSuggestions' => $remarkSuggestions  
        ]);
    }
    
    public function update($id)
    {
        $db = \Config\Database::connect();
     
        try {
            
            // Validasi input
            $status =  2;
            $updatedBy = session()->get('user_id');
            $details = $this->request->getPost('details');
            $dates = $this->request->getPost('dates');
            // if (!$details || count($details) === 0) {
            //     throw new \Exception('Silakan tambahkan minimal satu detail aktivitas.');
            // }
    
            $actualActivityData = [
                'status'     => 2,
                'modified_by' => $updatedBy,
                'modified_at' => date('Y-m-d H:i:s'),
                'dates' => $dates,
            ];
           
            $update = $this->actualActivityModel->update($id, $actualActivityData);

            if (!$details || count($details) === 0) {
                // throw new \Exception('Silakan tambahkan minimal satu detail aktivitas.');
            }else{
            foreach ($details as $detail) {
                if (empty($detail['activity_id']) || empty($detail['project_id'])) {
                    throw new \Exception('Data detail tidak lengkap.');
                }
               
                $startTime = $detail['start_time'];
                $endTime   = $detail['end_time'];
    
                // if (strtotime($endTime) <= strtotime($startTime)) {
                //     throw new \Exception('Waktu selesai harus lebih besar dari waktu mulai.');
                // }
                $totalTime = $this->calculateTotalTime($startTime, $endTime);
        
                $project_id =null;
              
                // if (strpos($detail['project_id'], '-') !== false) {
                //     $parts = explode('-', $detail['project_id']);
                //     if (trim($parts[1]) != "19") {
                //         $project_id = $parts[1];
                //     } else {
                //         $project_id = explode('-', $detail['part_no'])[0];
                //     }
                // } else {
                //     $project_id = explode('-', $detail['part_no'])[0];
                // }
           
                if (strpos($detail['project_id'], '-') !== false) {
                    $parts = explode('-', $detail['project_id']);
                    // if (trim($parts[1]) != "19" && trim($parts[1]) != "726") {
                        if (strpos(trim($parts[0]), "Tooling Project") === false) {
                        $project_id = $parts[1];
                        
                    } else {
                        $project_id = explode('-', $detail['part_no'])[0];
                        
                    }
                } else {
                    $project_id = explode('-', $detail['part_no'])[0];
                }
                
           
                
                $detailData = [
                    'actual_activity_id' => $id,
                    'activity_id'        => $detail['activity_id'],
                    'project_id'         => $project_id,
                    'remark'             => $detail['remark'],
                    'start_time'         => $startTime,
                    'end_time'           => $endTime,
                    'total_time'         => $totalTime,
                    'progress'           => $detail['progress'],
                    'modified_by' => $updatedBy,
                ];
             
                $this->detailModel->insert($detailData);
            }
             
            }
        
        
    
            return redirect()->to('actual-activity/personal')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback(); 
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    public function detail($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $actualActivity = $this->actualActivityModel->find($id);
        if (!$actualActivity) {
            return redirect()->to(site_url('actual-activity'))->with('error', 'Data tidak ditemukan.');
        }
      ;
        $details = $this->detailModel
            ->select('actual_activity_detail.*,actual_activity_detail.id as id_detail, activities.name as activity_name, projects.*')
            ->join('activities', 'activities.id = actual_activity_detail.activity_id')
            ->join('projects', 'projects.id = actual_activity_detail.project_id')
            ->where('actual_activity_detail.actual_activity_id', $id)
            ->where('actual_activity_detail.status', 1)
            ->orderBy('actual_activity_detail.start_time')
            ->findAll();
          
        return view('actual_activity/detail', [
            'actualActivity' => $actualActivity,
            'details'        => $details,
        ]);
        
    }
    

    public function delete($id)
    {
        $activity = $this->actualActivityModel->find($id);
        if ($activity['status'] == 'submitted') {
            return redirect()->to('/actual-activity/personal')->with('error', 'Data tidak bisa dihapus karena sudah disubmit.');
        }
        $this->actualActivityModel->delete($id);
        return redirect()->to('/actual-activity/personal');
    }

    public function rollback($id)
    {
        $comment = $this->request->getGet('comment');
        $this->actualActivityModel->update($id, [
            'status' => 7,
            'comment' => $comment,
            'comment_by' =>session()->get('user_id')
        ]);

        return redirect()->to('/actual-activity')->with('success', 'Aktivitas berhasil dikembalikan.');
    }
    
    public function submit($id)
    {
       
        $this->actualActivityModel->update($id, [
            'status'      => 1,
            'comment'     => null,
            'comment_by'  => null,
            'modified_at' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('user_id')
        ]);
        $db = \Config\Database::connect();
    
        $existingCount = $db->table('outdoor_activities')
                            ->where('user_id', session()->get('user_id'))
                            ->where('DATE(created_at)', date('Y-m-d'))
                            ->countAllResults();
    
        if ($existingCount == 0) {
            $insertData[] = [
                'user_id'    => session()->get('user_id'),
                'kehadiran'  => 1,
                'keterangan' => 'Office R&D',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $db->table('outdoor_activities')->insertBatch($insertData);
        }
        return redirect()->to('/actual-activity/personal')->with('success', 'Aktivitas berhasil disubmit.');
  
    }
    
    public function deleteDetail()
    {
        if ($this->request->isAJAX()) {
            $id_detail = $this->request->getPost('id_detail');
    
            $detailModel = new ActualActivityDetailModel();
    
            $delete = $detailModel->delete($id_detail);
    
            if ($delete) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error']);
            }
        }
    
        return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
    
    private function calculateTotalTime($start, $end)
    {
        $startTime = \DateTime::createFromFormat('H:i', $start);
        $endTime   = \DateTime::createFromFormat('H:i', $end);
    
        if ($endTime <= $startTime) {
            $endTime->modify('+1 day');
        }
    
        $interval = $startTime->diff($endTime);
        $minutes = ($interval->h * 60) + $interval->i;
        return $minutes;
    }
    
    public function exportExcel() {
        $start_date = $this->request->getPost('start_date') ?: date('Y-m-01');
        $end_date   = $this->request->getPost('end_date') ?: date('Y-m-t');
        $db = \Config\Database::connect();
        $builder = $db->table('actual_activity_detail');
        $builder->select("users.nik, users.nama, actual_activity.dates, projects.jenis as project_jenis, projects.model as model, projects.part_no as part_no, projects.process as process, projects.proses as proses, activities.name as activity_name, actual_activity_detail.start_time, actual_activity_detail.end_time, actual_activity_detail.total_time, actual_activity_detail.progress");
        $builder->join('actual_activity', 'actual_activity.id = actual_activity_detail.actual_activity_id');
        $builder->join('activities', 'activities.id = actual_activity_detail.activity_id');
        $builder->join('projects', 'projects.id = actual_activity_detail.project_id');
        $builder->join('users', 'users.id = actual_activity.created_by');
        $builder->where("users.status", 1);
        $builder->where("actual_activity.status", 1);
        $builder->where("actual_activity_detail.status", 1);
        $builder->where("actual_activity.dates >= '$start_date'", null, false);
        $builder->where("actual_activity.dates <= '$end_date'", null, false);
        $builder->orderBy("actual_activity.dates", "DESC");
        $data = $builder->get()->getResultArray();
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Tanggal LKH');
        $sheet->setCellValue('D1', 'Project Jenis');
        $sheet->setCellValue('E1', 'Model');
        $sheet->setCellValue('F1', 'Part No');
        $sheet->setCellValue('G1', 'Process');
        $sheet->setCellValue('H1', 'Proses');
        $sheet->setCellValue('I1', 'Nama Aktivitas');
        $sheet->setCellValue('J1', 'Start Time');
        $sheet->setCellValue('K1', 'End Time');
        $sheet->setCellValue('L1', 'Total Time (Minute)');
        $sheet->setCellValue('M1', 'Progress (%)');
    
        $row = 2;
        foreach ($data as $record) {
            $sheet->setCellValue('A' . $row, $record['nik']);
            $sheet->setCellValue('B' . $row, $record['nama']);
            $sheet->setCellValue('C' . $row, $record['dates']); 
            $sheet->setCellValue('D' . $row, $record['project_jenis']);
            $sheet->setCellValue('E' . $row, $record['model']);
            $sheet->setCellValue('F' . $row, $record['part_no']);
            $sheet->setCellValue('G' . $row, $record['process']);
            $sheet->setCellValue('H' . $row, $record['proses']);
            $sheet->setCellValue('I' . $row, $record['activity_name']);
            $sheet->setCellValue('J' . $row, $record['start_time']);
            $sheet->setCellValue('K' . $row, $record['end_time']);
            $sheet->setCellValue('L' . $row, $record['total_time']);
            $sheet->setCellValue('M' . $row, $record['progress']);
            $row++;
        }
    
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'export_' . date('YmdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    
}