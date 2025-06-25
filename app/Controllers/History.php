<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActualActivityModel;
use App\Models\OutdoorActivityModel;
class History extends BaseController
{
    protected $userModel;
    protected $activityModel;
    protected $OutdoorActivityModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->activityModel = new ActualActivityModel();
        $this->OutdoorActivityModel = new OutdoorActivityModel();
    }
    public function index()
    {
        $userModel = new UserModel();
        $activityModel = new ActualActivityModel();
        $holidayModel = new \App\Models\HolidayModel();
    
        $selectedWeek = $this->request->getGet('week') ?: date('Y-m-d', strtotime('monday this week'));
    
        $weeks = [];
        for ($i = 0; $i < 10; $i++) {
            $startOfWeek = date('Y-m-d', strtotime("monday -$i weeks"));
            $endOfWeek   = date('Y-m-d', strtotime($startOfWeek . " +6 days"));
            $weeks[$startOfWeek] = date('d M', strtotime($startOfWeek)) . " - " . date('d M', strtotime($endOfWeek));
        }
    
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = date('Y-m-d', strtotime($selectedWeek . " +$i days"));
        }
    
        $users = $userModel->where('status', 1)
                           ->where('role_id !=', 6)
                           ->orderBy('nama', 'asc')
                           ->findAll();
    
        $holidaysForWeek = $holidayModel->whereIn('holiday_date', $dates)->findAll();
        $holidayDates = [];
        foreach ($holidaysForWeek as $holiday) {
            if (date('N', strtotime($holiday['holiday_date'])) <= 7) {
                $holidayDates[] = $holiday['holiday_date'];
            }
        }
        $holidayDates = array_unique($holidayDates); 
        $weekdayCount = 0;
        foreach ($dates as $date) {
            if (date('N', strtotime($date)) <= 5) {
                $weekdayCount++;
            }
        }
        $workingDays = $weekdayCount - count($holidayDates);
        if ($workingDays < 1) {
            $workingDays = 1;
        }
    
        $userPercentages = [];
        foreach ($users as $key => $user) {
            $users[$key]['status_pengisian'] = [];
            $filledDays = 0;
            foreach ($dates as $date) {
                $dayOfWeek = date('N', strtotime($date));
                if ($dayOfWeek <= 7) { 
                    if (in_array($date, $holidayDates)) {
                        $users[$key]['status_pengisian'][$date] = 'holiday';
                        continue; 
                    }
                    $activity = $activityModel
                        ->where('created_by', $user['id'])
                        ->whereIn('status', [1, 3, 4, 5, 6])
                        ->where('DATE(dates)', $date)
                        ->first();
                    $users[$key]['status_pengisian'][$date] = $activity ? $activity['status'] : 0;
                    if ($activity) {
                        $filledDays++;
                    }
                } else {
                    $users[$key]['status_pengisian'][$date] = 0;
                }
            }
            $userPercentages[$user['id']] = ($filledDays / $workingDays) * 100;
        }
    
        $datePercentages = [];
        foreach ($dates as $date) {
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek <= 7) {
                if (in_array($date, $holidayDates)) {
                    $datePercentages[$date] = 0;
                    continue;
                }
                $filledUsers = 0;
                foreach ($users as $user) {
                    if ($user['status_pengisian'][$date] && in_array($user['status_pengisian'][$date], [1, 3, 4, 5, 6])) {
                        $filledUsers++;
                    }
                }
                $datePercentages[$date] = count($users) > 0 ? ($filledUsers / count($users)) * 100 : 0;
            } else {
                $datePercentages[$date] = 0;
            }
        }
    
        $data = [
            'title'           => 'Riwayat Pengisian',
            'users'           => $users,
            'dates'           => $dates,
            'userPercentages' => $userPercentages,
            'datePercentages' => $datePercentages,
            'weeks'           => $weeks,
            'selectedWeek'    => $selectedWeek,
            'holidayDates'    => $holidayDates  
        ];
        return view('history/index', $data);
    }
    public function calendar()
    {
        $session = session();
        $currentUserId = $session->get('user_id');
    
        $izinData = $this->activityModel
            ->select('actual_activity.id, actual_activity.dates, actual_activity.status, users.nickname')
            ->join('users', 'users.id = actual_activity.created_by', 'left')
            ->whereIn('actual_activity.status', [3, 4, 5, 6])
            ->findAll();
    
        $holidayModel = new \App\Models\HolidayModel();
        $holidayData = $holidayModel->findAll();
    
        $calendarModel = new \App\Models\CalendarModel();
        $calendarData = $calendarModel
            ->groupStart()
            ->where('is_private', 0)
            ->orWhere('is_private', 1)
            ->where('created_by', $currentUserId)
            ->groupEnd()
            ->findAll();
    
        $events = [];
    
        foreach ($izinData as $row) {
            $className = 'fc-bg-primary';
            switch ($row['status']) {
                case 3: $label = 'Ganti Hari'; break;
                case 4: $label = 'Izin'; break;
                case 5: $label = 'Sakit'; break;
                case 6: $label = 'Cuti'; break;
                default: $label = 'Lainnya'; $className = 'fc-bg-warning'; break;
            }
    
            $events[] = [
                'title' => $row['nickname'] . ' - ' . $label,
                'start' => $row['dates'],
                'allDay' => true,
                'classNames' => [$className],
                'eventType' => 'izin',
                'idEvent' => 'izin_' . $row['id']
            ];
        }
    
        foreach ($holidayData as $holiday) {
            $tanggal = date('Y-m-d', strtotime($holiday['holiday_date']));
    
            // background event
            $events[] = [
                'start' => $tanggal,
                'allDay' => true,
                'display' => 'background',
                'backgroundColor' => '#dc3545',
                'borderColor' => '#dc3545',
                'eventType' => 'holiday_bg'
            ];
    
            if ($holiday['description'] != null) {
                $events[] = [
                    'title' => $holiday['description'],
                    'start' => $tanggal,
                    'allDay' => true,
                    'textColor' => '#ffffff',
                    'backgroundColor' => '#dc3545',
                    'borderColor' => '#dc3545',
                    'eventType' => 'holiday',
                    'idEvent' => 'holiday_' . $holiday['id']
                ];
            }
        }
    
        foreach ($calendarData as $row) {
            $events[] = [
                'title' => $row['title'],
                'start' => $row['date'],
                'start_time' => $row['start_time'] ?? null,
                'isPrivate' => $row['is_private'],
                'createdBy' => $row['created_by'],
                'allDay' => true,
                'eventType' => 'calendar',
                'idEvent' => 'calendar_' . $row['id']
            ];
        }
    
        return view('history/calendar', ['events' => json_encode($events)]);
    }
    
    public function getCalendarEvents()
    {
        $session = session();
        $currentUserId = $session->get('user_id');
    
        $izinData = $this->activityModel
            ->select('actual_activity.id, actual_activity.dates, actual_activity.status, users.nickname')
            ->join('users', 'users.id = actual_activity.created_by', 'left')
            ->whereIn('actual_activity.status', [3, 4, 5, 6])
            ->findAll();
    
       
        $holidayModel = new \App\Models\HolidayModel();
        $holidayData = $holidayModel->findAll();
    
        $calendarModel = new \App\Models\CalendarModel();
        $calendarData = $calendarModel
        ->groupStart()  
        ->where('is_private', 0)  
        ->orWhere('is_private', 1)  
        ->where('created_by', $currentUserId) 
        ->groupEnd()  
        ->findAll();
    
        if ($calendarData === false) {
            log_message('error', 'Error fetching calendar data');
            return $this->response->setJSON([
                'error' => 'Failed to retrieve calendar events'
            ]);
        }
    
        $events = [];
    
        foreach ($izinData as $row) {
            switch ($row['status']) {
                case 3:
                    $statusLabel = 'GH';
                    $className = 'fc-bg-primary';
                    break;
                case 4:
                    $statusLabel = 'Izin';
                    $className = 'fc-bg-primary';
                    break;
                case 5:
                    $statusLabel = 'Sakit';
                    $className = 'fc-bg-primary';
                    break;
                case 6:
                    $statusLabel = 'Cuti';
                    $className = 'fc-bg-primary';
                    break;
                default:
                    $statusLabel = 'Lainnya';
                    $className = 'fc-bg-warning';
            }
    
            $events[] = [
                'title' => $row['nickname'] . ' - ' . $statusLabel,
                'start' => $row['dates'],
                'allDay' => true,
                'classNames' => [$className],
                'eventType' => 'izin',  
                'idEvent' => 'izin_' . $row['id'] 
            ];
        }
    
        foreach ($holidayData as $holiday) {
            $tanggal = date('Y-m-d', strtotime($holiday['holiday_date']));
    
            $events[] = [
                'start' => $tanggal,
                'allDay' => true,
                'display' => 'background',
                'backgroundColor' => '#dc3545',
                'borderColor' => '#dc3545',
                'eventType' => 'holiday_bg'
            ];
    
            if ($holiday['description'] != null) {
                $events[] = [
                    'title' => $holiday['description'],
                    'start' => $tanggal,
                    'allDay' => true,
                    'textColor' => '#ffffff',
                    'backgroundColor' => '#dc3545',
                    'borderColor' => '#dc3545',
                    'eventType' => 'holiday',
                    'idEvent' => 'holiday_' . $holiday['id'] 
                ];
            }
        }
    
        foreach ($calendarData as $row) {
            $events[] = [
                'idEvent' => 'calendar_' . $row['id'], 
                'title' => $row['title'],
                'start' => $row['date'],
                'notes' => $row['notes'],
                'start_time' => $row['start_time'],
                'backgroundColor' => '#ffc107', 
                'borderColor' => '#ffc107',     
                'textColor' => '#000000',      
                'eventType' => 'calendar' 
            ];
        }
    
        return $this->response->setJSON($events);
    }
    

    public function indexMonthly()
    {
        $userModel = new UserModel();
        $activityModel = new ActualActivityModel();
        $holidayModel = new \App\Models\HolidayModel();

        $selectedMonth = $this->request->getGet('month') ?: date('Y-m');

        $months = [];
        for ($i = 0; $i < 16; $i++) {
            $monthTimestamp = strtotime("-$i months");
            $monthValue = date('Y-m', $monthTimestamp);
            $monthLabel = date('M Y', $monthTimestamp);
            $months[$monthValue] = $monthLabel;
        }

        $startDate = $selectedMonth . '-01';
        $endDate   = date('Y-m-t', strtotime($startDate)); 

        $dates = [];
        $currentDate = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        while ($currentDate <= $endTimestamp) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        $users = $userModel->where('status', 1)
                        ->where('role_id !=', 6)
                        ->orderBy('nama', 'asc')
                        ->findAll();

        $holidaysForMonth = $holidayModel->whereIn('holiday_date', $dates)->findAll();
        $holidayDates = [];
        foreach ($holidaysForMonth as $holiday) {
            if (date('N', strtotime($holiday['holiday_date'])) <= 5) {
                $holidayDates[] = $holiday['holiday_date'];
            }
        }
        $holidayDates = array_unique($holidayDates);

        $weekdayCount = 0;
        foreach ($dates as $date) {
            if (date('N', strtotime($date)) <= 5) {
                $weekdayCount++;
            }
        }
        $workingDays = $weekdayCount - count($holidayDates);
        if ($workingDays < 1) {
            $workingDays = 1;
        }

        $userPercentages = [];
        foreach ($users as $key => $user) {
            $users[$key]['status_pengisian'] = [];
            $filledDays = 0;
            foreach ($dates as $date) {
                if (date('N', strtotime($date)) <= 7) {
                    if (in_array($date, $holidayDates)) {
                        $users[$key]['status_pengisian'][$date] = 'holiday';
                        continue;
                    }
                    $activity = $activityModel
                        ->where('created_by', $user['id'])
                        ->whereIn('status', [1, 3, 4, 5, 6, 7])
                        ->where('DATE(dates)', $date)
                        ->first();
                    $users[$key]['status_pengisian'][$date] = $activity ? $activity['status'] : 0;
                    if ($activity && $activity['status'] == 1) {
                        $filledDays++;
                    }
                } else {
                    $users[$key]['status_pengisian'][$date] = 0;
                }
            }
            $userPercentages[$user['id']] = ($filledDays / $workingDays) * 100;
        }
        $datePercentages = [];
        foreach ($dates as $date) {
            if (date('N', strtotime($date)) <= 7) {
                if (in_array($date, $holidayDates)) {
                    $datePercentages[$date] = 0;
                    continue;
                }
                $filledUsers = 0;
                foreach ($users as $user) {
                    if (isset($user['status_pengisian'][$date]) && $user['status_pengisian'][$date] == 1) {
                        $filledUsers++;
                    }
                }
                $datePercentages[$date] = count($users) > 0 ? ($filledUsers / count($users)) * 100 : 0;
            } else {
                $datePercentages[$date] = 0;
            }
        }

        $data = [
            'title'           => 'Riwayat Pengisian Bulanan',
            'users'           => $users,
            'dates'           => $dates,
            'userPercentages' => $userPercentages,
            'datePercentages' => $datePercentages,
            'months'          => $months,
            'selectedMonth'   => $selectedMonth,
            'holidayDates'    => $holidayDates
        ];

        return view('history/indexMonthly', $data);
    }

    // public function index()
    // {
    //     $userModel = new UserModel();
    //     $activityModel = new ActualActivityModel();

    //     $selectedWeek = $this->request->getGet('week') ?: date('Y-m-d', strtotime('monday this week'));

    //     $weeks = [];
    //     for ($i = 0; $i < 10; $i++) { 
    //         $startOfWeek = date('Y-m-d', strtotime("monday -$i weeks"));
    //         $endOfWeek   = date('Y-m-d', strtotime($startOfWeek . " +6 days")); 
    //         $weeks[$startOfWeek] = date('d M', strtotime($startOfWeek)) . " - " . date('d M', strtotime($endOfWeek));
    //     }
    //     $dates = [];
    //     for ($i = 0; $i < 7; $i++) {
    //         $dates[] = date('Y-m-d', strtotime($selectedWeek . " +$i days"));
    //     }

    //     $users = $userModel->where('status', 1)
    //         ->where('role_id !=', 6)
    //         ->orderBy('nama', 'asc')
    //         ->findAll();

    //     $userPercentages = [];
    //     foreach ($users as $key => $user) {
    //         $users[$key]['status_pengisian'] = [];
    //         $filledDays = 0;
    //         $weekdayCount = 0;

    //         foreach ($dates as $date) {
    //             $dayOfWeek = date('N', strtotime($date));
    //             if ($dayOfWeek <= 5) { // Senin - Jumat
    //                 $weekdayCount++;
    //                 $activity = $activityModel
    //                     ->where('created_by', $user['id'])
    //                     ->whereIn('status', [1, 3, 4, 5])
    //                     ->where('DATE(dates)', $date)
    //                     ->first();
                    
    //                 $users[$key]['status_pengisian'][$date] = $activity ? $activity['status'] : 0;
    //                 if ($activity && $activity['status'] == 1) {
    //                     $filledDays++;
    //                 }
    //             } else {
    //                 $users[$key]['status_pengisian'][$date] = 0;
    //             }
    //         }

    //         $userPercentages[$user['id']] = $weekdayCount > 0 ? ($filledDays / $weekdayCount) * 100 : 0;
    //     }

    //     $datePercentages = [];
    //     foreach ($dates as $date) {
    //         $dayOfWeek = date('N', strtotime($date));
    //         if ($dayOfWeek <= 5) {
    //             $filledUsers = 0;
    //             foreach ($users as $user) {
    //                 if ($user['status_pengisian'][$date] && in_array($user['status_pengisian'][$date], [1])) {
    //                     $filledUsers++;
    //                 }
    //             }
    //             $datePercentages[$date] = count($users) > 0 ? ($filledUsers / count($users)) * 100 : 0;
    //         } else {
    //             $datePercentages[$date] = 0;
    //         }
    //     }

    //     $data = [
    //         'title'           => 'Riwayat Pengisian',
    //         'users'           => $users,
    //         'dates'           => $dates,
    //         'userPercentages' => $userPercentages,
    //         'datePercentages' => $datePercentages,
    //         'weeks'           => $weeks,
    //         'selectedWeek'    => $selectedWeek
    //     ];

    //     return view('history/index', $data);
    // }

    public function profile()
    {
        $session = session();
        $user_id = $session->get('user_id');
    
        if (!$user_id) {
            return redirect()->to(site_url('login'));
        }
    
        $db = \Config\Database::connect();
    
        $builderUser = $db->table('users');
        $builderUser->select('users.*, roles.role_name');
        $builderUser->join('roles', 'roles.id = users.role_id', 'left');
        $builderUser->where('users.id', $user_id);
        $user = $builderUser->get()->getRowArray();
    
        $start_date = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->request->getGet('end_date') ?: date('Y-m-d');
    
        $builder = $db->table('actual_activity_detail');
        $builder->select('DATE_FORMAT(actual_activity.dates, "%Y-%m-%d") as date,  
                          TIME_FORMAT(actual_activity_detail.start_time, "%H:%i") as time, 
                          actual_activity_detail.total_time as total_time, 
                          TIME_FORMAT(actual_activity_detail.end_time, "%H:%i") as end_time, 
                          activities.name as activity_name, 
                          projects.model, 
                           projects.process, 
                          projects.proses, 
                           projects.part_no, 
                              actual_activity_detail.id as idss , 
                                actual_activity_detail.remark as remark , 
                          projects.another_project');
        $builder->join('actual_activity', 'actual_activity_detail.actual_activity_id = actual_activity.id', 'left');
        $builder->join('activities', 'actual_activity_detail.activity_id = activities.id', 'left');
        $builder->join('projects', 'projects.id = actual_activity_detail.project_id', 'left');
    
        $builder->where('actual_activity.created_by', $user_id);
        $builder->where('actual_activity.status', 1);
        $builder->where('actual_activity_detail.status', 1);
        $builder->where('actual_activity.dates >=', $start_date);
        $builder->where('actual_activity.dates <=', $end_date);
    
        $builder->orderBy('actual_activity.dates', 'DESC');
        $builder->orderBy('actual_activity_detail.start_time', 'ASC');
    
        $results = $builder->get()->getResultArray();
    
        $timelineData = [];
        foreach ($results as $row) {
            $month = date('F, Y', strtotime($row['date']));
            $timelineData[$month][] = $row;
        }

        $data = [
            'user'         => $user,
            'timelineData' => $timelineData,
            'start_date'   => $start_date,
            'end_date'     => $end_date,
        ];
    
        return view('user/profile', $data);
    }
    
    public function detailProfil($encrypted_id) 
    {
        $session = session();
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $user_id = $id;

        if (!$user_id) {
            return redirect()->to(site_url('login'));
        }

        $start_date = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->request->getGet('end_date') ?: date('Y-m-d');

        $db = \Config\Database::connect();
        
        $builderUser = $db->table('users');
        $builderUser->select('users.*, roles.role_name');
        $builderUser->join('roles', 'roles.id = users.role_id', 'left');
        $builderUser->where('users.id', $user_id);
        $user = $builderUser->get()->getRowArray();

        $builder = $db->table('actual_activity_detail');
        $builder->select('DATE_FORMAT(actual_activity.dates, "%Y-%m-%d") as date,  
                        TIME_FORMAT(actual_activity_detail.start_time, "%H:%i") as time, 
                        actual_activity_detail.total_time as total_time, 
                        TIME_FORMAT(actual_activity_detail.end_time, "%H:%i") as end_time, 
                        activities.name as activity_name, 
                        projects.model, 
                        projects.process, 
                        projects.proses, 
                        projects.part_no, 
                        actual_activity_detail.id as idss, 
                        actual_activity_detail.remark as remark, 
                        projects.another_project');
        $builder->join('actual_activity', 'actual_activity_detail.actual_activity_id = actual_activity.id', 'left');
        $builder->join('activities', 'actual_activity_detail.activity_id = activities.id', 'left');
        $builder->join('projects', 'projects.id = actual_activity_detail.project_id', 'left');

        $builder->where('actual_activity.created_by', $user_id);
        $builder->where('actual_activity.status', 1);
        $builder->where('actual_activity_detail.status', 1);
        $builder->where('actual_activity.dates >=', $start_date);
        $builder->where('actual_activity.dates <=', $end_date);

        $builder->orderBy('actual_activity.dates', 'DESC');
        $builder->orderBy('actual_activity_detail.start_time', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();
        
        $timelineData = [];
        foreach ($results as $row) {
            $month = date('F, Y', strtotime($row['date']));
            $timelineData[$month][] = $row;
        }

        $data = [
            'user'         => $user,
            'timelineData' => $timelineData,
            'start_date'   => $start_date, 
            'end_date'     => $end_date
        ];

        return view('user/profile', $data);
    }

    public function create()
    {
        $data['users'] = $this->userModel->where('status', 1)
                                        ->orderBy('nama', 'ASC')
                                        ->findAll();
        return view('history/create', $data);
    }
//     public function store()
//     {
//         $user_id  = $this->request->getPost('user_id');
//         $tanggal  = $this->request->getPost('dates');
//         $status   = $this->request->getPost('status');
// //if $tanggal == hari ini
// // select * from outdoor activity where user_id = $user_id and created_at today
// // if found 

// //  update outdoor_activity set kehadiran = $status where user_id = $user_id and created_at today)
//         if ( !$tanggal || !$status) {
//             return redirect()->back()->withInput()->with('error', 'Semua field harus diisi.');
//         }
//         $data = [
//             'created_by' => $user_id,
//             'dates'      => $tanggal,
//             'status'     => $status,
//             'created_at' => date('Y-m-d H:i:s'),
//         ];
//         // Simpan data
//         $this->activityModel->insert($data);

//         return redirect()->to(site_url('history'))->with('success', 'Data perizinan berhasil disimpan.');
//     }
    public function store()
    {
        $user_id  = $this->request->getPost('user_id');
        $tanggal  = $this->request->getPost('dates');
        $status   = $this->request->getPost('status');

        if ( !$tanggal || !$status) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi.');
        }

        $today = date('Y-m-d');

        if ($tanggal == $today) {
            $existingRecord = $this->OutdoorActivityModel
                ->where('user_id', $user_id)
                ->where('created_at >=', $today . ' 00:00:00')
                ->where('created_at <=', $today . ' 23:59:59')
                ->first();

            if ($existingRecord) {
              
                $updateData = [
                    'status'     => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->OutdoorActivityModel->update($existingRecord['id'], $updateData);
                // return redirect()->to(site_url('history'))->with('success', 'Data perizinan berhasil diperbarui.');
            }
        }

        $data = [
            'created_by' => $user_id,
            'dates'      => $tanggal,
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->activityModel->insert($data);

        return redirect()->to(site_url('history'))->with('success', 'Data perizinan berhasil disimpan.');
    }


}
