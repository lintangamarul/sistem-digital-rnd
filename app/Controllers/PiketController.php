<?php
namespace App\Controllers;

use App\Models\CalendarModel;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\HolidayModel;
use App\Models\ActualActivityModel;
use App\Models\PiketScheduleModel;

class PiketController extends Controller
{
    private function groupBy($array, $key)
    {
        $result = [];
        foreach ($array as $val) {
            $result[$val[$key]][] = $val;
        }
        return $result;
    }

    private function getWeekDates($week = 0)
    {
        $today = date('Y-m-d');
        $currentMonday = date('Y-m-d', strtotime('monday this week', strtotime($today)));
        $start = strtotime("+{$week} week", strtotime($currentMonday));
        $dates = [];

        for ($i = 0; $i < 5; $i++) {
            $dates[] = date('Y-m-d', strtotime("+{$i} day", $start));
        }

        return $dates;
    }


    private function getWeekInfo($weekOffset)
    {
        $titles = [
            0 => 'Minggu Ini',
            1 => 'Minggu Depan', 
            2 => '2 Minggu Lagi'
        ];
        
        return [
            'title' => $titles[$weekOffset] ?? "Minggu ke-{$weekOffset}",
            'dates' => $this->getWeekDates($weekOffset),
            'can_edit' => $weekOffset >= 0 
        ];
    }

    private function getScheduleForWeek($weekOffset)
    {
        $userModel = new UserModel();
        $db = \Config\Database::connect();
        
        $weekDates = $this->getWeekDates($weekOffset);
        
        $existing = $db->table('piket_schedule')
            ->whereIn('date', $weekDates)
            ->get()
            ->getResultArray();

        $jadwal = [];
        foreach ($weekDates as $date) {
            $usersInDay = array_filter($existing, fn($e) => $e['date'] === $date);
            $userIds = array_column($usersInDay, 'user_id');
            $users = !empty($userIds) ? $userModel->whereIn('id', $userIds)->findAll() : [];
            $jadwal[$date] = $users;
        }

        return $jadwal;
    }

    private function hasScheduleForWeek($weekOffset)
    {
        $db = \Config\Database::connect();
        $weekDates = $this->getWeekDates($weekOffset);
        
        $count = $db->table('piket_schedule')
            ->whereIn('date', $weekDates)
            ->countAllResults();
            
        return $count > 0;
    }

    public function index()
    {
        $allWeeks = [];
    
        $holidayModel = new \App\Models\HolidayModel();
    
        $holidayDatesRaw = $holidayModel->select('holiday_date')->findAll();
    
        $holiday_dates = array_column($holidayDatesRaw, 'holiday_date');
    
        for ($week = 0; $week < 3; $week++) {
            $weekInfo = $this->getWeekInfo($week);
            
            $schedule = $this->getScheduleForWeek($week);
            $hasSchedule = $this->hasScheduleForWeek($week);
    
            $allWeeks[] = [
                'info' => $weekInfo,
                'schedule' => $schedule,
                'has_schedule' => $hasSchedule,
                'week_offset' => $week
            ];
        }


        return view('piket/index', [
            'weeks' => $allWeeks,
            'holiday_dates' => $holiday_dates
        ]);
    }
    public function atur()
    {
        $userModel = new UserModel();
        $holidayModel = new HolidayModel();
        $activityModel = new ActualActivityModel();
        $db = \Config\Database::connect();
    
        $week = (int) ($this->request->getGet('week') ?? 1);
    
        if ($week < 0) {
            return redirect()->to('/piket')->with('error', 'Tidak dapat mengedit jadwal sebelum minggu ini');
        }
    
        $weekInfo = $this->getWeekInfo($week);
        $weekDates = $weekInfo['dates'];
    
        $existing = $db->table('piket_schedule')
            ->whereIn('date', $weekDates)
            ->get()
            ->getResultArray();
    
        $jadwal = [];
        $isEdit = !empty($existing);
    
        if ($isEdit) {
            foreach ($weekDates as $date) {
                $usersInDay = array_filter($existing, fn($e) => $e['date'] === $date);
                $userIds = array_column($usersInDay, 'user_id');
                $users = !empty($userIds) ? $userModel->whereIn('id', $userIds)->findAll() : [];
                $jadwal[$date] = $users;
            }
        } else {
            $jadwal = $this->generateAutoSchedule($weekDates, $userModel, $holidayModel, $activityModel);
        }
    
        $holidaysRaw = $holidayModel->whereIn('holiday_date', $weekDates)->findAll();
        $holidayDates = array_column($holidaysRaw, 'holiday_date');
    
        $allUsers = $userModel->where('status', 1)->findAll();
    
        return view('piket/atur', [
            'jadwal' => $jadwal,
            'week' => $week,
            'week_info' => $weekInfo,
            'holiday_dates' => $holidayDates,
            'is_edit' => $isEdit,
            'allUsers' => $allUsers
        ]);
    }
    
    private function getAbsentUsersByDate($dates)
    {
        $actualModel = new \App\Models\ActualActivityModel();
        $data = $actualModel
            ->select('created_by, dates')
            ->whereIn('status', [3, 4, 5, 6])
            ->whereIn('dates', $dates)
            ->findAll();
    
        $absentByDate = [];
        foreach ($dates as $date) {
            $absentByDate[$date] = [];
        }
        
        foreach ($data as $record) {
            $absentByDate[$record['dates']][] = $record['created_by'];
        }
    
        return $absentByDate;
    }


    
    private function generateAutoSchedule($weekDates, $userModel, $holidayModel, $activityModel)
    {
       $allUsers = $userModel->where('group >=', 1)->where('status', 1)->findAll();

        usort($allUsers, function($a, $b) {
            return $a['jumlah_piket'] <=> $b['jumlah_piket'];
        });
        
        $holidays = array_column($holidayModel->whereIn('holiday_date', $weekDates)->findAll(), 'holiday_date');
        $validDates = array_filter($weekDates, fn($d) => !in_array($d, $holidays));
    
        $absentUsersByDate = $this->getAbsentUsersByDate($validDates);
        
        $usersByGroup = [];
        foreach ($allUsers as $user) {
            $usersByGroup[$user['group']][] = $user;
        }
        
        $totalSlots = 4 * count($validDates);
        $userCount = count($allUsers);
        if ($userCount === 0) return [];
    
        // Calculate assignments per user with max 2 per week constraint
        // $maxAssignmentsPerWeek = 1;

        $totalSlots = 4 * count($validDates);
        $maxAssignmentsPerWeek = ceil($totalSlots / count($allUsers));

        $totalMaxAssignments = $userCount * $maxAssignmentsPerWeek;
        
        if ($totalSlots > $totalMaxAssignments) {
            $basePerUser = $maxAssignmentsPerWeek;
        } else {
            $basePerUser = intdiv($totalSlots, $userCount);
            $extra = $totalSlots % $userCount;
        }
    
        $userPickCount = [];
        $userWeeklyCount = []; 
        
        foreach ($allUsers as $user) {
            if ($totalSlots > $totalMaxAssignments) {
                $userPickCount[$user['id']] = $maxAssignmentsPerWeek;
            } else {
                $userPickCount[$user['id']] = $basePerUser;
            }
            $userWeeklyCount[$user['id']] = 0;
        }
        
        if ($totalSlots <= $totalMaxAssignments && isset($extra)) {
            for ($i = 0; $i < $extra; $i++) {
                $userPickCount[$allUsers[$i]['id']]++;
            }
        }
    
        $jadwal = [];
        foreach ($validDates as $date) {
            $jadwal[$date] = [];
        }
        foreach ($holidays as $holiday) {
            if (in_array($holiday, $weekDates)) {
                $jadwal[$holiday] = [];
            }
        }
    
        $remainingAssignments = $userPickCount;
        
        $shuffledDates = $validDates;
        shuffle($shuffledDates);
        
        foreach ($shuffledDates as $date) {
            $absentUserIds = $absentUsersByDate[$date] ?? [];
            
            $groupCount = [];
            $uniqueGroups = array_unique(array_column($allUsers, 'group'));
            if (count($uniqueGroups) > 1) {
                foreach ($uniqueGroups as $group) {
                    $groupCount[$group] = 0;
                }
            }

            
            $availableUsersByGroup = [];
            foreach ($usersByGroup as $groupId => $users) {
                $availableUsersByGroup[$groupId] = array_filter($users, function($user) use ($absentUserIds, $remainingAssignments, $userWeeklyCount, $maxAssignmentsPerWeek) {
                    return !in_array($user['id'], $absentUserIds) && 
                           $remainingAssignments[$user['id']] > 0 &&
                           $userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek; 
                });
                shuffle($availableUsersByGroup[$groupId]);
            }
            
            $groupPriority = [];
            foreach ($availableUsersByGroup as $groupId => $users) {
                $totalRemaining = 0;
                foreach ($users as $user) {
                    if ($userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek) { 
                        $totalRemaining += $remainingAssignments[$user['id']];
                    }
                }
                $groupPriority[$groupId] = $totalRemaining;
            }
            arsort($groupPriority);
            
            $assignedCount = 0;
            $attempts = 0;
            $maxAttempts = 100;
            $availablePerempuan = array_filter($allUsers, function($user) use ($absentUserIds, $remainingAssignments, $userWeeklyCount, $maxAssignmentsPerWeek) {
                return $user['jenis_kelamin'] === 'P' &&
                    !in_array($user['id'], $absentUserIds) &&
                    $remainingAssignments[$user['id']] > 0 &&
                    $userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek;
            });

            if (count($availablePerempuan) >= 2) {
                shuffle($availablePerempuan);
                $pair = array_slice($availablePerempuan, 0, 2);

                foreach ($pair as $user) {
                    $jadwal[$date][] = $user;
                    $remainingAssignments[$user['id']]--;
                    $userWeeklyCount[$user['id']]++;
                    $groupCount[$user['group']]++;
                }

                $assignedCount += 2;
            }

            while ($assignedCount < 4 && $attempts < $maxAttempts) {
                $attempts++;
                $assigned = false;
                
                foreach ($groupPriority as $groupId => $priority) {
                    if ($assignedCount >= 4) break;
                    
                    if ($groupCount[$groupId] >= 2) continue;
                    
                    $availableUsers = $availableUsersByGroup[$groupId];
                    
                    usort($availableUsers, function($a, $b) use ($remainingAssignments, $userWeeklyCount) {
          
                        $weeklyDiff = $userWeeklyCount[$a['id']] - $userWeeklyCount[$b['id']];
                        if ($weeklyDiff != 0) {
                            return $weeklyDiff;
                        }
                        
                        $remainingDiff = $remainingAssignments[$b['id']] - $remainingAssignments[$a['id']];
                        if (abs($remainingDiff) <= 1) {
                            return rand(-1, 1); 
                        }
                        return $remainingDiff;
                    });
                    
                    foreach ($availableUsers as $key => $user) {
                        if ($userWeeklyCount[$user['id']] >= $maxAssignmentsPerWeek) continue;
                        
                        $alreadyAssigned = false;
                        foreach ($jadwal[$date] as $assignedUser) {
                            if ($assignedUser['id'] == $user['id']) {
                                $alreadyAssigned = true;
                                break;
                            }
                        }
                        
                        if (!$alreadyAssigned && $remainingAssignments[$user['id']] > 0) {
                            $jadwal[$date][] = $user;
                            $remainingAssignments[$user['id']]--;
                            $userWeeklyCount[$user['id']]++;
                            $groupCount[$groupId]++;
                            $assignedCount++;
                            $assigned = true;
                            
                            unset($availableUsersByGroup[$groupId][$key]);
                            $availableUsersByGroup[$groupId] = array_values($availableUsersByGroup[$groupId]);
                            break;
                        }
                    }
                }
                
                if (!$assigned) break;
            }
            $availablePerempuan = array_filter($allUsers, function($user) use ($absentUserIds, $remainingAssignments, $userWeeklyCount, $maxAssignmentsPerWeek) {
                return $user['jenis_kelamin'] === 'P' &&
                    !in_array($user['id'], $absentUserIds) &&
                    $remainingAssignments[$user['id']] > 0 &&
                    $userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek;
            });

            if (count($availablePerempuan) >= 2) {
                shuffle($availablePerempuan);
                $pair = array_slice($availablePerempuan, 0, 2);

                foreach ($pair as $user) {
                    $jadwal[$date][] = $user;
                    $remainingAssignments[$user['id']]--;
                    $userWeeklyCount[$user['id']]++;
                    $groupCount[$user['group']]++;
                }

                $assignedCount += 2;
            }

            $attempts = 0;
            while ($assignedCount < 4 && $attempts < $maxAttempts) {
                $attempts++;
                $assigned = false;
                
                foreach ($availableUsersByGroup as $groupId => $users) {
                    if ($assignedCount >= 4) break;
                    
                    foreach ($users as $key => $user) {
                        if ($assignedCount >= 4) break;
                        
                        if ($userWeeklyCount[$user['id']] >= $maxAssignmentsPerWeek) continue;
                        
                        $alreadyAssigned = false;
                        foreach ($jadwal[$date] as $assignedUser) {
                            if ($assignedUser['id'] == $user['id']) {
                                $alreadyAssigned = true;
                                break;
                            }
                        }
                        
                        if (!$alreadyAssigned && $remainingAssignments[$user['id']] > 0) {
                            $jadwal[$date][] = $user;
                            $remainingAssignments[$user['id']]--;
                            $userWeeklyCount[$user['id']]++; 
                            $groupCount[$groupId]++;
                            $assignedCount++;
                            $assigned = true;
                            
                            unset($availableUsersByGroup[$groupId][$key]);
                            $availableUsersByGroup[$groupId] = array_values($availableUsersByGroup[$groupId]);
                            break;
                        }
                    }
                    
                    if ($assigned) break;
                }
                
                if (!$assigned) break;
            }
        }
        
        foreach ($allUsers as $user) {
            while ($remainingAssignments[$user['id']] > 0 && $userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek) {
                $assigned = false;
                
                foreach ($validDates as $date) {
                    $absentUserIds = $absentUsersByDate[$date] ?? [];
                    
                    if (!in_array($user['id'], $absentUserIds) && count($jadwal[$date]) < 4) {
                     
                        $alreadyAssigned = false;
                        foreach ($jadwal[$date] as $assignedUser) {
                            if ($assignedUser['id'] == $user['id']) {
                                $alreadyAssigned = true;
                                break;
                            }
                        }
                        
                        $currentGroupCount = [];
                        foreach (range(1, 5) as $group) {
                            $currentGroupCount[$group] = 0;
                        }
                        foreach ($jadwal[$date] as $assignedUser) {
                            $currentGroupCount[$assignedUser['group']]++;
                        }
                        
                        if (!$alreadyAssigned && 
                            $currentGroupCount[$user['group']] < 1 && 
                            $userWeeklyCount[$user['id']] < $maxAssignmentsPerWeek) {
                            $jadwal[$date][] = $user;
                            $remainingAssignments[$user['id']]--;
                            $userWeeklyCount[$user['id']]++; 
                            $assigned = true;
                            break;
                        }
                    }
                }
                
                if (!$assigned) {
                    break;
                }
            }
        }
        
        foreach ($validDates as $date) {
            $absentUserIds = $absentUsersByDate[$date] ?? [];
            
            while (count($jadwal[$date]) < 4) {
                $assigned = false;
                
                $usersSortedByWeeklyCount = $allUsers;
                usort($usersSortedByWeeklyCount, function($a, $b) use ($userWeeklyCount) {
                    return $userWeeklyCount[$a['id']] - $userWeeklyCount[$b['id']];
                });
                
                foreach ($usersSortedByWeeklyCount as $user) {
                    if (count($jadwal[$date]) >= 4) break;
                    
                    if ($userWeeklyCount[$user['id']] >= $maxAssignmentsPerWeek) continue;
                    
                    if (in_array($user['id'], $absentUserIds)) continue;
                    
                    $alreadyAssigned = false;
                    foreach ($jadwal[$date] as $assignedUser) {
                        if ($assignedUser['id'] == $user['id']) {
                            $alreadyAssigned = true;
                            break;
                        }
                    }
                    
                    if (!$alreadyAssigned) {
                        $currentGroupCount = [];
                        foreach (range(1, 5) as $group) {
                            $currentGroupCount[$group] = 0;
                        }
                        foreach ($jadwal[$date] as $assignedUser) {
                            $currentGroupCount[$assignedUser['group']]++;
                        }
                        
                        if ($currentGroupCount[$user['group']] < 1) {
                            $jadwal[$date][] = $user;
                            $userWeeklyCount[$user['id']]++; 
                            $assigned = true;
                            break;
                        }
                    }
                }
                
                if (!$assigned) {
                    break;
                }
            }
        }
    
        return $jadwal;
    }
    
    
    public function simpan()
    {
        $piketModel = new PiketScheduleModel();
        $userModel  = new \App\Models\UserModel();
        $jadwal     = $this->request->getPost('jadwal');
        $week       = (int) ($this->request->getPost('week') ?? 1);
    
        if (!$jadwal || !is_array($jadwal)) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }
    
        $db = \Config\Database::connect();
        $db->transStart();
    
        try {
            $jadwalLama = $piketModel->where('week', $week)->findAll();
            $userIdLama = array_column($jadwalLama, 'user_id');
    
            foreach ($userIdLama as $id) {
                $user = $userModel->select('jumlah_piket')->find($id);
                if ($user && $user['jumlah_piket'] > 0) {
                    $userModel->update($id, ['jumlah_piket' => $user['jumlah_piket'] - 1]);
                }
            }
    
            $piketModel->where('week', $week)->delete();
    
            $jumlah_piket = [];
            foreach ($jadwal as $date => $userIds) {
                if (!empty($userIds) && is_array($userIds)) {
                    foreach ($userIds as $userId) {
                        if (!empty($userId)) {
                            $piketModel->insert([
                                'week'    => $week,
                                'date'    => $date,
                                'user_id' => $userId,
                            ]);
                            if (!isset($jumlah_piket[$userId])) {
                                $existing = $userModel->select('jumlah_piket')->find($userId);
                                $jumlah_piket[$userId] = $existing ? $existing['jumlah_piket'] : 0;
                            }
                            $jumlah_piket[$userId]++;
                        }
                    }
                }
            }
    
            foreach ($jumlah_piket as $userId => $jumlah) {
                $userModel->update($userId, ['jumlah_piket' => $jumlah]);
            }
    
            $db->transComplete();
    
            if ($db->transStatus() === FALSE) {
                return redirect()->back()->with('error', 'Gagal menyimpan jadwal');
            }
    
            return redirect()->to('/piket')->with('success', 'Jadwal berhasil disimpan');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function hapus()
    {
        $week = (int) ($this->request->getPost('week') ?? 1);
    
        if ($week < 1) {
            return redirect()->to('/piket')->with('error', 'Tidak dapat menghapus jadwal minggu ini');
        }
    
        $piketModel = new PiketScheduleModel();
        $userModel  = new \App\Models\UserModel();
        $weekDates  = $this->getWeekDates($week);
    
        $db = \Config\Database::connect();
        $db->transStart();
    
        try {
            $jadwalLama = $piketModel->where('week', $week)->findAll();
            $userHitung = [];
    
            foreach ($jadwalLama as $row) {
                $userId = $row['user_id'];
                if (!isset($userHitung[$userId])) {
                    $userHitung[$userId] = 0;
                }
                $userHitung[$userId]++;
            }
    
            foreach ($userHitung as $userId => $jumlahKurang) {
                $user = $userModel->select('jumlah_piket')->find($userId);
                if ($user) {
                    $baru = max(0, $user['jumlah_piket'] - $jumlahKurang);
                    $userModel->update($userId, ['jumlah_piket' => $baru]);
                }
            }
    
            foreach ($weekDates as $date) {
                $piketModel->where('date', $date)->delete();
            }
    
            $db->transComplete();
    
            if ($db->transStatus() === FALSE) {
                return redirect()->back()->with('error', 'Gagal menghapus jadwal');
            }
    
            return redirect()->to('/piket')->with('success', 'Jadwal berhasil dihapus');
    
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    


    public function acak()
    {
        $week = (int) ($this->request->getGet('week') ?? 1);
        return redirect()->to("/piket/atur?week={$week}");
    }

    private function namaHari($tanggal)
    {
        $hari = date('N', strtotime($tanggal));
        $daftarHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];
        return $daftarHari[$hari];
    }

    public function kirimPersentaseLKH()
    {
        $now = date('H:i');
        // if ($now < '16:15') {
        //     return; 
        // }

        $today = date('Y-m-d');
        $db = \Config\Database::connect();

        $cek = $db->table('jadwal_kirim_log')->where('tanggal', $today)->get()->getRow();
        if ($cek) {
            return; 
        }

        $groupId = '120363418163603019@g.us';
        $userModel = new UserModel();
        $activityModel = new ActualActivityModel();
        $holidayModel = new HolidayModel();
        $piketModel = new PiketScheduleModel();

        $users = $userModel->where('status', 1)
                        ->where('role_id !=', 6)
                        ->orderBy('nama', 'asc')
                        ->findAll();

        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $filledUsersYesterday = 0;
        $totalActiveUsers = count($users);

        foreach ($users as $user) {
            $activity = $activityModel
                ->where('created_by', $user['id'])
                ->whereIn('status', [1, 3, 4, 5, 6])
                ->where('DATE(dates)', $yesterday)
                ->first();
            
            if ($activity) {
                $filledUsersYesterday++;
            }
        }
        $percentageYesterday = $totalActiveUsers > 0 ? round(($filledUsersYesterday / $totalActiveUsers) * 100, 1) : 0;

        $pesan = "📊 *Persentase Pengisian LKH*\n\n";
        $tanggal1 = date('d-m-Y', strtotime($yesterday));
        $hari1 = $this->namaHari($yesterday);
        $pesan .= "Kemarin ($hari1, $tanggal1): *{$percentageYesterday}%*\n\n";

        $pesan .= "📌 *Yang belum mengisi LKH:*\n";

        $adaYangBelum = false;
        for ($i = 1; $i <= 7; $i++) {
            $checkDate = date('Y-m-d', strtotime("-$i days"));
            $isWeekend = in_array(date('N', strtotime($checkDate)), [6, 7]);
            $isHoliday = $holidayModel->where('holiday_date', $checkDate)->first();

            if ($isWeekend || $isHoliday) continue;
            $missingUsers = [];
            foreach ($users as $user) {
                $activity = $activityModel
                    ->where('created_by', $user['id'])
                    ->whereIn('status', [1, 3, 4, 5, 6])
                    ->where('DATE(dates)', $checkDate)
                    ->first();

                if (!$activity) {
                    $missingUsers[] = $user['nickname'];
                }
            }
            if (!empty($missingUsers)) {
                $adaYangBelum = true;
                $tgl = date('d-m-Y', strtotime($checkDate));
                $hari = $this->namaHari($checkDate);
                $pesan .= "🗓️ *$hari, $tgl*\n";
                foreach ($missingUsers as $index => $nickname) {
                    $pesan .= ($index + 1) . ". " . $nickname . "\n";
                }
                $pesan .= "\n";
            }
        }

        if (!$adaYangBelum) {
            $pesan .= "-\n\n";
        }
        $pesan .= "🙏 Terima kasih yang sudah rutin mengisi.\n\n";
        $besok = date('Y-m-d', strtotime('+1 day'));
        $besokJadwal = $piketModel->where('date', $besok)->findAll();
        if (!empty($besokJadwal)) {
            $besokUserIds = array_column($besokJadwal, 'user_id');
            $besokUsers = $userModel->whereIn('id', $besokUserIds)->findAll();
            $besokNicknames = array_map(fn($u) => $u['nickname'], $besokUsers);

            $besokTgl = date('d-m-Y', strtotime($besok));
            $besokHari = $this->namaHari($besok);
            $pesan .= "📅 *Jadwal Piket Besok ($besokHari, $besokTgl)*:\n";
            foreach ($besokNicknames as $i => $name) {
                $pesan .= ($i + 1) . ". $name\n";
            }
            $pesan .= "\n";
        }

        if (date('N') == 5) {
            $pesan .= "📆 *Jadwal Piket Minggu Depan:*\n";
            for ($i = 1; $i <= 7; $i++) {
                $tgl = date('Y-m-d', strtotime("+$i days"));
                $hari = $this->namaHari($tgl);
                $jadwal = $piketModel->where('date', $tgl)->findAll();
                if (!empty($jadwal)) {
                    $uids = array_column($jadwal, 'user_id');
                    $usrs = $userModel->whereIn('id', $uids)->findAll();
                    $names = array_map(fn($u) => $u['nickname'], $usrs);
                    $pesan .= "$hari : " . implode(', ', $names) . "\n";
                } else {
                    $pesan .= "$hari : -\n";
                }
            }
            $pesan .= "\n";
        }
        $this->kirimWaGrup($groupId, $pesan);
        $db->table('jadwal_kirim_log')->insert(['tanggal' => $today]);
    }

    private function kirimWaGrup($groupId, $pesan)
    {
        $token = "VWkExQrz1vUENMXxJDd1";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $groupId,
                'message' => $pesan,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}