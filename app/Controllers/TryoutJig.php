<?php

namespace App\Controllers;

use App\Models\TryoutJigModel;
use App\Models\ProjectModel;
use CodeIgniter\Controller;
use App\Models\DetailClusterModel; // Pastikan model ini diimport
use App\Models\DetailTryoutJigModel;
use App\Models\DetailSettingJigModel; // Pastikan model ini diimport // Pastikan model ini diimport
use CodeIgniter\Database\Database;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\Tcpdf\Fpdi;


class TryoutJig extends Controller
{
    protected $tryoutJigModel;
    protected $projectModel;
    protected $detailClusterModel;
    protected $detailTryoutJigModel;
    protected $userModel;
    protected $detailSettingJigModel;

    public function __construct()
    {
        $this->tryoutJigModel = new TryoutJigModel();
        $this->projectModel = new ProjectModel();
        $this->detailClusterModel = new DetailClusterModel(); // Inisialisasi model
        $this->detailTryoutJigModel = new DetailTryoutJigModel(); // Inisialisasi model
        $this->detailSettingJigModel = new DetailSettingJigModel(); // Inisialisasi model
        $this->userModel = new \App\Models\UserModel(); // Gunakan model User

    }

    public function index() {
        $db = \Config\Database::connect();
        $builder = $db->table('tryout_jigs');
        $builder->select('tryout_jigs.*, COALESCE(projects.part_no, tryout_jigs.project_id) AS part_no');
        $builder->join('projects', 'projects.id = tryout_jigs.project_id', 'left');
        $builder->orderBy('tryout_jigs.created_at', 'DESC'); // Urutkan dari terbaru ke lama
        $query = $builder->get();
    
        $allTryoutJigs = $query->getResultArray();
    
        // Urutkan secara manual agar ID 147 di atas
        usort($allTryoutJigs, function($a, $b) {
            if ($a['id'] == 147) return -1; // ID 147 akan selalu di atas
            if ($b['id'] == 147) return 1;
            return strtotime($b['created_at']) - strtotime($a['created_at']); // Urutkan created_at DESC
        });
    
        $data['tryout_jigs'] = $allTryoutJigs;
    
        return view('tryout-jig/index', $data);
    }



    public function create()
{
    // Ambil hanya project dengan status 1 dan jenis_tooling "Jig"
    $data['projects'] = $this->projectModel
        ->where('status', 1)
        ->where('jenis_tooling', 'Jig')
        ->findAll();

    // Ambil hanya users yang aktif (status = 1)
    $data['users'] = $this->userModel
        ->where('status', 1)
        ->findAll();

    // Ambil daftar Part Levelling dari tabel detailClusterModel
    $partLevellingOptions = $this->detailClusterModel
        ->select('part_levelling')
        ->findAll();
    $data['partLevellingOptions'] = array_column($partLevellingOptions, 'part_levelling');

    return view('tryout-jig/create', $data);
}



public function store()
{
    helper(['form', 'url']);

    $file = $this->request->getFile('image');
    if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move('uploads/tryout-jig', $newName);
    } else {
        $newName = null;
    }

    // Cek apakah "Ketik Lainnya" dipilih untuk Jig No
    $jigNo = $this->request->getPost('project_id');
    if ($jigNo === 'other') {
        $jigNo = strtoupper($this->request->getPost('jig_no_manual'));
    }

    // Ambil nilai dari dropdown atau input manual jika "Ketik Lainnya" dipilih
    $tooling = strtoupper($this->request->getPost('tooling') === 'other' ? $this->request->getPost('tooling_manual') : $this->request->getPost('tooling'));
    $quality = strtoupper($this->request->getPost('quality') === 'other' ? $this->request->getPost('quality_manual') : $this->request->getPost('quality'));
    $produksi = strtoupper($this->request->getPost('produksi') === 'other' ? $this->request->getPost('produksi_manual') : $this->request->getPost('produksi'));
    $ps = strtoupper($this->request->getPost('ps') === 'other' ? $this->request->getPost('ps_manual') : $this->request->getPost('ps'));
    $rnd = strtoupper($this->request->getPost('rnd') === 'other' ? $this->request->getPost('rnd_manual') : $this->request->getPost('rnd'));
    $partName = strtoupper($this->request->getPost('part_name'));

    // **Simpan Tryout Jig utama (hanya sekali)**
    $tryoutId = $this->tryoutJigModel->insert([
    'project_id' => $jigNo, // Gunakan hasil cek di atas
    'event'       => $this->request->getPost('event'),
    'date'       => $this->request->getPost('date'),
    'part_name'   => $partName,
    'projek'     => $this->request->getPost('projek'),
        'cust'       => $this->request->getPost('cust'),
        'm_usage'    => $this->request->getPost('m_usage'),
        'm_spec'     => $this->request->getPost('m_spec'),
        'holder'     => $this->request->getPost('holder'),
        'r_visual'   => $this->request->getPost('r_visual'),
        'r_torque'   => $this->request->getPost('r_torque'),
        'r_cut'      => $this->request->getPost('r_cut'),
        's_visual'   => $this->request->getPost('s_visual'),
        's_torque'   => $this->request->getPost('s_torque'),
        's_cut'      => $this->request->getPost('s_cut'),
        'judge'      => $this->request->getPost('judge'),
        'judgement'  => $this->request->getPost('judgement'),
        't_target'   => $this->request->getPost('t_target'),
        'a_target'   => $this->request->getPost('a_target'),
        't_cycle'    => $this->request->getPost('t_cycle'),
        'a_cycle'    => $this->request->getPost('a_cycle'),
        'shift'      => $this->request->getPost('shift'),
        't_uph'      => $this->request->getPost('t_uph'),
        'a_uph'      => $this->request->getPost('a_uph'),
        'work_h' => $this->request->getPost('work_h') ? $this->request->getPost('work_h') . ' Jam' : null,
        'work_d' => $this->request->getPost('work_d') ? $this->request->getPost('work_d') . ' Hari' : null,
        'whit'       => $this->request->getPost('whit'),
        'whitout'    => $this->request->getPost('whitout'),
        'image'      => $newName,
        'tooling'    => $tooling,
        'quality'    => $quality,
        'produksi'   => $produksi,
        'ps'         => $ps,
        'rnd'        => $rnd
    ], true); // True untuk mengembalikan ID terakhir yang dimasukkan

    // Simpan Detail Cluster
    $partLevelling = $this->request->getPost('part_levelling');
    $partSpecification = $this->request->getPost('part_specification');

    if (!empty($partLevelling) && !empty($partSpecification)) {
        $data = [];
        for ($i = 0; $i < count($partLevelling); $i++) {
            $data[] = [
                'tryout_jig_id'       => $tryoutId,
                'part_levelling'      => strtoupper($partLevelling[$i]),
                'part_specification'  => strtoupper($partSpecification[$i])
            ];
        }
        $this->detailClusterModel->insertBatch($data);
    }
// Ambil data dari request
$problems = $this->request->getPost('problem');
$measures = $this->request->getPost('measure');
$pics = $this->request->getPost('pic');
$picsManual = $this->request->getPost('pic_manual');
$targets = $this->request->getPost('target');
$remarks = $this->request->getPost('remarks');
$progress = $this->request->getPost('progress'); // Tambahkan progress

$data = [];

if (!empty($problems)) {
    foreach ($problems as $index => $problem) {
        if (empty($problem) && empty($measures[$index]) && empty($targets[$index]) && empty($remarks[$index])) {
            continue; // Skip jika semua field kosong
        }

        // Ambil file berdasarkan indeks
        $problemImage = $this->request->getFile("problem_image.$index");
        $imageName = null;

        if ($problemImage && $problemImage->isValid() && !$problemImage->hasMoved()) {
            $imageName = $problemImage->getRandomName();
            $problemImage->move('uploads/tryout-details', $imageName);
        } else {
            // Log error jika file tidak valid
            log_message('error', 'File tidak valid atau gagal diunggah: ' . print_r($problemImage, true));
        }

        // Konversi semua teks ke huruf besar
        $problem = strtoupper($problem);
        $measure = strtoupper($measures[$index] ?? '');
        $remark = strtoupper($remarks[$index] ?? '');

        // Menentukan PIC yang dipilih atau input manual
        $picValue = ($pics[$index] === 'lainnya') ? ($picsManual[$index] ?? '') : ($pics[$index] ?? '');

        $data[] = [
            'tryout_jig_id' => $tryoutId,
            'problem' => $problem,
            'problem_image' => $imageName,
            'measure'       => $measure,
            'pic' => $picValue,
            'target' => $targets[$index] ?? '',
            'progress' => !empty($progress[$index]) ? $progress[$index] . '%' : '0%', // Menyimpan dengan simbol %
            'remarks'       => $remark
        ];
    }

    // Simpan semua data ke database
    if (!empty($data)) {
        $this->detailTryoutJigModel->insertBatch($data);
    }
}





   // **Simpan Detail Settings**
$points = $this->request->getPost('point');
$combinations = $this->request->getPost('combination_result');

if (!empty($points)) {
    $data = [];
    for ($i = 0; $i < count($points); $i++) {
        $data[] = [
            'tryout_jig_id' => $tryoutId,
            'point'         => $points[$i],
            'class'         => $this->request->getPost('class')[$i],
            'combination'   => !empty($combinations[$i]) ? $combinations[$i] : '', // Simpan dalam format "1 x 2 x 3"
            'sched_chanl'   => $this->request->getPost('sched_chanl')[$i] . ' cyc',
            'squeeze'       => $this->request->getPost('squeeze')[$i] . ' cyc',
            'up_slope'      => $this->request->getPost('up_slope')[$i] . ' cyc',
            'w_c1'          => $this->request->getPost('weld_curr_1')[$i] . ' ka',
            'w_t1'          => $this->request->getPost('weld_time_1')[$i] . ' cyc',
            'w_c2'          => $this->request->getPost('weld_curr_2')[$i] . ' ka',
            'w_t2'          => $this->request->getPost('weld_time_2')[$i] . ' cyc',
            'w_c3'          => $this->request->getPost('weld_curr_3')[$i] . ' ka',
            'w_t3'          => $this->request->getPost('weld_time_3')[$i] . ' cyc',
            'press'         => $this->request->getPost('press')[$i] . ' kn',
            'ratio'         => $this->request->getPost('turn_ratio')[$i],
            'hold'          => $this->request->getPost('hold')[$i] . ' cyc',
            'amper'         => $this->request->getPost('amper')[$i] . ' a',
            'volt'          => $this->request->getPost('volt')[$i] . ' v',
            'speed'         => $this->request->getPost('speed')[$i] . ' mm/s'
        ];
    }
    $this->detailSettingJigModel->insertBatch($data);
}



    return redirect()->to('/tryout-jig')->with('success', 'Data berhasil disimpan.');
}

    public function show($id)
{
    // Ambil data tryout berdasarkan ID
    $tryout = $this->tryoutJigModel
        ->select('tryout_jigs.*, COALESCE(projects.part_no, tryout_jigs.project_id) AS part_no')
        ->join('projects', 'projects.id = tryout_jigs.project_id', 'left')
        ->where('tryout_jigs.id', $id)
        ->first();

    if (!$tryout) {
        return redirect()->to('tryout-jig')->with('error', 'Data tidak ditemukan');
    }

    // Ambil detail cluster terkait
    $details = $this->detailClusterModel->where('tryout_jig_id', $id)->findAll();

    // Ambil detail tryout terkait
    $detailTryout = $this->detailTryoutJigModel->where('tryout_jig_id', $id)->findAll();

    // Ambil detail settings terkait
    $detailSettings = $this->detailSettingJigModel->where('tryout_jig_id', $id)->findAll();

    // Kirim data ke view
    return view('tryout-jig/show', [
        'tryout' => $tryout,
        'details' => $details,
        'detail_tryout' => $detailTryout, // Mengirim data detail tryout
        'detail_settings' => $detailSettings, // Tambahkan ini

    ]);
}

public function edit($id)
{
    $data['projects'] = $this->projectModel
    ->where('status', 1)
    ->where('jenis_tooling', 'Jig')
    ->findAll();
    
    $data['users'] = $this->userModel->findAll(); // Ambil daftar pengguna untuk dropdown PIC

    // Ambil data Tryout Jig berdasarkan ID
    $data['tryout_jig'] = $this->tryoutJigModel->find($id);

    // Ambil data Detail Cluster berdasarkan Tryout Jig ID
    $data['detail_clusters'] = $this->detailClusterModel->where('tryout_jig_id', $id)->findAll();

    // Ambil data Detail Tryout berdasarkan Tryout Jig ID
    $data['detail_tryouts'] = $this->detailTryoutJigModel->where('tryout_jig_id', $id)->findAll();

    // Ambil data Detail Settings berdasarkan Tryout Jig ID
    $data['detail_settings'] = $this->detailSettingJigModel->where('tryout_jig_id', $id)->findAll();

    // Ambil daftar Part Levelling dari tabel detailClusterModel
    $partLevellingOptions = $this->detailClusterModel->select('part_levelling')->findAll();
    $data['partLevellingOptions'] = array_column($partLevellingOptions, 'part_levelling');

    return view('tryout-jig/edit', $data);
}

public function delete($id)
{
    // Cek apakah data tryout_jig ada
    $tryout = $this->tryoutJigModel->find($id);
    if (!$tryout) {
        return redirect()->to('tryout-jig')->with('error', 'Data tidak ditemukan');
    }

    // Hapus data yang terkait dengan tryout_jig ini
    $this->detailClusterModel->where('tryout_jig_id', $id)->delete(); // Hapus Detail Cluster
    $this->detailTryoutJigModel->where('tryout_jig_id', $id)->delete(); // Hapus Detail Tryout
    $this->detailSettingJigModel->where('tryout_jig_id', $id)->delete(); // Hapus Detail Setting

    // Hapus data tryout_jig utama
    $this->tryoutJigModel->delete($id);

    return redirect()->to('tryout-jig')->with('success', 'Data berhasil dihapus');
}
 
public function update($id)
{
    helper(['form', 'url']);

    $file = $this->request->getFile('image');
    $newName = null;

    if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move('uploads/tryout-jig', $newName);
    }
// Cek apakah "Ketik Lainnya" dipilih untuk Jig No
$jigNo = $this->request->getPost('project_id');
if ($jigNo === 'other') {
    $jigNo = $this->request->getPost('jig_no_manual');
}
    // Update Tryout Jig utama
    $data = [
        'project_id' => $jigNo, // Gunakan hasil cek di atas
        'event'      => $this->request->getPost('event'),
        'date'       => $this->request->getPost('date'),
        'part_name'  => $this->request->getPost('part_name'),
        'projek'     => $this->request->getPost('projek'),
        'cust'       => $this->request->getPost('cust'),
        'm_usage'    => $this->request->getPost('m_usage'),
        'm_spec'     => $this->request->getPost('m_spec'),
        'holder'     => $this->request->getPost('holder'),
        'r_visual'   => $this->request->getPost('r_visual'),
        'r_torque'   => $this->request->getPost('r_torque'),
        'r_cut'      => $this->request->getPost('r_cut'),
        's_visual'   => $this->request->getPost('s_visual'),
        's_torque'   => $this->request->getPost('s_torque'),
        's_cut'      => $this->request->getPost('s_cut'),
        'judge'      => $this->request->getPost('judge'),
        'judgement'  => $this->request->getPost('judgement'),
        't_target'   => $this->request->getPost('t_target'),
        'a_target'   => $this->request->getPost('a_target'),
        't_cycle'    => $this->request->getPost('t_cycle'),
        'a_cycle'    => $this->request->getPost('a_cycle'),
        'shift'      => $this->request->getPost('shift'),
        't_uph'      => $this->request->getPost('t_uph'),
        'a_uph'      => $this->request->getPost('a_uph'),
        'work_h'     => $this->request->getPost('work_h') ? $this->request->getPost('work_h') . ' Jam' : null,
        'work_d'     => $this->request->getPost('work_d') ? $this->request->getPost('work_d') . ' Hari' : null,
        'whit'       => $this->request->getPost('whit'),
        'whitout'    => $this->request->getPost('whitout'),
    ];

    if ($newName) {
        $data['image'] = $newName;
    }

    $this->tryoutJigModel->update($id, $data);

    // Update Detail Cluster
    $this->detailClusterModel->where('tryout_jig_id', $id)->delete();
    $partLevelling = $this->request->getPost('part_levelling');
    $partSpecification = $this->request->getPost('part_specification');

    if (!empty($partLevelling) && !empty($partSpecification)) {
        $data = [];
        for ($i = 0; $i < count($partLevelling); $i++) {
            $data[] = [
                'tryout_jig_id' => $id,
                'part_levelling' => $partLevelling[$i],
                'part_specification' => $partSpecification[$i]
            ];
        }
        $this->detailClusterModel->insertBatch($data);
    }

    // Simpan gambar lama sebelum menghapus data lama
$oldImages = $this->request->getPost('old_problem_image');

$this->detailTryoutJigModel->where('tryout_jig_id', $id)->delete();

$problems = $this->request->getPost('problem');
$measures = $this->request->getPost('measure');
$pics = $this->request->getPost('pic');
$progress = $this->request->getPost('progress');
$targets = $this->request->getPost('target');
$remarks = $this->request->getPost('remarks');
$problemImages = $this->request->getFileMultiple('problem_image');

if (!empty($problems)) {
    $data = [];
    foreach ($problems as $index => $problem) {
        $problemImage = $problemImages[$index] ?? null;
        $imageName = $oldImages[$index] ?? null; // Default pakai gambar lama

        // Jika ada file baru diunggah, gunakan file baru
        if ($problemImage && $problemImage->isValid() && !$problemImage->hasMoved()) {
            $imageName = $problemImage->getRandomName();
            $problemImage->move('uploads/tryout-details', $imageName);
        }

        $data[] = [
            'tryout_jig_id' => $id,
            'problem' => $problem,
            'problem_image' => $imageName, // Simpan gambar lama atau baru
            'measure' => $measures[$index] ?? '',
            'pic' => $pics[$index] ?? '',
            'progress' => !empty($progress[$index]) ? $progress[$index] . '%' : '0%', // Konsisten dengan store
            'target' => $targets[$index] ?? '',
            'remarks' => $remarks[$index] ?? ''
        ];
    }
    $this->detailTryoutJigModel->insertBatch($data);
}

    $tryoutJigModel = new TryoutJigModel();

    // Ambil input dari form
    $roles = ['tooling', 'quality', 'produksi', 'ps', 'rnd'];
    $dataToUpdate = [];

    foreach ($roles as $role) {
        $selectedValue = $this->request->getPost($role);
        $manualInput = $this->request->getPost("{$role}_manual");

        // Jika user memilih "Ketik Lainnya", simpan manual input, jika tidak simpan value yang dipilih
        $dataToUpdate[$role] = ($selectedValue === 'other') ? $manualInput : $selectedValue;
    }

    // Update data ke database
    $tryoutJigModel->update($id, $dataToUpdate);

    // Update Detail Settings
    $this->detailSettingJigModel->where('tryout_jig_id', $id)->delete();
    $points = $this->request->getPost('point');
    $combinations = $this->request->getPost('combination_result');

    if (!empty($points)) {
        $data = [];
        for ($i = 0; $i < count($points); $i++) {
            $data[] = [
                'tryout_jig_id' => $id,
                'point'         => $points[$i],
                'class'         => $this->request->getPost('class')[$i],
                'combination'   => !empty($combinations[$i]) ? $combinations[$i] : '', // Simpan dalam format "1 x 2 x 3"
                'sched_chanl'   => $this->request->getPost('sched_chanl')[$i] . ' cyc',
                'squeeze'       => $this->request->getPost('squeeze')[$i] . ' cyc',
                'up_slope'      => $this->request->getPost('up_slope')[$i] . ' cyc',
                'w_c1'          => $this->request->getPost('weld_curr_1')[$i] . ' ka',
                'w_t1'          => $this->request->getPost('weld_time_1')[$i] . ' cyc',
                'w_c2'          => $this->request->getPost('weld_curr_2')[$i] . ' ka',
                'w_t2'          => $this->request->getPost('weld_time_2')[$i] . ' cyc',
                'w_c3'          => $this->request->getPost('weld_curr_3')[$i] . ' ka',
                'w_t3'          => $this->request->getPost('weld_time_3')[$i] . ' cyc',
                'press'         => $this->request->getPost('press')[$i] . ' kn',
                'ratio'         => $this->request->getPost('turn_ratio')[$i],
                'amper'         => $this->request->getPost('amper')[$i] . ' a',
                'volt'          => $this->request->getPost('volt')[$i] . ' v',
                'hold'          => $this->request->getPost('hold')[$i] . ' cyc',
                'speed'         => $this->request->getPost('speed')[$i] . ' mm/s'
            ];
        }
        $this->detailSettingJigModel->insertBatch($data);
    }

    return redirect()->to(site_url('tryout-jig'))->with('success', 'Data berhasil diperbarui');
}
public function exportPdf($id)
{
    // Bersihkan output buffer untuk menghindari data tak diinginkan
    ob_clean();
    ob_start();

    // Ambil data tryout berdasarkan ID
    $tryout = $this->tryoutJigModel->find($id);
    if (!$tryout) {
        return redirect()->to('/tryout-jig')->with('error', 'Data Tryout tidak ditemukan!');
    }

    // **Inisialisasi variabel awal untuk mencegah error**
    $part_no = '-';
    $process = '-';
    $proses = '-';

      // Cek apakah project_id adalah angka (ID) atau teks manual
    if (is_numeric($tryout['project_id'])) {
        // Kalau ID, ambil data dari tabel projects
        $project = $this->projectModel->find($tryout['project_id']);
        if ($project) {
            $part_no = $project['part_no'];
            $process = isset($project['process']) && !empty($project['process']) ? $project['process'] : '-';
            $proses = isset($project['proses']) && !empty($project['proses']) ? $project['proses'] : '-';
        } else {
            $part_no = $tryout['project_id']; // Gunakan nilai manual kalau project tidak ditemukan
        }
    } else {
        // Kalau bukan ID (manual input), langsung pakai nilainya
        $part_no = $tryout['project_id'];
    }

    // Ambil data detail tryout
    $detail_tryouts = $this->detailTryoutJigModel->where('tryout_jig_id', $id)->findAll();
    $detail_clusters = $this->detailClusterModel->where('tryout_jig_id', $id)->findAll();
    $detail_settings = $this->detailSettingJigModel->where('tryout_jig_id', $id)->findAll();


    // Path ke template PDF Tryout Jig
    $templatePath = FCPATH . 'templates/template-jig.pdf';
    if (!file_exists($templatePath)) {
        return redirect()->to('/tryout-jig')->with('error', 'Template PDF tidak ditemukan!');
    }

    // Buat objek PDF dengan FPDI berbasis TCPDF
    $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
    $pdf->SetAutoPageBreak(false, 0);

    
    // Impor template PDF
    $pdf->setSourceFile($templatePath);
    $pdf->AddPage();
    $tplIdx = $pdf->importPage(1);
    $pdf->useTemplate($tplIdx, 0, 0, 210);

    // Set font dan ukuran teks
    $pdf->SetFont('dejavusans', '', 9);

    // **Menambahkan data ke dalam template PDF**
    $pdf->SetXY(116, 36);
    $pdf->Cell(60, 5, $part_no, 0, 1); // ✅ FIX: Bisa pakai database atau manual input

    $pdf->SetXY(116, 58);
    $pdf->Cell(60, 5, $process, 0, 1);

    $pdf->SetXY(129, 58);
    $pdf->Cell(60, 5, $proses, 0, 1);

    
// Menambahkan data tryout jig
$pdf->SetFont('dejavusans', '', 11);
$pdf->SetXY(25, 28);
$pdf->Cell(60, 5, '' . $tryout['event'], 0, 1);

$pdf->SetXY(120, 28);
$pdf->Cell(60, 5, '' . $tryout['date'], 0, 1);
    // Ukuran dan posisi area gambar
    $boxWidth = 64;  // Lebar gambar maksimal
    $boxHeight = 51; // Tinggi gambar maksimal
    $boxX = 4;       // Posisi X
    $boxY = 42;      // Posisi Y

    // Jika ada gambar, sesuaikan ukurannya agar tetap dalam batas
    if (!empty($tryout['image'])) {
        $imagePath = 'uploads/tryout-jig/' . $tryout['image'];

        if (file_exists($imagePath)) {
            // Ambil ukuran asli gambar
            list($origWidth, $origHeight) = getimagesize($imagePath);

            // Hitung skala agar pas dalam area tanpa distorsi
            $scale = min($boxWidth / $origWidth, $boxHeight / $origHeight);
            $imageWidth = $origWidth * $scale;
            $imageHeight = $origHeight * $scale;

            // Hitung posisi tengah agar gambar pas
            $imageX = $boxX + ($boxWidth - $imageWidth) / 2;
            $imageY = $boxY + ($boxHeight - $imageHeight) / 2;

            // Tampilkan gambar tanpa garis tepi
            $pdf->Image($imagePath, $imageX, $imageY, $imageWidth, $imageHeight);
        } 
    }

    
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->SetXY(116, 52);
    $pdf->Cell(60, 5, '' . $tryout['projek'], 0, 1);

    $pdf->SetXY(116, 41);
    $pdf->Cell(60, 5, '' . $tryout['part_name'], 0, 1);

    $pdf->SetXY(116, 47);
    $pdf->Cell(60, 5, '' . $tryout['cust'], 0, 1);

    $pdf->SetXY(27, 151);
    $pdf->Cell(60, 5, '' . $tryout['m_usage'], 0, 1);

    $pdf->SetXY(27, 156);
    $pdf->Cell(60, 5, '' . $tryout['m_spec'], 0, 1);

    $pdf->SetXY(27, 162);
    $pdf->Cell(60, 5, '' . $tryout['holder'], 0, 1);

    $pdf->SetXY(98, 151);
    $pdf->Cell(60, 5, '' . $tryout['r_visual'], 0, 1);

    $pdf->SetXY(98, 156);
    $pdf->Cell(60, 5, '' . $tryout['r_torque'], 0, 1);

    $pdf->SetXY(98, 161);
    $pdf->Cell(60, 5, '' . $tryout['r_cut'], 0, 1);

    $pdf->SetXY(158, 151);
    $pdf->Cell(60, 5, '' . $tryout['s_visual'], 0, 1);

    $pdf->SetXY(158, 156);
    $pdf->Cell(60, 5, '' . $tryout['s_torque'], 0, 1);

    $pdf->SetXY(158, 161);
    $pdf->Cell(60, 5, '' . $tryout['s_cut'], 0, 1);

    

    $pdf->SetXY(30, 186);
    $pdf->Cell(60, 5, '' . $tryout['t_target'], 0, 1);

    $pdf->SetXY(51, 186);
    $pdf->Cell(60, 5, '' . $tryout['a_target'], 0, 1);

    $pdf->SetXY(30, 192);
    $pdf->Cell(60, 5, '' . $tryout['t_cycle'], 0, 1);

    $pdf->SetXY(51, 192);
    $pdf->Cell(60, 5, '' . $tryout['a_cycle'], 0, 1);

    $pdf->SetXY(100, 186);
    $pdf->Cell(60, 5, '' . $tryout['shift'], 0, 1);

    $pdf->SetXY(30, 197);
    $pdf->Cell(60, 5, '' . $tryout['t_uph'], 0, 1);

    $pdf->SetXY(51, 197);
    $pdf->Cell(60, 5, '' . $tryout['a_uph'], 0, 1);

    $pdf->SetXY(100, 180);
    $pdf->Cell(60, 5, '' . $tryout['work_h'], 0, 1);

    $pdf->SetXY(100, 192);
    $pdf->Cell(60, 5, '' . $tryout['work_d'], 0, 1);

    $pdf->SetXY(112, 197);
    $pdf->Cell(60, 5, '' . $tryout['whit'], 0, 1);

    $pdf->SetXY(145, 197);
    $pdf->Cell(60, 5, '' . $tryout['whitout'], 0, 1);


    $pdf->SetFont('dejavusans', '', 7);

    $startXLeft = 81; // Posisi awal X untuk sisi kiri
    $startXRight = 150; // Posisi awal X untuk sisi kanan
    $startY = 67; // Posisi awal Y
    $lineHeight = 6; // Tinggi setiap baris
    
    foreach ($detail_clusters as $index => $cluster) {
        // Tentukan apakah akan di sisi kiri atau kanan
        if ($index < 5) {
            $currentX = $startXLeft; // Sisi kiri
            $currentY = $startY + ($index * $lineHeight);
        } else {
            $currentX = $startXRight; // Sisi kanan
            $currentY = $startY + (($index - 5) * $lineHeight);
        }
    
        // Nomor urut
        $pdf->SetXY($currentX - 10, $currentY);
        $pdf->Cell(8, 6, ($index + 1) . '.', 0, 0, 'C'); // Nomor urut rata tengah
    
        // Part Levelling
        $pdf->SetXY($currentX, $currentY);
        $pdf->Cell(60, 6, $cluster['part_levelling'], 0, 0, 'L');
    
        // Part Specification (beri jarak setelah Part Levelling)
        $pdf->SetX($currentX + 31);
        $pdf->Cell(110, 6, $cluster['part_specification'], 0, 0, 'L');
    }
    
    
    
    
$pdf->SetFont('dejavusans', '', 7);

$yPosition = 108; // Mulai setelah header
$rowHeight = 5; // Tinggi setiap baris

foreach ($detail_settings as $index => $setting) {
    $xPos = 3; // Posisi awal X

    // Kolom Point
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(7, $rowHeight, $setting['point'], 0, 0, 'C');
    $xPos += 10;

    // Kolom Class
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(7, $rowHeight, $setting['class'], 0, 0, 'C');
    $xPos += 10;

     $pdf->SetFont('dejavusans', '', 6); // Ukuran lebih kecil
    $pdf->SetXY($xPos, $yPosition);
    $pdf->MultiCell(37, 4, $setting['combination'], 0, 'L');
    $pdf->SetFont('dejavusans', '', 7); // Kembali ke ukuran normal
    $xPos += 39;

    // Kolom Sched Chanl
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(8, $rowHeight, $setting['sched_chanl'],0, 0, 'C');
    $xPos += 10;

    // Kolom Squeeze
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(8, $rowHeight, $setting['squeeze'], 0, 0, 'C');
    $xPos += 9;

    // Kolom Up Slope
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(8, $rowHeight, $setting['up_slope'], 0, 1, 'C');
    $xPos += 10;
    
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['hold'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['w_c1'], 0, 0, 'C');
    $xPos += 11;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['w_t1'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(8, $rowHeight, $setting['w_c2'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(8, $rowHeight, $setting['w_t2'], 0, 0, 'C');
    $xPos += 9;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['w_c3'], 0, 0, 'C');
    $xPos += 9;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['w_t3'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['press'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['ratio'],0, 0, 'C');
    $xPos += 9;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(10, $rowHeight, $setting['amper'], 0, 0, 'C');
    $xPos += 10;

    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['volt'], 0, 0, 'C');
    $xPos += 9;

    $pdf->SetFont('dejavusans', '', 6); // Ukuran lebih kecil
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(9, $rowHeight, $setting['speed'], 0, 0, 'C');
    $xPos += 9;

    
   

    // Update Y posisi agar tidak bertumpuk
    $yPosition += $rowHeight;
}

// Pastikan posisi tetap untuk semua file
$pdf->SetY(155);
$pdf->SetX(194);
$pdf->SetFont('dejavusans', 'B', 14);

// **JUDGE**
$judge = strtoupper($tryout['judge']);
if ($judge == 'OK') {
    $pdf->SetTextColor(0, 128, 0); // Hijau
} elseif ($judge == 'NG') {
    $pdf->SetTextColor(255, 0, 0); // Merah
}
$pdf->Cell(50, 10, $judge, 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0); // Reset warna

// **JUDGEMENT** (Pastikan jaraknya tetap)
$pdf->SetY(186);
$pdf->SetX(194);
$judgement = strtoupper($tryout['judgement']);
if ($judgement == 'OK') {
    $pdf->SetTextColor(0, 128, 0); // Hijau
} elseif ($judgement == 'NG') {
    $pdf->SetTextColor(255, 0, 0); // Merah
}
$pdf->Cell(50, 10, $judgement, 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0); // Reset warna

// Set font dan ukuran teks
$pdf->SetFont('dejavusans', '', 6);

// Array kolom tanda tangan
$ttdColumns = [
    ['x' => 2, 'label' => $tryout['tooling']],
    ['x' => 22, 'label' => $tryout['quality']],
    ['x' => 42, 'label' => $tryout['produksi']],
    ['x' => 62, 'label' => $tryout['ps']],
    ['x' => 80, 'label' => $tryout['rnd']]
];

// Loop untuk menambahkan tanda tangan dengan teks rata tengah
foreach ($ttdColumns as $col) {
    $pdf->SetXY($col['x'], 284);
    $pdf->MultiCell(20, 5, $col['label'], 'B', 'C', false); // Hanya border bawah
}

// Menambahkan tabel **Detail Problem**
$yPosition = 210; // Posisi awal tabel Detail Problem
$rowHeight = 27; // Tinggi baris
$no = 1; // Nomor awal
$startX = 2; // Posisi awal X

$pdf->SetFont('dejavusans', '', 8); // Font lebih kecil
$pdf->SetTextColor(0, 0, 0); // Reset warna teks ke hitam

// Loop untuk data **Detail Problem**
foreach ($detail_tryouts as $index => $detail) {
    // Ambil data untuk ditampilkan
    $problemText = !empty($detail['problem']) ? trim($detail['problem']) : '-';
    $measure = !empty($detail['measure']) ? trim($detail['measure']) : '-';
    $pic = !empty($detail['pic']) ? trim($detail['pic']) : '-';
    $progress = !empty($detail['progress']) ? (int)trim($detail['progress']) : 0; // Pastikan progress berupa angka
    $target = !empty($detail['target']) ? trim($detail['target']) : '-';
    $remarks = !empty($detail['remarks']) ? trim($detail['remarks']) : '-';

    // Jika baris melebihi 2 poin, pindahkan ke halaman kedua
    if ($no > 2 && $index == 2) {
        $pdf->AddPage();
        $tplIdx = $pdf->importPage(2); // Gunakan halaman kedua dari template
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        // Reset posisi Y untuk halaman kedua
        $yPosition = 40; // Sesuaikan posisi awal di halaman kedua
    }

    // Tampilkan baris
    $pdf->SetXY($startX, $yPosition);
    $pdf->Cell(10, $rowHeight, $no, 0, 0, 'C'); // Nomor

    // Kolom Problem
    $xPos = $startX + 10;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(50, $rowHeight, '', 0, 0); // Border kolom
    if (!empty($detail['problem_image']) && file_exists(FCPATH . 'uploads/tryout-details/' . $detail['problem_image'])) {
        // Ambil ukuran asli gambar
        list($originalWidth, $originalHeight) = getimagesize(FCPATH . 'uploads/tryout-details/' . $detail['problem_image']);
    
        // Maksimum ukuran dalam PDF
        $maxWidth = 46;  // Sesuai dengan lebar kolom Problem
        $maxHeight = 15; // Sesuai dengan tinggi baris
    
        // Hitung rasio asli
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = $originalWidth * $ratio;
        $newHeight = $originalHeight * $ratio;
    
        // Hitung posisi agar gambar tetap di tengah secara vertikal
        $imageX = $xPos + 2; // Sesuaikan dengan padding kiri
        $imageY = $yPosition + 2 + (($maxHeight - $newHeight) / 2); // Pusatkan secara vertikal
    
        // Tambahkan gambar dengan ukuran yang sesuai
        $pdf->Image(FCPATH . 'uploads/tryout-details/' . $detail['problem_image'], $imageX, $imageY, $newWidth, $newHeight);
    }
    $pdf->SetXY($xPos + 2, $yPosition + 17);
    $pdf->MultiCell(46, 4, $problemText, 0, 'L');

    // Kolom Measure
    $xPos += 50;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(38, $rowHeight, '', 0, 0);
    $pdf->SetXY($xPos + 2, $yPosition + 2);
    $pdf->MultiCell(37, 4, $measure, 0, 'L');

    // Kolom Target
    $xPos += 39;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(29, $rowHeight, '', 0, 0);
    $pdf->SetXY($xPos + 2, $yPosition + 2);
    $pdf->MultiCell(29, 4, $target, 0, 'L');

    $pdf->SetFont('dejavusans', '', 7);
    // Kolom PIC
    $xPos += 29;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(21, $rowHeight, '', 0, 0);
    $pdf->SetXY($xPos + 2, $yPosition + 2);
    $pdf->MultiCell(21, 4, $pic, 0, 'L');
    $pdf->SetFont('dejavusans', '', 8);

    // Kolom Progress (Diagram Arsir)
    $xPos += 21;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(29, $rowHeight, '', 0, 0);

    // Generate gambar progress (diagram arsir) dan tampilkan
    $progressImage = $this->generateProgressCircle($progress);
    $progressX = $xPos + 5;
    $progressY = $yPosition + ($rowHeight / 2) - 10; // Sesuaikan posisi tengah
    $pdf->Image($progressImage, $progressX, $progressY, 20, 20);

    // Kolom Remarks
    $xPos += 30;
    $pdf->SetXY($xPos, $yPosition);
    $pdf->Cell(28, $rowHeight, '', 0, 0);
    $pdf->SetXY($xPos + 2, $yPosition + 2);
    $pdf->MultiCell(28, 4, $remarks, 0, 'L');

    // Perbarui posisi Y untuk baris berikutnya
    $yPosition += $rowHeight;
    $no++;
}


    // **Set header respons agar PDF tidak error**
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="TryoutJig_' . $id . '.pdf"');
    header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=0');
    header('Pragma: public');

    // **Menyimpan atau Menampilkan PDF**
    $pdf->Output('TryoutJig_' . $id . '.pdf', 'I');

    // Bersihkan buffer output setelah output PDF
    ob_end_flush();
    exit;
}
private function generateProgressCircle($percentage)
{
    $targetDiameter = 66; // Ukuran diameter output yang diinginkan
    $scale = 3; // Faktor skala untuk resolusi tinggi
    $diameter = $targetDiameter * $scale; // Diameter gambar asli

    // Buat gambar resolusi tinggi
    $image = imagecreatetruecolor($diameter, $diameter);
    imagesavealpha($image, true);
    $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $transparent);

    // Warna untuk border dan fill
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);

    // Offset untuk mengecilkan lingkaran
    $offset = 10 * $scale; // Sesuaikan nilai offset (misal 10 piksel * scale)

    // Gambar border lingkaran dengan posisi dan ukuran disesuaikan
    imagearc(
        $image, 
        $diameter / 2, 
        $diameter / 2, 
        $diameter - 2 * $offset, 
        $diameter - 2 * $offset, 
        0, 
        360, 
        $black
    );

    // Gambar fill sektor progress dengan offset yang sama
    if ($percentage > 0) {
        $startAngle = -90;
        $endAngle = $startAngle + (360 * $percentage / 100);
        imagefilledarc(
            $image, 
            $diameter / 2, 
            $diameter / 2, 
            $diameter - 2 * $offset, 
            $diameter - 2 * $offset, 
            $startAngle, 
            $endAngle, 
            $black, 
            IMG_ARC_PIE
        );
    }

    // Downscale gambar ke ukuran target untuk hasil yang lebih halus
    $finalImage = imagecreatetruecolor($targetDiameter, $targetDiameter);
    imagesavealpha($finalImage, true);
    $transparentFinal = imagecolorallocatealpha($finalImage, 0, 0, 0, 127);
    imagefill($finalImage, 0, 0, $transparentFinal);

    imagecopyresampled($finalImage, $image, 0, 0, 0, 0, $targetDiameter, $targetDiameter, $diameter, $diameter);

    // Simpan gambar ke file temporary
    $tempPath = sys_get_temp_dir() . '/progress_' . $percentage . '.png';
    imagepng($finalImage, $tempPath);

    imagedestroy($image);
    imagedestroy($finalImage);

    return $tempPath;
}


}
