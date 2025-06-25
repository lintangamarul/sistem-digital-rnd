<?php

namespace App\Controllers;

use App\Models\BriefingModel;
use App\Models\BriefingScheduleModel;
use App\Models\UserModel;

class BriefingController extends BaseController
{
    protected $briefingModel;
    protected $scheduleModel;
    protected $userModel;

    public function __construct()
    {
        $this->briefingModel = new BriefingModel();
        $this->scheduleModel = new BriefingScheduleModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal Pemimpin Briefing',
            'leaders' => $this->briefingModel->getActiveLeaders(),
            'available_users' => $this->briefingModel->getAvailableUsers()
        ];

        return view('briefing/index', $data);
    }

    public function calendar()
    {
        // Generate schedule for 3 months ahead
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+3 months'));
        
        $schedule = $this->briefingModel->generateSchedule($startDate, $endDate);
        $leaders = $this->briefingModel->getActiveLeaders();
        
        $data = [
            'title' => 'Kalender Jadwal Briefing',
            'schedule' => $schedule,
            'leaders' => $leaders,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        return view('briefing/calendar', $data);
    }

    public function updateOrder()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $orderData = $this->request->getJSON(true);
        
        if ($this->briefingModel->updateOrder($orderData['order'])) {
            return $this->response->setJSON(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui urutan']);
        }
    }

    public function addLeader()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }

    $userId = $this->request->getPost('user_id');
    
    // Cek apakah user sudah ada dalam daftar
    $existing = $this->briefingModel->where('user_id', $userId)->where('is_active', 1)->first();
    if ($existing) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'User sudah ada dalam daftar pemimpin'
        ]);
    }
    
    // Get current max order
    $maxOrder = $this->briefingModel->selectMax('order_sequence')->first();
    $nextOrder = ($maxOrder['order_sequence'] ?? 0) + 1;
    
    $data = [
        'user_id' => $userId,
        'order_sequence' => $nextOrder,
        'is_active' => 1
    ];
    
    if ($this->briefingModel->insert($data)) {
        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Pemimpin berhasil ditambahkan'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Gagal menambahkan pemimpin'
        ]);
    }
}


    public function removeLeader($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        if ($this->briefingModel->delete($id)) {
            // Reorder remaining leaders
            $this->reorderLeaders();
            return $this->response->setJSON(['success' => true, 'message' => 'Pemimpin berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pemimpin']);
        }
    }

    private function reorderLeaders()
    {
        $leaders = $this->briefingModel->where('is_active', 1)->orderBy('order_sequence', 'ASC')->findAll();
        foreach ($leaders as $index => $leader) {
            $this->briefingModel->update($leader['id'], ['order_sequence' => $index + 1]);
        }
    }

    // Perbaikan pada method getEvents() di BriefingController
public function getEvents()
{
    try {
        $startDate = $this->request->getGet('start') ?: date('Y-m-d');
        $endDate = $this->request->getGet('end') ?: date('Y-m-d', strtotime('+1 month'));
        
        log_message('info', "Getting events from {$startDate} to {$endDate}");
        
        $schedule = $this->briefingModel->generateSchedule($startDate, $endDate);
        $events = [];
        
        // Get holidays dalam rentang tanggal
        $db = \Config\Database::connect();
        $holidays = $db->table('holidays')
                       ->select('holiday_date, description')
                       ->where('holiday_date >=', $startDate)
                       ->where('holiday_date <=', $endDate)
                       ->get()
                       ->getResultArray();
        
        log_message('info', "Found " . count($holidays) . " holidays");
        log_message('info', "Generated " . count($schedule) . " schedule items");
        
        // Tambahkan event holiday
        foreach ($holidays as $holiday) {
            $events[] = [
                'id' => 'holiday_' . $holiday['holiday_date'],
                'title' => $holiday['description'],
                'start' => $holiday['holiday_date'],
                'backgroundColor' => '#e74c3c',
                'borderColor' => '#e74c3c',
                'textColor' => '#fff',
                'className' => 'fc-holiday-event',
                'allDay' => true,
                'extendedProps' => [
                    'type' => 'holiday',
                    'description' => $holiday['description']
                ]
            ];
        }
        
        // Tambahkan event briefing
        foreach ($schedule as $item) {
            // Check if there's an absence record
            $absenceRecord = null;
            if (isset($this->scheduleModel)) {
                $absenceRecord = $this->scheduleModel->getScheduleByDate($item['date']);
            }
            
            if ($absenceRecord && !$absenceRecord['is_present']) {
                if ($absenceRecord['replacement_user_id']) {
                    // PERBAIKAN: Cek apakah ini adalah swap schedule
                    $isSwapSchedule = strpos($absenceRecord['notes'], 'Tukar jadwal') !== false;
                    
                    if ($isSwapSchedule) {
                        // Event untuk jadwal yang ditukar
                        $events[] = [
                            'id' => 'swap_' . $item['date'],
                            'title' => $absenceRecord['replacement_name'] . ' (Tukar Jadwal)',
                            'start' => $item['date'],
                            'backgroundColor' => '#17a2b8',
                            'borderColor' => '#17a2b8',
                            'textColor' => '#fff',
                            'className' => 'fc-swap-event',
                            'allDay' => true,
                            'extendedProps' => [
                                'type' => 'swap',
                                'original_user_id' => $item['user_id'],
                                'original_user_name' => $item['user_name'],
                                'replacement_user_id' => $absenceRecord['replacement_user_id'],
                                'replacement_user_name' => $absenceRecord['replacement_name'],
                                'user_name' => $absenceRecord['replacement_name'],
                                'notes' => $absenceRecord['notes']
                            ]
                        ];
                    } else {
                        // Replacement event biasa
                        $events[] = [
                            'id' => 'replacement_' . $item['date'],
                            'title' => $absenceRecord['replacement_name'] . ' (Pengganti)',
                            'start' => $item['date'],
                            'backgroundColor' => '#ffc107',
                            'borderColor' => '#ffc107',
                            'textColor' => '#000',
                            'className' => 'fc-replacement-event',
                            'allDay' => true,
                            'extendedProps' => [
                                'type' => 'replacement',
                                'original_user_id' => $item['user_id'],
                                'original_user_name' => $item['user_name'],
                                'replacement_user_id' => $absenceRecord['replacement_user_id'],
                                'replacement_user_name' => $absenceRecord['replacement_name'],
                                'user_name' => $absenceRecord['replacement_name'],
                                'notes' => $absenceRecord['notes']
                            ]
                        ];
                    }
                } else {
                    // Absent event
                    $events[] = [
                        'id' => 'absent_' . $item['date'],
                        'title' => $item['user_name'] . ' (ABSEN)',
                        'start' => $item['date'],
                        'backgroundColor' => '#dc3545',
                        'borderColor' => '#dc3545',
                        'textColor' => '#fff',
                        'className' => 'fc-absent-event',
                        'allDay' => true,
                        'extendedProps' => [
                            'type' => 'absent',
                            'user_id' => $item['user_id'],
                            'user_name' => $item['user_name'],
                            'notes' => $absenceRecord['notes']
                        ]
                    ];
                }
            } else {
                // Normal briefing event
                $events[] = [
                    'id' => 'briefing_' . $item['date'],
                    'title' => $item['user_name'],
                    'start' => $item['date'],
                    'backgroundColor' => '#28a745',
                    'borderColor' => '#28a745',
                    'textColor' => '#fff',
                    'className' => 'fc-briefing-event',
                    'allDay' => true,
                    'extendedProps' => [
                        'type' => 'briefing',
                        'user_id' => $item['user_id'],
                        'user_name' => $item['user_name'],
                        'user_nik' => $item['user_nik']
                    ]
                ];
            }
        }
        
        log_message('info', "Returning " . count($events) . " events");
        
        return $this->response->setJSON($events);
        
    } catch (\Exception $e) {
        log_message('error', 'Error in getEvents: ' . $e->getMessage());
        return $this->response->setJSON([]);
    }
}

    public function getUserSchedule($userId)
{
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+3 months'));
    
    $user = $this->userModel->find($userId);
    if (!$user) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
    }
    
    $schedule = $this->briefingModel->getUserSchedule($userId, $startDate, $endDate);
    
    // Convert to indexed array to avoid key issues
    $schedule = array_values($schedule);
    
    $data = [
        'title' => 'Jadwal Briefing - ' . $user['nama'],
        'user' => $user,
        'schedule' => $schedule
    ];

    return view('briefing/user_schedule', $data);
}

    public function markAbsent()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $requestData = $this->request->getJSON(true);
        $date = $requestData['date'];
        $userId = $requestData['user_id'];
        $replacementId = $requestData['replacement_id'] ?? null;
        $notes = $requestData['notes'] ?? null;

        if ($this->scheduleModel->markAbsent($date, $userId, $replacementId, $notes)) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status absen berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Gagal menyimpan status absen'
            ]);
        }
    }

    public function getScheduleDetail()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }

    $date = $this->request->getGet('date');
    if (!$date) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Tanggal tidak valid'
        ]);
    }

    // Get schedule for the SPECIFIC date
    $schedule = $this->briefingModel->generateSchedule($date, $date);
    if (empty($schedule)) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Tidak ada jadwal briefing untuk tanggal ini'
        ]);
    }

    $scheduleItem = $schedule[0];
    
    // PERBAIKAN: Get absence record yang lebih detail
    $absenceRecord = $this->scheduleModel->getScheduleByDate($date);
    
    // PERBAIKAN: Jika ada absence record, update schedule item dengan info pengganti
    if ($absenceRecord && !$absenceRecord['is_present']) {
        // Update schedule item dengan info pengganti
        $scheduleItem['status'] = 'absent';
        $scheduleItem['original_user_id'] = $scheduleItem['user_id'];
        $scheduleItem['original_user_name'] = $scheduleItem['user_name'];
        $scheduleItem['original_user_nik'] = $scheduleItem['user_nik'];
        
        if ($absenceRecord['replacement_user_id']) {
            // Ambil data pengganti dari database
            $replacementUser = $this->userModel->find($absenceRecord['replacement_user_id']);
            if ($replacementUser) {
                $scheduleItem['replacement_user_id'] = $absenceRecord['replacement_user_id'];
                $scheduleItem['replacement_user_name'] = $replacementUser['nama'];
                $scheduleItem['replacement_user_nik'] = $replacementUser['nik'];
            }
        }
        $scheduleItem['notes'] = $absenceRecord['notes'] ?? '';
    } else {
        $scheduleItem['status'] = 'present';
    }
    
    // Get available replacements
    $availableReplacements = $this->briefingModel->getActiveLeaders();
    
    return $this->response->setJSON([
        'success' => true,
        'schedule' => $scheduleItem,
        'absence_record' => $absenceRecord,
        'available_replacements' => $availableReplacements
    ]);
}

    public function deleteSchedule()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $date = $this->request->getPost('date');
        
        $existing = $this->scheduleModel->where('schedule_date', $date)->first();
        if ($existing) {
            if ($this->scheduleModel->delete($existing['id'])) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Data jadwal berhasil dihapus'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Gagal menghapus data jadwal'
        ]);
    }

    public function generateUpcomingSchedule()
    {
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-d', strtotime('+3 months')); // 3 months ahead
        
        $schedule = $this->briefingModel->generateSchedule($startDate, $endDate);
        
        // Clear existing future schedules
        $this->scheduleModel->where('schedule_date >=', date('Y-m-d'))->delete();
        
        // Insert new schedules
        foreach ($schedule as $item) {
            $this->scheduleModel->insert([
                'schedule_date' => $item['date'],
                'user_id' => $item['user_id'],
                'is_present' => 1
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Jadwal berhasil digenerate untuk ' . count($schedule) . ' hari'
        ]);
    }
    public function exportSchedule()
{
    $startDate = $this->request->getGet('start') ?: date('Y-m-01');
    $endDate = $this->request->getGet('end') ?: date('Y-m-d', strtotime('+3 months'));
    
    $schedule = $this->briefingModel->generateSchedule($startDate, $endDate);
    
    $filename = 'jadwal_briefing_' . date('Y-m-d') . '.csv';
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Header CSV
    fputcsv($output, ['Tanggal', 'Hari', 'Pemimpin', 'NIK']);
    
    // Data
    foreach ($schedule as $item) {
        fputcsv($output, [
            $item['date'],
            $item['day_name'],
            $item['user_name'],
            $item['user_nik']
        ]);
    }
    
    fclose($output);
    exit;
}

public function getHolidays()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }
    
    $year = $this->request->getGet('year') ?: date('Y');
    
    $db = \Config\Database::connect();
    $holidays = $db->table('holidays')
                   ->select('holiday_date, description')
                   ->where('YEAR(holiday_date)', $year)
                   ->orderBy('holiday_date', 'ASC')
                   ->get()
                   ->getResultArray();
    
    return $this->response->setJSON([
        'success' => true,
        'holidays' => $holidays
    ]);
}
}
