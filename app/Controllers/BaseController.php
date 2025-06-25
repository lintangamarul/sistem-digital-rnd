<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\ActualActivityModel;
use App\Models\PiketScheduleModel;
use App\Models\UserModel;
use App\Models\HolidayModel;
date_default_timezone_set('Asia/Jakarta');

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */

     public function kirimJadwalHariIni()
     {
        $today = date('Y-m-d');
        $dayOfWeek = date('N');
        $holidayModel = new HolidayModel();
        $isHoliday = $holidayModel->where('holiday_date', $today)->first();

        if ($dayOfWeek >= 6 || $isHoliday) {
            return;
        }
         $now = date('H:i');
         if ($now < '16:10') {
             return; 
         }
 
         $db = \Config\Database::connect();
 
         // $cek = $db->table('jadwal_kirim_log')->where('tanggal', $today)->get()->getRow();
         // if ($cek) {
         //     return; 
         // }
 
         $groupId = '120363418163603019@g.us';
 
         $piketModel = new PiketScheduleModel();
         $userModel = new UserModel();
 
 
         $jadwalHariIni = $piketModel->where('date', $today)->findAll();
         if (empty($jadwalHariIni)) {
             return;
         }
 
         $userIds = array_column($jadwalHariIni, 'user_id');
         $users = $userModel->whereIn('id', $userIds)->findAll();
 
         $tanggalFormat = date('d-m-Y', strtotime($today));
         $pesan = "Jadwal Piket ($tanggalFormat) hari ini\n";
 
         $maxLength = 0;
         foreach ($users as $index => $user) {
             $line = ($index + 1) . '. ' . $user['nickname'];
             if (strlen($line) > $maxLength) {
                 $maxLength = strlen($line);
             }
         }
 
         foreach ($users as $index => $user) {
             $line = ($index + 1) . '. ' . $user['nickname'];
             $pesan .= str_pad($line, $maxLength, ' ') . " :\n";
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
 
     private function getLastWorkdays($count = 2)
     {
         $holidayModel = new HolidayModel();
         $days = [];
         $date = strtotime('yesterday');
 
         while (count($days) < $count) {
             $day = date('Y-m-d', $date);
             $isWeekend = in_array(date('N', $date), [6, 7]);
             $isHoliday = $holidayModel->where('holiday_date', $day)->first();
 
             if (!$isWeekend && !$isHoliday) {
                 $days[] = $day;
             }
 
             $date = strtotime('-1 day', $date);
         }
 
         return $days;
     }
     public function kirimPersentaseLKH()
     {
        $today = date('Y-m-d');
        $dayOfWeek = date('N');
        $holidayModel = new HolidayModel();
        $isHoliday = $holidayModel->where('holiday_date', $today)->first();

        if ($dayOfWeek >= 6 || $isHoliday) {
            return;
        }

         $now = date('H:i');
         if ($now < '16:10') {
             return; 
         }
     
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
                 $tgl = date('d-m-Y', strtotime($checkDate));
                 $hari = $this->namaHari($checkDate);
                 $pesan .= "🗓️ *$hari, $tgl*\n";
                 foreach ($missingUsers as $index => $nickname) {
                     $pesan .= ($index + 1) . ". " . $nickname . "\n";
                 }
                 $pesan .= "\n";
             }
         }
     
         $pesan .= "🙏 Terima kasih yang sudah rutin mengisi.";
        $besok = date('Y-m-d', strtotime('+1 day'));
        $isBesokWeekend = in_array(date('N', strtotime($besok)), [6, 7]);
        $isBesokHoliday = $holidayModel->where('holiday_date', $besok)->first();

        if (!$isBesokWeekend && !$isBesokHoliday) {
            $piketModel = new PiketScheduleModel();
            $jadwalBesok = $piketModel->where('date', $besok)->findAll();

            if (!empty($jadwalBesok)) {
                $userIdsBesok = array_column($jadwalBesok, 'user_id');
                $userModel = new UserModel();
                $usersBesok = $userModel->whereIn('id', $userIdsBesok)->findAll();

                $tanggalBesok = date('d-m-Y', strtotime($besok));
                $hariBesok = $this->namaHari($besok);

                $pesan .= "\n📅 *Jadwal Piket Besok ($hariBesok, $tanggalBesok)*\n";

                foreach ($usersBesok as $i => $user) {
                    $pesan .= ($i + 1) . '. ' . $user['nickname'] . "\n";
                }
            }
        }
         $this->kirimWaGrup($groupId, $pesan);
         $this->kirimJadwalHariIni();
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
     
     
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // $this->kirimJadwalHariIni();
        $this->kirimPersentaseLKH();
    }
}
