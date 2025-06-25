<?php

namespace App\Models;

use CodeIgniter\Model;

class BriefingModel extends Model
{
    protected $table = 'briefing_leaders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'order_sequence', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveLeaders()
    {
        return $this->select('briefing_leaders.*, users.nama, users.nik')
                    ->join('users', 'users.id = briefing_leaders.user_id')
                    ->where('briefing_leaders.is_active', 1)
                    ->where('users.status', 1)
                    ->orderBy('briefing_leaders.order_sequence', 'ASC')
                    ->findAll();
    }

    public function getAvailableUsers()
    {
        $db = \Config\Database::connect();
        
        // Get users yang belum ada di briefing_leaders atau yang is_active = 0
        $subQuery = $db->table('briefing_leaders')
                       ->select('user_id')
                       ->where('is_active', 1)
                       ->getCompiledSelect();
        
        return $db->table('users')
                  ->select('id, nama, nik')
                  ->where('status', 1)
                  ->where("id NOT IN ($subQuery)", null, false)
                  ->get()
                  ->getResultArray();
    }

    public function updateOrder($orderData)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            foreach ($orderData as $index => $userId) {
                $this->where('user_id', $userId)
                     ->set('order_sequence', $index + 1)
                     ->update();
            }
            
            $db->transComplete();
            return $db->transStatus();
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }

   public function generateSchedule($startDate, $endDate)
{
    $leaders = $this->getActiveLeaders();
    
    if (empty($leaders)) {
        log_message('error', 'No active leaders found for schedule generation');
        return [];
    }

    $schedule = [];
    $currentDate = new \DateTime($startDate);
    $endDateTime = new \DateTime($endDate);
    
    // Base date untuk rotasi konsisten
    $baseDate = new \DateTime('2025-01-01'); // Tanggal base untuk rotasi
    
    // Hitung offset hari kerja Senin-Kamis dari base date
    $mondayToThursdayCount = 0;
    $tempDate = clone $baseDate;
    while ($tempDate < $currentDate) {
        $dayOfWeek = (int)$tempDate->format('N');
        $tempDateStr = $tempDate->format('Y-m-d');
        $isHoliday = $this->isHoliday($tempDateStr);
        
        // Senin-Kamis (1-4)
        if ($dayOfWeek >= 1 && $dayOfWeek <= 4 && !$isHoliday) {
            $mondayToThursdayCount++;
        }
        $tempDate->add(new \DateInterval('P1D'));
    }
    
    // Hitung offset Jumat dari base date
    $fridayCount = 0;
    $tempDate = clone $baseDate;
    while ($tempDate < $currentDate) {
        $dayOfWeek = (int)$tempDate->format('N');
        $tempDateStr = $tempDate->format('Y-m-d');
        $isHoliday = $this->isHoliday($tempDateStr);
        
        // Jumat (5)
        if ($dayOfWeek == 5 && !$isHoliday) {
            $fridayCount++;
        }
        $tempDate->add(new \DateInterval('P1D'));
    }
    
    $mondayToThursdayIndex = $mondayToThursdayCount % count($leaders);
    $fridayIndex = $fridayCount % count($leaders);
    
    // Get holidays
    $db = \Config\Database::connect();
    $holidays = $db->table('holidays')
                   ->select('holiday_date')
                   ->where('holiday_date >=', $startDate)
                   ->where('holiday_date <=', $endDate)
                   ->get()
                   ->getResultArray();
    
    $holidayDates = array_column($holidays, 'holiday_date');
    
    log_message('info', 'Generating schedule from ' . $startDate . ' to ' . $endDate);
    log_message('info', 'Starting Monday-Thursday index: ' . $mondayToThursdayIndex);
    log_message('info', 'Starting Friday index: ' . $fridayIndex);

    while ($currentDate <= $endDateTime) {
        $dayOfWeek = (int)$currentDate->format('N');
        $dateStr = $currentDate->format('Y-m-d');
        
        // Monday to Friday (1-5) and not holiday
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5 && !in_array($dateStr, $holidayDates)) {
            
            if ($dayOfWeek >= 1 && $dayOfWeek <= 4) {
                // Senin-Kamis: gunakan rotasi normal
                $leader = $leaders[$mondayToThursdayIndex % count($leaders)];
                $mondayToThursdayIndex++;
            } else {
                // Jumat: gunakan rotasi terpisah
                $leader = $leaders[$fridayIndex % count($leaders)];
                $fridayIndex++;
            }
            
            $schedule[] = [
                'date' => $dateStr,
                'day_name' => $this->getDayName($dayOfWeek),
                'user_id' => (int)$leader['user_id'],
                'user_name' => $leader['nama'],
                'user_nik' => $leader['nik']
            ];
        }
        
        $currentDate->add(new \DateInterval('P1D'));
    }
    
    log_message('info', 'Generated ' . count($schedule) . ' schedule items');
    
    return $schedule;
}

    public function getUserSchedule($userId, $startDate, $endDate)
    {
        $fullSchedule = $this->generateSchedule($startDate, $endDate);
        
        return array_filter($fullSchedule, function($item) use ($userId) {
            return $item['user_id'] == $userId;
        });
    }

    private function getDayName($dayNumber)
{
    $days = [
        1 => 'Senin',
        2 => 'Selasa', 
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    ];
    
    return $days[$dayNumber] ?? '';
}
private function isHoliday($date)
{
    $db = \Config\Database::connect();
    $result = $db->table('holidays')
                 ->where('holiday_date', $date)
                 ->countAllResults();
    return $result > 0;
}
public function getUserName($userId)
{
    $db = \Config\Database::connect();
    $user = $db->table('users')
               ->select('nama')
               ->where('id', $userId)
               ->get()
               ->getRowArray();
    
    return $user ? $user['nama'] : 'Unknown User';
}
}