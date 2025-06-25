<?php

namespace App\Models;

use CodeIgniter\Model;

class BriefingScheduleModel extends Model
{
    protected $table = 'briefing_schedules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'schedule_date', 
        'user_id', 
        'is_present', 
        'replacement_user_id', 
        'notes'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getScheduleByDate($date)
    {
        return $this->select('briefing_schedules.*, 
                             u1.nama as scheduled_user_name,
                             u2.nama as replacement_name')
                    ->join('users u1', 'u1.id = briefing_schedules.user_id', 'left')
                    ->join('users u2', 'u2.id = briefing_schedules.replacement_user_id', 'left')
                    ->where('schedule_date', $date)
                    ->first();
    }

    public function markAbsent($date, $userId, $replacementId = null, $notes = null)
{
    $db = \Config\Database::connect();
    $db->transStart();
    
    try {
        $data = [
            'schedule_date' => $date,
            'user_id' => $userId,
            'is_present' => 0,
            'replacement_user_id' => $replacementId,
            'notes' => $notes
        ];

        // Check if record exists
        $existing = $this->where('schedule_date', $date)->first();
        
        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $this->insert($data);
        }
        
        // LOGIKA BARU: Tukar urutan jika ada pengganti
        if ($replacementId) {
            $this->swapUserScheduleOrder($userId, $replacementId, $date);
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            throw new \Exception('Transaction failed');
        }
        
        return true;
        
    } catch (\Exception $e) {
        $db->transRollback();
        log_message('error', 'Error in markAbsent: ' . $e->getMessage());
        return false;
    }
}

/**
 * Tukar urutan jadwal antara user asli dan pengganti
 */
private function swapUserScheduleOrder($originalUserId, $replacementUserId, $absentDate)
{
    // Load BriefingModel untuk generate schedule
    $briefingModel = new \App\Models\BriefingModel();
    
    // Cari jadwal terdekat dari pengganti setelah tanggal absen
    $startSearchDate = date('Y-m-d', strtotime($absentDate . ' +1 day'));
    $endSearchDate = date('Y-m-d', strtotime($absentDate . ' +3 months'));
    
    // Generate schedule untuk mencari jadwal pengganti
    $fullSchedule = $briefingModel->generateSchedule($startSearchDate, $endSearchDate);
    
    // Cari jadwal terdekat dari replacement user
    $replacementNextSchedule = null;
    foreach ($fullSchedule as $scheduleItem) {
        if ($scheduleItem['user_id'] == $replacementUserId) {
            $replacementNextSchedule = $scheduleItem;
            break;
        }
    }
    
    if ($replacementNextSchedule) {
        $replacementDate = $replacementNextSchedule['date'];
        
        log_message('info', "Swapping schedule: User {$originalUserId} will take {$replacementDate} from User {$replacementUserId}");
        
        // Buat record untuk menandai bahwa user asli akan ganti di tanggal pengganti
        $swapData = [
            'schedule_date' => $replacementDate,
            'user_id' => $replacementUserId, // User yang seharusnya
            'is_present' => 0, // Ditandai absen karena diganti
            'replacement_user_id' => $originalUserId, // Diganti oleh user asli
            'notes' => "Tukar jadwal dengan {$briefingModel->getUserName($originalUserId)} karena penggantian tanggal {$absentDate}"
        ];
        
        // Check if record exists untuk tanggal pengganti
        $existingSwap = $this->where('schedule_date', $replacementDate)->first();
        
        if ($existingSwap) {
            $this->update($existingSwap['id'], $swapData);
        } else {
            $this->insert($swapData);
        }
        
        log_message('info', "Schedule swap completed successfully");
    } else {
        log_message('warning', "No future schedule found for replacement user {$replacementUserId}");
    }
}
}