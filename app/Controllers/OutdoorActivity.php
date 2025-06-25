<?php
namespace App\Controllers;

use App\Models\OutdoorActivityModel;
use App\Models\UserModel;
use DateTime;

class OutdoorActivity extends BaseController {

    protected $activityModel;
    protected $userModel;
    protected $db;
    public function __construct(){
         $this->activityModel = new OutdoorActivityModel();
         $this->userModel = new UserModel();
         $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $db = \Config\Database::connect();
    
        $currentDay = date('N'); 
        $isWeekend = ($currentDay == 6 || $currentDay == 7);
    
        $holidayToday = $db->table('holidays')
            ->where('holiday_date', date('Y-m-d'))
            ->countAllResults();
    
        $userBuilder = $db->table('users');
        $userBuilder->select('id'); 
        $userBuilder->where('status', 1);
        $userBuilder->orderBy('nama');
       $userBuilder->where('group >', 0);
        $users = $userBuilder->get()->getResultArray();
    
        $existingUsersQuery = $db->table('outdoor_activities')
            ->select('user_id')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->get()
            ->getResultArray();
    
        $existingUsers = array_column($existingUsersQuery, 'user_id');
    
        $actualActivityQuery = $db->table('actual_activity')
            ->select('created_by as user_id, status')
            ->where('DATE(dates)', date('Y-m-d'))
            ->whereIn('status', [3, 4, 5, 6])
            ->get()
            ->getResultArray();
    
        $actualActivityData = [];
        foreach ($actualActivityQuery as $row) {
            $actualActivityData[$row['user_id']] = $row['status'];
        }
    
        $insertData = [];
        foreach ($users as $user) {
            $userId = $user['id'];
    
            if (!in_array($userId, $existingUsers)) {
                if (isset($actualActivityData[$userId])) {
                    $insertData[] = [
                        'user_id'    => $userId,
                        'kehadiran'  => $actualActivityData[$userId],
                        'keterangan' => '', 
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                } else {
                     if (!$isWeekend && $holidayToday == 0) {
                        $insertData[] = [
                            'user_id'    => $userId,
                            'kehadiran'  => 1,
                            'keterangan' => 'Office R&D',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
        }
    
        if (!empty($insertData)) {
            $db->table('outdoor_activities')->insertBatch($insertData);
        }
    
        $builder = $this->userModel->db->table('users u');
        $builder->select("u.*, 
            oa.id as activity_id, 
            oa.kehadiran, 
            oa.keterangan");
        $builder->where('u.status', 1);
        $builder->where('DATE(oa.created_at)', date('Y-m-d'));
        $builder->where('u.group !=', 0, false);
        $builder->orderBy('u.group');
        $builder->orderBy('u.nama');
        $builder->join('outdoor_activities oa', 'oa.user_id = u.id', 'inner');
    
        $query = $builder->get();
        $data['activities'] = $query->getResultArray();
    
        $activityBuilder = $this->userModel->db->table('outdoor_activities');
        $activityBuilder->select('kehadiran, COUNT(*) as total');
        $activityBuilder->where('DATE(outdoor_activities.created_at)', date('Y-m-d'));
        $activityBuilder->groupBy('kehadiran');
        $data['statusCounts'] = $activityBuilder->get()->getResultArray();
    
        $data['statusMapping'] = [
            1 => 'On',
            3 => 'Ganti Hari',
            4 => 'Izin',
            5 => 'Sakit',
            6 => 'Cuti',
            7 => 'Shift Malam'
        ];
    
        return view('outdoor_activity/index', $data);
    }
    
    public function display()
    {
        $db = \Config\Database::connect();
    
        $userCount = $db->table('users')
            ->where('status', 1)
          ->where('group >', 0)
            ->countAllResults();
    
        $today = new \DateTime();
    
        $monday = clone $today;
        $monday->modify('monday this week');
        $sunday = clone $today;
        $sunday->modify('sunday this week');
    
       
        $workingDaysPassed = 0;
        $iterator = clone $monday;
        while ($iterator <= $today) {
            if ($iterator->format('N') != 6 && $iterator->format('N') != 7) {
                $holidayExists = $db->table('holidays')
                    ->where('holiday_date', $iterator->format('Y-m-d'))
                    ->countAllResults();
                if ($holidayExists == 0) {
                    $workingDaysPassed++;
                } 
                // else {
                //     // Jika hari libur, periksa apakah ada kehadiran (status 1)
                //     $attendanceCount = $db->table('outdoor_activities')
                //         ->where('DATE(created_at)', $iterator->format('Y-m-d'))
                //         ->whereIn('kehadiran', [1])
                //         ->countAllResults();
                //     if ($attendanceCount > 0) {
                //         $workingDaysPassed++;
                //     }
                // }
            }
            $iterator->modify('+1 day');
        }
    
        $weeklyNonHadir = $db->table('outdoor_activities')
            ->where('DATE(created_at) >=', $monday->format('Y-m-d'))
            ->where('DATE(created_at) <=', $today->format('Y-m-d'))
            ->where("DAYOFWEEK(created_at) NOT IN (1,7)", null, false)
            ->whereIn('kehadiran', [3,4,5,6])
            ->countAllResults();
    
        $holidayListWeekly = $db->table('holidays')
            ->select('holiday_date')
            ->where('holiday_date >=', $monday->format('Y-m-d'))
            ->where('holiday_date <=', $sunday->format('Y-m-d'))
            ->get()
            ->getResultArray();
        $holidayDatesWeekly = array_map(function($item) {
            return $item['holiday_date'];
        }, $holidayListWeekly);
    
        $queryWeekly = $db->table('outdoor_activities')
            ->where('DATE(created_at) >=', $monday->format('Y-m-d'))
            ->where('DATE(created_at) <=', $sunday->format('Y-m-d'))
            ->whereIn('kehadiran', [1,7])
            ->groupStart();
        if (!empty($holidayDatesWeekly)) {
            $queryWeekly->whereIn('DATE(created_at)', $holidayDatesWeekly);
        }
        $queryWeekly->orWhere("DAYOFWEEK(created_at) IN (1,7)", null, false)
            ->groupEnd();
        $extraWeeklyAttendance = $queryWeekly->countAllResults();
    
        $extraPercentageWeekly = ($userCount > 0)
            ? ($extraWeeklyAttendance / $userCount) * 100
            : 0;

        $workingPercentageWeekly = ($userCount * $workingDaysPassed > 0)
        ? 100 - (($weeklyNonHadir / ($userCount * $workingDaysPassed + $extraPercentageWeekly)) * 100)
        : 100;
        
        $finalWeeklyPercentage = $workingPercentageWeekly;
    
        $firstDayOfMonth = (new DateTime('first day of this month'))->format('Y-m-d');
        $lastDayOfMonth  = (new DateTime('last day of this month'))->format('Y-m-d');
        $firstDayObj = new DateTime($firstDayOfMonth);
        $lastDayObj  = new DateTime($lastDayOfMonth);
    
        $workingDaysPassedMonth = 0;
        $iterator = clone $firstDayObj;
        while ($iterator <= $today && $iterator <= $lastDayObj) {
            if ($iterator->format('N') != 6 && $iterator->format('N') != 7) {
                $holidayExists = $db->table('holidays')
                    ->where('holiday_date', $iterator->format('Y-m-d'))
                    ->countAllResults();
                if ($holidayExists == 0) {
                    $workingDaysPassedMonth++;
                } else {
                    $attendanceCount = $db->table('outdoor_activities')
                        ->where('DATE(created_at)', $iterator->format('Y-m-d'))
                        ->whereIn('kehadiran', [1,7])
                        ->countAllResults();
                    if ($attendanceCount > 0) {
                        $workingDaysPassedMonth++;
                    }
                }
            }
            $iterator->modify('+1 day');
        }
    
        $monthlyNonHadir = $db->table('outdoor_activities')
            ->where('DATE(created_at) >=', $firstDayOfMonth)
            ->where('DATE(created_at) <=', $today->format('Y-m-d'))
            ->where("DAYOFWEEK(created_at) NOT IN (1,7)", null, false)
            ->whereIn('kehadiran', [3,4,5,6])
            ->countAllResults();
    
       
    
        $holidayListMonthly = $db->table('holidays')
            ->select('holiday_date')
            ->where('holiday_date >=', $firstDayOfMonth)
            ->where('holiday_date <=', $lastDayOfMonth)
            ->get()
            ->getResultArray();
        $holidayDatesMonthly = array_map(function($item) {
            return $item['holiday_date'];
        }, $holidayListMonthly);
    
        $queryMonthly = $db->table('outdoor_activities')
            ->where('DATE(created_at) >=', $firstDayOfMonth)
            ->where('DATE(created_at) <=', $today->format('Y-m-d'))
            ->whereIn('kehadiran', [1,7])
            ->groupStart();
        if (!empty($holidayDatesMonthly)) {
            $queryMonthly->whereIn('DATE(created_at)', $holidayDatesMonthly);
        }
        $queryMonthly->orWhere("DAYOFWEEK(created_at) IN (1,7)", null, false)
            ->groupEnd();
        $extraMonthlyAttendance = $queryMonthly->countAllResults();
    
        $extraPercentageMonthly = ($userCount > 0)
            ? ($extraMonthlyAttendance / $userCount) * 100
            : 0;
            $workingPercentageMonthly = ($userCount * $workingDaysPassedMonth > 0)
            ? 100 - (($monthlyNonHadir / ($userCount * $workingDaysPassedMonth+ $extraPercentageMonthly)) * 100)
            : 100;
        $finalMonthlyPercentage = $workingPercentageMonthly;
    
        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartData = [];
        foreach ($daysOfWeek as $day) {
            $chartData[$day] = ['hadir' => 0, 'tidak_hadir' => 0];
        }
        $weeklyData = $db->table('outdoor_activities')
            ->select("DATE(created_at) as date, kehadiran")
            ->where('DATE(created_at) >=', $monday->format('Y-m-d'))
            ->where('DATE(created_at) <=', $sunday->format('Y-m-d'))
            ->get()
            ->getResultArray();
    
        foreach ($weeklyData as $record) {
            $dateObj = new DateTime($record['date']);
            $dayIndex = $dateObj->format('N');
            $dayName = $daysOfWeek[$dayIndex - 1];
            if (in_array($record['kehadiran'], [1,7])) {
                $chartData[$dayName]['hadir']++;
            } elseif (in_array($record['kehadiran'], [3,4,5,6])) {
                $chartData[$dayName]['tidak_hadir']++;
            }
        }
    
        $builder = $this->userModel->db->table('users u');
        $builder->select("u.*, 
            oa.id as activity_id, 
            oa.kehadiran, 
            oa.keterangan");
        $builder->where('u.status', 1);
        $builder->where('DATE(oa.created_at)', date('Y-m-d'));
        $builder->where('u.group !=', 0, false);
        $builder->orderBy('u.group');
        $builder->join('outdoor_activities oa', 'oa.user_id = u.id', 'left');
        $query = $builder->get();
        $data['activities'] = $query->getResultArray();
    
        $activityBuilder = $db->table('outdoor_activities');
        $activityBuilder->select('kehadiran, COUNT(*) as total');
        $activityBuilder->where('DATE(outdoor_activities.created_at)', date('Y-m-d'));
        $activityBuilder->groupBy('kehadiran');
        $data['statusCounts'] = $activityBuilder->get()->getResultArray();
    
        $data['statusMapping'] = [
            1 => 'On',
            3 => 'Ganti Hari',
            4 => 'Izin',
            5 => 'Sakit',
            6 => 'Cuti',
            7 => 'Shift Malam'
        ];
    
        $holidayList = $db->table('holidays')
            ->select('holiday_date, description')
            ->where('holiday_date >=', $monday->format('Y-m-d'))
            ->where('holiday_date <=', $sunday->format('Y-m-d'))
            ->get()
            ->getResultArray();
        $data['holidayList'] = $holidayList;
    
        $data['weeklyPercentage'] = number_format($finalWeeklyPercentage, 2);
        $data['monthlyPercentage'] = number_format($finalMonthlyPercentage, 2);
        $data['chartData'] = $chartData;
        
 $today = date('Y-m-d');
$dayOfWeek = date('N'); // 1 = Senin, ..., 7 = Minggu

$data['piketToday'] = [];
$data['piketWeek'] = [];

if ($dayOfWeek < 6) {
    $daysUntilFriday = 5 - $dayOfWeek;
    $friday = date('Y-m-d', strtotime("+$daysUntilFriday days"));

    $builder = $db->table('piket_schedule p');
    $builder->select('p.date, u.nickname')
        ->join('users u', 'u.id = p.user_id')
        ->where('p.date >=', $today)
        ->where('p.date <=', $friday)
        ->orderBy('p.date')
        ->orderBy('u.nickname');

    $results = $builder->get()->getResultArray();

    foreach ($results as $row) {
        if ($row['date'] == $today) {
            $data['piketToday'][] = $row['nickname'];
        } else {
            $data['piketWeek'][$row['date']][] = $row['nickname'];
        }
    }
}

    
        return view('outdoor_activity/display', $data);
    }
    

    public function create() {
         $data['users'] = $this->userModel->findAll();
         return view('outdoor_activity/create', $data);
    }

    public function store() {
         $post = $this->request->getPost();
         $insertData = [
              'user_id'     => $post['user_id'],
              'kehadiran'   => isset($post['kehadiran']) ? 1 : 0,
              'cuti'        => isset($post['cuti']) ? 1 : 0,
              'genba'       => isset($post['genba']) ? 1 : 0,
              'night_shift' => isset($post['night_shift']) ? 1 : 0,
         ];
         $this->activityModel->insert($insertData);
         return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id) {
         $data['activity'] = $this->activityModel->find($id);
         $data['users'] = $this->userModel->findAll();
         return view('outdoor_activity/edit', $data);
    }

    public function update($id) {
        $post = $this->request->getPost();
        
        $keterangan = $post['status'] ?? '';
        $kehadiran = $post['kehadiran'] ?? '';
    
        $updateData = [
             'user_id'    => $post['user_id'],
             'kehadiran'  => $post['kehadiran'],
             'keterangan' => $keterangan
        ];
        $this->activityModel->update($id, $updateData);
        return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil diperbarui.');
    }
    
    
    public function delete($id) {
         $this->activityModel->delete($id);
         return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil dihapus.');
    }
    public function get_latest_data(){

        $builder = $this->userModel->db->table('users u');
        $builder->select("u.*, oa.id as activity_id, oa.kehadiran, oa.keterangan, u.group, u.nickname");
        $builder->where('u.status', 1);
        $builder->where('DATE(oa.created_at)', date('Y-m-d'));
        $builder->where('u.group !=', 0, false);
        $builder->orderBy('u.group');
        $builder->join('outdoor_activities oa', 'oa.user_id = u.id', 'left');
        $query = $builder->get();
        $activities = $query->getResultArray();

        $daysOfWeek = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $chartData = [];
        foreach ($daysOfWeek as $day) {
            $chartData[$day] = ['hadir' => 0, 'tidak_hadir' => 0];
        }
        $weeklyData = $this->db->table('outdoor_activities')
            ->select("DATE(created_at) as date, kehadiran")
            ->where('DATE(created_at) >=', date('Y-m-d', strtotime('monday this week')))
            ->where('DATE(created_at) <=', date('Y-m-d', strtotime('sunday this week')))
            ->get()
            ->getResultArray();
        foreach ($weeklyData as $record) {
            $dateObj = new DateTime($record['date']);
            $dayIndex = $dateObj->format('N'); 
            $dayName = $daysOfWeek[$dayIndex - 1];
            if (in_array($record['kehadiran'], [1,7])) {
                $chartData[$dayName]['hadir']++;
            } elseif (in_array($record['kehadiran'], [3,4,5,6])) {
                $chartData[$dayName]['tidak_hadir']++;
            }
        }
      
        $weeklyPercentage = 70; 
        $monthlyPercentage = 75; 

        $monday = new DateTime('monday this week');
        $sunday = new DateTime('sunday this week');
        $holidayList = $this->db->table('holidays')
            ->select('holiday_date, description')
            ->where('holiday_date >=', $monday->format('Y-m-d'))
            ->where('holiday_date <=', $sunday->format('Y-m-d'))
            ->get()
            ->getResultArray();

        $data = [
            'activities' => $activities,
            'chartData' => $chartData,
            'weeklyPercentage' => $weeklyPercentage,
            'monthlyPercentage' => $monthlyPercentage,
            'holidayList' => $holidayList
        ];
        echo json_encode($data);
    }
}
