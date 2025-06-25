<?php

namespace App\Controllers;
use App\Models\ActualActivityDetailModel;
use App\Models\ActivityModel;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
 
public function index()
{   
    $startDate = $this->request->getGet('start_date') ?: date('Y-m-01');
    $endDate = $this->request->getGet('end_date') ?: date('Y-m-t');

    $durationData = $this->db->query("
        SELECT a.name AS activities_name, SUM(d.total_time) AS total_duration
        FROM actual_activity_detail d
        JOIN activities a ON d.activity_id = a.id
        WHERE d.created_at BETWEEN ? AND ?
        AND d.status = 1 AND a.status = 1
        GROUP BY d.activity_id
    ", [$startDate, $endDate])->getResultArray();

    $projectDurationData = $this->db->query("
        SELECT CONCAT(IFNULL(p.model, ''), IFNULL(p.another_project, '')) AS project_model,
        SUM(d.total_time) AS total_duration
        FROM actual_activity_detail d
        JOIN activities a ON d.activity_id = a.id
        JOIN projects p ON d.project_id = p.id
        WHERE d.created_at BETWEEN ? AND ?
        AND a.status = 1 AND d.status = 1
        GROUP BY p.model, p.another_project
    ", [$startDate, $endDate])->getResultArray();

    $projectDurationChartData = [];
    foreach ($projectDurationData as $row) {
        $projectDurationChartData[] = [
            'name'  => $row['project_model'],
            'y'     => (int)$row['total_duration'],
            'model' => $row['project_model']
        ];
    }

    $query = $this->db->table('actual_activity')
    ->select('actual_activity.dates, actual_activity.status, COUNT(actual_activity.id) as total, users.nama')
    ->join('users', 'users.id = actual_activity.created_by', 'inner')
    ->whereIn('actual_activity.status', [3, 4, 5, 6])
    ->where('actual_activity.dates >=', $startDate)
    ->groupBy(['actual_activity.dates', 'actual_activity.status', 'users.nama'])
    ->orderBy('actual_activity.dates', 'ASC')
    ->get()
    ->getResultArray();

    $data = [];
    foreach ($query as $row) {
        if ((int)$row['total'] === 0) continue;
        $date = $row['dates'];

        $status = $row['status'];
        if (!isset($data[$date])) {
            $data[$date] = [];
        }
        if (!isset($data[$date][$status])) {
            $data[$date][$status] = ['total' => 0, 'names' => []];
        }
        $data[$date][$status]['total'] += (int)$row['total'];
        $data[$date][$status]['names'][] = $row['nama'];
    }

    $categories = array_keys($data);
    sort($categories);
    $statusLabels = [3 => 'GH',  6 => 'Cuti'];
    $finalData = [];
    foreach ($statusLabels as $status => $label) {
        $seriesData = [];
        foreach ($categories as $date) {
            if (isset($data[$date][$status])) {
                $seriesData[] = [
                    'y'      => $data[$date][$status]['total'],
                    'custom' => ['users' => $data[$date][$status]['names']]
                ];
            }
        }
        $finalData[] = ['name' => $label, 'data' => $seriesData];
    }

  

    $usersQuery = $this->db->table('users')
    ->select('`group`, nama')
    ->where('status', 1)
    ->orderBy('group', 'ASC')
    ->get()
    ->getResultArray();

    $grouped = [];
    foreach ($usersQuery as $row) {
        $grp = $row['group'];
        if (!isset($grouped[$grp])) {
            $grouped[$grp] = [];
        }
        $shortName = (strlen($row['nama']) > 8) ? substr($row['nama'], 0, 8) : $row['nama'];
        $grouped[$grp][] = [
            'name'     => $shortName,
            'fullName' => $row['nama'],
            'value'    => 1
        ];
    }
    $packedBubbleData = [];
    foreach ($grouped as $grpName => $users) {
        $packedBubbleData[] = ['name' => 'Grup: ' . $grpName, 'data' => $users];
    }

    return view('dashboard/index', [
        'startDate'                  => $startDate,
        'endDate'                    => $endDate,
        'durationData'               => $durationData,
        'projectDurationChartData'   => json_encode($projectDurationChartData),
        'chartData'                  => json_encode($finalData),
        'categories'                 => json_encode($categories),
        'packedBubbleData'           => json_encode($packedBubbleData)
    ]);
}
    // public function index()
    // {
    //     $startDate = $this->request->getGet('start_date') ?: date('Y-m-01'); // Default awal bulan ini
    //     $endDate = $this->request->getGet('end_date') ?: date('Y-m-t'); // Default akhir bulan ini
    
    //     // Data untuk Frekuensi Activities
    //     // $frequencyData = $this->db->query(" 
    //     //     SELECT a.name AS activities_name, COUNT(d.id) AS frequency
    //     //     FROM actual_activity_detail d
    //     //     JOIN activities a ON d.activity_id = a.id
    //     //     WHERE d.created_at BETWEEN ? AND ? 
    //     //     AND a.status = 1 AND d.status = 1
    //     //     GROUP BY d.activity_id
    //     // ", [$startDate, $endDate])->getResultArray();
    
    //     // Data untuk Durasi Activities
    //     $durationData = $this->db->query(" 
    //         SELECT a.name AS activities_name, SUM(d.total_time) AS total_duration
    //         FROM actual_activity_detail d
    //         JOIN activities a ON d.activity_id = a.id
    //         WHERE d.created_at BETWEEN ? AND ? 
    //         AND d.status = 1 AND a.status = 1
    //         GROUP BY d.activity_id
    //     ", [$startDate, $endDate])->getResultArray();
    
    //     // Data untuk Frekuensi berdasarkan Proyek
    //     // $projectFrequencyData = $this->db->query("
    //     //     SELECT p.model AS project_name, COUNT(d.id) AS frequency
    //     //     FROM actual_activity_detail d
    //     //     JOIN activities a ON d.activity_id = a.id
    //     //     JOIN projects p ON d.project_id = p.id
    //     //     WHERE d.created_at BETWEEN ? AND ? 
    //     //     AND a.status = 1 AND d.status = 1
    //     //     GROUP BY p.model
    //     // ", [$startDate, $endDate])->getResultArray();
    
    //     // Durasi berdasarkan proyek
    //     $projectDurationData = $this->db->query(" 
    //         SELECT 
    //             CONCAT(IFNULL(p.model, ''), IFNULL(p.another_project, '')) AS project_model,
    //             SUM(d.total_time) AS total_duration
    //         FROM actual_activity_detail d
    //         JOIN activities a ON d.activity_id = a.id
    //         JOIN projects p ON d.project_id = p.id
    //         WHERE d.created_at BETWEEN ? AND ? 
    //         AND a.status = 1 AND d.status = 1
    //         GROUP BY p.model, p.another_project
    //     ", [$startDate, $endDate])->getResultArray();
    
    //     // Format data untuk Highcharts
    //     $projectDurationChartData = [];
    //     foreach ($projectDurationData as $row) {
    //         $projectDurationChartData[] = [
    //             'name' => $row['project_model'],
    //             'y'    => (int) $row['total_duration'],
    //             'model' => $row['project_model']
    //         ];
    //     }
   
    //     return view('dashboard/index', [
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
    //         'durationData'  => $durationData,
    //         'projectDurationChartData' => json_encode($projectDurationChartData),
    //     ]);
    // }
 
    public function projectDetail($model) 
    {
        $model = urldecode($model);
        
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
    
        if (!$start_date || !$end_date) {
            $start_date = date('Y-m-01'); 
            $end_date = date('Y-m-t');   
        }
        
        $sql = "
        SELECT 
            d.id AS detail_id,
            COALESCE(NULLIF(p.model, ''), p.another_project) AS project_name,
            NULLIF(p.part_no, '-') AS part_no,
            NULLIF(p.process, '-') AS process,
               NULLIF(p.proses, '-') AS proses,
               d.remark as remark,
            a.name AS activity_name,
            u.nama AS created_by,
            d.total_time
        FROM actual_activity_detail d
        JOIN activities a ON d.activity_id = a.id
        JOIN projects p ON d.project_id = p.id
        JOIN users u ON d.created_by = u.id
        WHERE (p.model = ? OR p.another_project = ?) 
        AND d.status = 1
    ";
    
    
        // Add date filter if provided
        $params = [$model, $model, $start_date, $end_date];
        $sql .= " AND d.created_at BETWEEN ? AND ?";
        
        // Execute the query
        $query = $this->db->query($sql, $params);
        $results = $query->getResultArray();
    
        // Data untuk Highcharts (Pie Chart)
        $activityData = [];
        foreach ($results as $row) {
            $activityName = $row['activity_name'];
            $totalTime = (int) $row['total_time'];
    
            if (isset($activityData[$activityName])) {
                $activityData[$activityName] += $totalTime;
            } else {
                $activityData[$activityName] = $totalTime;
            }
        }
    
        // Format data untuk Highcharts
        $chartData = [];
        foreach ($activityData as $name => $time) {
            $chartData[] = [
                'name' => $name,
                'y' => $time
            ];
        }
    
        return view('dashboard/project_detail', [
            'results' => $results,
            'model' => $model,
            'start_date' => $start_date,  // Pass the start date to the view
            'end_date' => $end_date,      // Pass the end date to the view
            'chartData' => json_encode($chartData) // Encode ke JSON untuk digunakan di Highcharts
        ]);
    }
    
    
}
