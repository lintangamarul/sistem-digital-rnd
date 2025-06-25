<?php

namespace App\Controllers;

use App\Models\TryoutModel;
use App\Models\ProjectModel;
use App\Models\DetailTryoutModel;
use CodeIgniter\Controller;
use setasign\Fpdi\Tcpdf\Fpdi;
use App\Libraries\PDF;

class Tryout extends Controller
{
    protected $tryoutModel;
    protected $projectModel;
    protected $detailTryoutModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->tryoutModel = new TryoutModel();
        $this->projectModel = new ProjectModel();
        $this->detailTryoutModel = new DetailTryoutModel(); 
        $this->userModel = new \App\Models\UserModel(); 
        $this->db = \Config\Database::connect();

    }

    public function index($type = null)
    {
        if ($type === 'jig') {
            $data['tryouts'] = $this->tryoutModel
                ->where('activity', 'Tryout Report Jig')
                ->orderBy('created_at', 'DESC')
                ->getTryouts(); 
            return view('tryout/jig', $data);
        }

        $projects = $this->projectModel->findAll();
        $data['projects'] = [];
        foreach ($projects as $project) {
            $data['projects'][$project['id']] = $project;
        }

        $allTryouts = $this->tryoutModel
            ->where('activity', 'Tryout Report Dies')
            ->getTryouts();

        usort($allTryouts, function($a, $b) {
            if ($a['id'] == 160) return -1;
            if ($b['id'] == 160) return 1;
            return strtotime($b['created_at']) - strtotime($a['created_at']); 
        });

        $data['tryouts'] = $allTryouts;

        return view('tryout/index', $data);
    }

    public function create()
    {
        $data['projects'] = $this->projectModel->findAll();

        $data['users'] = $this->db->table('users')
            ->select('id, nama, department')
            ->where('status', 5)
            ->get()
            ->getResult();

        return view('tryout/create', $data);
    }

    public function store()
    {
        // Process main form data
        $partTrialSource = $this->request->getPost('part_trial_source');
        if ($partTrialSource === 'camera') {
            $partTrialImage = $this->request->getFile('part_trial_image_camera');
        } else {
            $partTrialImage = $this->request->getFile('part_trial_image');
        }
        $partTrialImageName = null;
        if ($partTrialImage && $partTrialImage->isValid() && !$partTrialImage->hasMoved()) {
            $partTrialImageName = $partTrialImage->getRandomName();
            $partTrialImage->move('uploads/part_trial/', $partTrialImageName);
        }

        // Cek sumber gambar untuk Material
        $materialSource = $this->request->getPost('material_source');
        if ($materialSource === 'camera') {
            $materialImage = $this->request->getFile('material_image_camera');
        } else {
            $materialImage = $this->request->getFile('material_image');
        }
        $materialImageName = null;
        if ($materialImage && $materialImage->isValid() && !$materialImage->hasMoved()) {
            $materialImageName = $materialImage->getRandomName();
            $materialImage->move('uploads/material/', $materialImageName);
        }

        $problemSource = $this->request->getPost('problem_source');
        if ($problemSource === 'camera') {
            $problemImage = $this->request->getFile('problem_image_camera');
        } else {
            $problemImage = $this->request->getFile('problem_image');
        }
        $problemImageName = null;
        if ($problemImage && $problemImage->isValid() && !$problemImage->hasMoved()) {
            $problemImageName = $problemImage->getRandomName();
            $problemImage->move('uploads/problems/', $problemImageName);
        }

        try {
            // Simpan data utama ke database tryouts
            $tryoutId = $this->tryoutModel->insert([
                'project_id'            => trim($this->request->getPost('project_id')),
                'mc_line'               => trim($this->request->getPost('mc_line')),
                'slide_dh'              => $this->formatValueWithUnit($this->request->getPost('slide_dh'), 'mm'),
                'adaptor'               => $this->formatValueWithUnit($this->request->getPost('adaptor'), 'mm'),
                'cush_press'            => $this->formatValueWithUnit($this->request->getPost('cush_press'), $this->request->getPost('cush_press_unit')),
                'cush_h'                => $this->formatValueWithUnit($this->request->getPost('cush_h'), 'mm'),
                'main_press'            => $this->formatValueWithUnit($this->request->getPost('main_press'), 'N'),
                'spm'                   => $this->formatValueWithUnit($this->request->getPost('spm'), 'stroke'),
                'gsph'                  => $this->formatValueWithUnit($this->request->getPost('gsph'), 'stroke/jam'),
                'boolster'              => trim($this->request->getPost('boolster')),
                'dates'                 => trim($this->request->getPost('dates')),
                'part_trial_image'      => $partTrialImageName,
                'material_image'        => $materialImageName,
                'problem_image'         => $problemImageName,
                'material_pakai'        => trim($this->request->getPost('material_pakai')),
                'material_sisa'         => trim($this->request->getPost('material_sisa')),
                'part_target'           => trim($this->request->getPost('part_target')),
                'part_act'              => trim($this->request->getPost('part_act')),
                'part_judge'            => trim($this->request->getPost('part_judge')),
                'trial_time'            => substr(trim($this->request->getPost('trial_time')), 0, 5),
                'trial_maker'           => trim($this->request->getPost('trial_maker')),
                'projek'                => trim($this->request->getPost('projek')),
                'step'                  => trim($this->request->getPost('step')),
                'event'                 => trim($this->request->getPost('event')),
                'part_up'               => trim($this->request->getPost('part_up')),
                'part_std'              => trim($this->request->getPost('part_std')),
                'part_down'             => trim($this->request->getPost('part_down')),
                'panel_ok'              => trim($this->request->getPost('panel_ok')),
                'material'              => trim($this->request->getPost('material')),
                'activity'              => trim($this->request->getPost('activity')),
                'cust'                  => trim($this->request->getPost('cust')),

                // Pastikan yang tersimpan adalah input manual jika diisi, jika tidak, gunakan yang dari dropdown
                'konfirmasi_produksi'   => trim($this->request->getPost('konfirmasi_produksi_manual')) ?: trim($this->request->getPost('konfirmasi_produksi')),
                'konfirmasi_qc'         => trim($this->request->getPost('konfirmasi_qc_manual')) ?: trim($this->request->getPost('konfirmasi_qc')),
                'konfirmasi_tooling'    => trim($this->request->getPost('konfirmasi_tooling_manual')) ?: trim($this->request->getPost('konfirmasi_tooling')),
                'konfirmasi_rd'         => trim($this->request->getPost('konfirmasi_rd_manual')) ?: trim($this->request->getPost('konfirmasi_rd')),
            ]);

            // Proses detail tryout data
            $problemCount = (int) $this->request->getPost('problem_count');
            $problemData = [];

            for ($i = 0; $i < $problemCount; $i++) {
                $problemImage = $this->request->getFile("problem_image_{$i}");
                $problemImageName = null;

                if ($problemImage && $problemImage->isValid() && !$problemImage->hasMoved()) {
                    $problemImageName = $problemImage->getRandomName();
                    $problemImage->move('uploads/problems/', $problemImageName);
                }

                // Get PIC information
                $pic = $this->request->getPost("pic_{$i}") ?: null;

                // Add data to batch array
                $problemData[] = [
                    'tryout_id'      => $tryoutId,
                    'problem_image'  => $problemImageName,
                    'problem_text'   => $this->request->getPost("problem_text_{$i}"),
                    'counter_measure'=> $this->request->getPost("counter_measure_{$i}") ?: null,
                    'pic'            => $pic,
                    'target'         => $this->request->getPost("target_{$i}") ?: null,
                    'progress'       => $this->request->getPost("progress_{$i}") ?: '0',
                ];
            }

            // Insert batch if there's data
            if (!empty($problemData)) {
                $this->detailTryoutModel->insertBatch($problemData);
            }

            // Return success response
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'id' => $tryoutId
            ]);

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            // Return error response
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }

public function show($id)
{
    $userModel = model('UserModel');
    $projectModel = model('ProjectModel'); // Pastikan ProjectModel sudah ada

    // Ambil data tryout berdasarkan ID
    $data['tryout'] = $this->tryoutModel->find($id);

    if (!$data['tryout']) {
        return redirect()->to('/tryout')->with('error', 'Data Tryout tidak ditemukan!');
    }

    // Ambil data project berdasarkan project_id dari tryout
    $data['project'] = $projectModel->find($data['tryout']['project_id']);

    // Ambil data konfirmasi (Produksi, QC, Tooling, R&D)
    $data['konfirmasi_produksi'] = is_numeric($data['tryout']['konfirmasi_produksi']) 
        ? $userModel->find($data['tryout']['konfirmasi_produksi']) 
        : ['nama' => $data['tryout']['konfirmasi_produksi'], 'department' => ''];
    $data['konfirmasi_qc'] = is_numeric($data['tryout']['konfirmasi_qc']) 
        ? $userModel->find($data['tryout']['konfirmasi_qc']) 
        : ['nama' => $data['tryout']['konfirmasi_qc'], 'department' => ''];
    $data['konfirmasi_tooling'] = is_numeric($data['tryout']['konfirmasi_tooling']) 
        ? $userModel->find($data['tryout']['konfirmasi_tooling']) 
        : ['nama' => $data['tryout']['konfirmasi_tooling'], 'department' => ''];
    $data['konfirmasi_rd'] = is_numeric($data['tryout']['konfirmasi_rd']) 
        ? $userModel->find($data['tryout']['konfirmasi_rd']) 
        : ['nama' => $data['tryout']['konfirmasi_rd'], 'department' => ''];

    // Ambil data detail_tryouts berdasarkan tryout_id
    $detailTryouts = $this->detailTryoutModel->where('tryout_id', $id)->findAll();

    // Loop untuk mengganti ID PIC dengan nama dan departemen
    foreach ($detailTryouts as &$detail) {
        if (is_numeric($detail['pic'])) {
            $user = $userModel->find($detail['pic']);
            $detail['pic'] = $user ? $user['nama'] . ' - ' . $user['department'] : 'Data tidak ditemukan';
        }
    }

    // Simpan ke data yang dikirim ke view
    $data['detail_tryouts'] = $detailTryouts;

    // Load view
    return view('tryout/show', $data);
}

public function exportPdf($id)
{
    // Ambil data tryout berdasarkan ID
    $tryout = $this->tryoutModel->find($id);
    if (!$tryout) {
        return redirect()->to('/tryout')->with('error', 'Data Tryout tidak ditemukan!');
    }

    // Ambil data project berdasarkan project_id
    $project = $this->projectModel->find($tryout['project_id']);
    if (!$project) {
        return redirect()->to('/tryout')->with('error', 'Data Project tidak ditemukan!');
    }

    // Ambil data konfirmasi (Produksi, QC, Tooling, R&D)
    $konfirmasi_produksi = $this->getUserData($tryout['konfirmasi_produksi']);
    $konfirmasi_qc = $this->getUserData($tryout['konfirmasi_qc']);
    $konfirmasi_tooling = $this->getUserData($tryout['konfirmasi_tooling']);
    $konfirmasi_rd = $this->getUserData($tryout['konfirmasi_rd']);

    // Ambil data detail_tryouts dengan ordering yang jelas
    $detail_tryouts = $this->detailTryoutModel
        ->where('tryout_id', $id)
        ->orderBy('id', 'ASC')
        ->findAll();

    // Proses detail tryouts
    $processedDetails = [];
    foreach ($detail_tryouts as $detail) {
        if (is_numeric($detail['pic'])) {
            $user = $this->userModel->find($detail['pic']);
            $detail['pic'] = $user ? ($user['nama'] . ' - ' . $user['department']) : 'Unknown';
        }
        $processedDetails[] = $detail;
    }

    // Lokasi template PDF
    $templatePath = FCPATH . 'templates/template.pdf';

    // Periksa apakah template PDF ada
    if (!file_exists($templatePath)) {
        return redirect()->to('/tryout')->with('error', 'Template PDF tidak ditemukan!');
    }

    // Buat objek PDF dengan FPDI
    $pdf = new Fpdi();
    $pdf->SetAutoPageBreak(false, 0);

    // Impor template PDF
    $pdf->setSourceFile($templatePath);
    $pdf->AddPage();
    $tplIdx = $pdf->importPage(1);
    $pdf->useTemplate($tplIdx, 0, 0, 210);

    // Set font untuk menambahkan teks ke template
    $pdf->SetFont('helvetica', '', 9);

    // Menambahkan data ke template PDF
    $pdf->SetXY(166, 35);
    $pdf->Cell(130, 5, ' ' . $project['part_no'], 0, 1);

    $pdf->SetXY(166, 42);
    $pdf->Cell(60, 5, ' ' . $project['process'], 0, 1);

    $pdf->SetXY(166, 51);
    $pdf->Cell(60, 5, ' ' . $project['proses'], 0, 1);

    $pdf->SetXY(166, 56);
    $pdf->Cell(60, 5, ' ' . $tryout['material'], 0, 1);

    $pdf->SetXY(76, 42);
    $pdf->Cell(60, 5, '' . $tryout['adaptor'], 0, 1);

    $pdf->SetXY(76, 30);
    $pdf->Cell(60, 5, '' . $tryout['mc_line'], 0, 1);

    $pdf->SetXY(76, 36);
    $pdf->Cell(60, 5, '' . $tryout['slide_dh'], 0, 1);

    $pdf->SetXY(166, 42);
    $pdf->Cell(60, 5, ' ' . $project['process'], 0, 1);

    $pdf->SetXY(76, 49);
    $pdf->Cell(60, 5, '' . $tryout['cush_press'], 0, 1);

    $pdf->SetXY(76, 56);
    $pdf->Cell(60, 5, '' . $tryout['cush_h'], 0, 1);

    $pdf->SetXY(76, 62);
    $pdf->Cell(60, 5, '' . $tryout['main_press'], 0, 1);

    $pdf->SetXY(76, 69);
    $pdf->Cell(60, 5, '' . $tryout['spm'], 0, 1);

    $pdf->SetXY(76, 75);
    $pdf->Cell(60, 5, '' . $tryout['gsph'], 0, 1);

    $pdf->SetXY(60, 87);
    $pdf->Cell(60, 5, '' . $tryout['part_up'], 0, 1);

    $pdf->SetXY(77, 87);
    $pdf->Cell(60, 5, '' . $tryout['part_std'], 0, 1);

    $pdf->SetXY(94, 87);
    $pdf->Cell(60, 5, '' . $tryout['part_down'], 0, 1);

    $pdf->SetXY(26, 87);
    $pdf->Cell(60, 5, '' . $tryout['boolster'], 0, 1);

    $pdf->SetXY(9, 106);
    $pdf->Cell(60, 5, '' . $tryout['dates'], 0, 1);

    $pdf->SetXY(30, 106);
    $pdf->Cell(60, 5, '' . $tryout['trial_time'], 0, 1);

    $pdf->SetXY(53, 106);
    $pdf->Cell(60, 5, '' . $tryout['trial_maker'], 0, 1);

    $pdf->SetXY(83, 106);
    $pdf->Cell(60, 5, '' . $tryout['material_pakai'], 0, 1);

    $pdf->SetXY(109, 106);
    $pdf->Cell(60, 5, '' . $tryout['material_sisa'], 0, 1);

    $pdf->SetXY(128, 106);
    $pdf->Cell(60, 5, '' . $tryout['panel_ok'], 0, 1);

    $pdf->SetXY(142, 106);
    $pdf->Cell(60, 5, '' . $tryout['part_target'], 0, 1);

    $pdf->SetXY(158, 106);
    $pdf->Cell(60, 5, '' . $tryout['part_act'], 0, 1);

    $pdf->SetXY(173, 106);
    $pdf->Cell(60, 5, '' . $tryout['part_judge'], 0, 1);

    $pdf->SetXY(190, 100);
    $pdf->MultiCell(60, 5, trim($tryout['projek']) . "\n" . trim($tryout['cust']), 0, 'L');

    $pdf->SetXY(23, 93);
    $pdf->Cell(60, 5, '' . $tryout['step'], 0, 1);

    $pdf->SetXY(53, 93);
    $pdf->Cell(60, 5, '' . $tryout['event'], 0, 1);

    function addImageWithBorder($pdf, $filePath, $x, $y, $maxWidth, $maxHeight, $placeholderText) {
        if (!empty($filePath) && file_exists($filePath)) {
            // Ambil ukuran asli gambar
            list($originalWidth, $originalHeight) = getimagesize($filePath);
    
            // Hitung rasio gambar
            $ratio = $originalWidth / $originalHeight;
    
            // Tentukan ukuran gambar yang sesuai dengan batas maksimal
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                if ($originalWidth / $maxWidth > $originalHeight / $maxHeight) {
                    $imageWidth = $maxWidth;
                    $imageHeight = $maxWidth / $ratio;
                } else {
                    $imageHeight = $maxHeight;
                    $imageWidth = $maxHeight * $ratio;
                }
            } else {
                $imageWidth = $originalWidth;
                $imageHeight = $originalHeight;
            }
    
            // Hitung posisi agar gambar berada di tengah area batas
            $imageX = $x + ($maxWidth - $imageWidth) / 2;
            $imageY = $y + ($maxHeight - $imageHeight) / 2;
    
            // Tambahkan gambar
            $pdf->Image($filePath, $imageX, $imageY, $imageWidth, $imageHeight);
        } else {
            // Jika tidak ada gambar, tampilkan placeholder dengan border
            $pdf->SetXY($x, $y);
            $pdf->Cell($maxWidth, $maxHeight, $placeholderText, 1, 0, 'C');
        }
    
    }
    
    // **Tampilkan Part Trial Image**
    $partTrialPath = !empty($tryout['part_trial_image']) ? FCPATH . 'uploads/part_trial/' . $tryout['part_trial_image'] : '';
    addImageWithBorder($pdf, $partTrialPath, 8, 20, 43, 47, 'No Part Trial Image');
    
    // **Tampilkan Material Image**
$materialPath = !empty($tryout['material_image']) ? FCPATH . 'uploads/material/' . $tryout['material_image'] : '';

if (!empty($tryout['material_image']) && file_exists($materialPath)) {
    // Jika ada gambar, tampilkan dengan border
    addImageWithBorder($pdf, $materialPath, 106, 30, 30, 27, 'No Material Image'); 
} else {
    // Jika tidak ada gambar, tampilkan teks tanpa border
    $pdf->SetXY(106, 30);
    $pdf->Cell(30, 27, 'No Material Image', 0, 0, 'C'); // Border = 0 (tidak ada border)
}
    
$originalFontSize = 8;
// Set font kecil khusus untuk kolom Target dan Progress (misal ukuran 6)
$pdf->SetFont('helvetica', '', 7);

// Menambahkan konfirmasi data pada PDF dengan border
$pdf->SetXY(104, 86);
$pdf->MultiCell(24, 5, $konfirmasi_produksi, 1, 'C'); // Border 1

$pdf->SetXY(128, 86);
$pdf->MultiCell(27, 5, $konfirmasi_qc, 1, 'C'); // Border 1

$pdf->SetXY(155, 86);
$pdf->MultiCell(27, 5, $konfirmasi_tooling, 1, 'C'); // Border 1

$pdf->SetXY(182, 86);
$pdf->MultiCell(25, 5, $konfirmasi_rd, 1, 'C'); // Border 1



$pdf->SetFont('helvetica', '', $originalFontSize);
    // Menambahkan detail tryouts ke PDF
    // --- Menampilkan detail tryouts ---
    $yPosition = 125;
    $rowHeight = 35;
    $no = 1; // Inisialisasi nomor urut
    $itemsPerPage = 4;
    $itemCount = 0;

    foreach ($processedDetails as $detail) {
        // Cek apakah sudah mencapai batas per halaman
        if ($itemCount >= $itemsPerPage) {
            // Tambahkan halaman baru untuk detail ke-5 dan seterusnya
            $pdf->AddPage();
            $tplIdx2 = $pdf->importPage(2); // Gunakan halaman kedua dari template
            $pdf->useTemplate($tplIdx2, 0, 0, 210);
            
            // Reset yPosition untuk halaman baru
            $yPosition = 18;
            $itemCount = 0;
        }

        // --- Menampilkan isi tabel ---
        $problemText    = !empty($detail['problem_text']) ? trim($detail['problem_text']) : 'No problem description.';
        $counterMeasure = !empty($detail['counter_measure']) ? trim($detail['counter_measure']) : '-';
        $pic            = !empty($detail['pic']) ? trim($detail['pic']) : 'No PIC assigned';
        $target         = !empty($detail['target']) ? trim($detail['target']) : '-';
        $progressValue  = !empty($detail['progress']) ? (int)$detail['progress'] : 0;

        // Kolom Nomor
        $pdf->SetXY(5, $yPosition);
        $pdf->Cell(10, $rowHeight, $no, 0, 0, 'C');

        // Kolom Problem (Gambar + teks)
        $xPos = 18;
        $maxWidth = 45;
        $maxHeight = 22;

        $pdf->SetXY($xPos, $yPosition);
        if (!empty($detail['problem_image']) && file_exists(FCPATH . 'uploads/problems/' . $detail['problem_image'])) {
            list($originalWidth, $originalHeight) = getimagesize(FCPATH . 'uploads/problems/' . $detail['problem_image']);
            $ratio = $originalWidth / $originalHeight;

            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                if ($originalWidth / $maxWidth > $originalHeight / $maxHeight) {
                    $imageWidth = $maxWidth;
                    $imageHeight = $maxWidth / $ratio;
                } else {
                    $imageHeight = $maxHeight;
                    $imageWidth = $maxHeight * $ratio;
                }
            } else {
                $imageWidth = $originalWidth;
                $imageHeight = $originalHeight;
            }

            $imageX = $xPos + 2 + ($maxWidth - $imageWidth) / 2;
            $imageY = $yPosition + 2 + ($maxHeight - $imageHeight) / 2;

            $pdf->Image(FCPATH . 'uploads/problems/' . $detail['problem_image'], $imageX, $imageY, $imageWidth, $imageHeight);
            $pdf->SetXY($xPos, $yPosition + $maxHeight + 3);
            $pdf->MultiCell($maxWidth, 5, $problemText, 0, 'L');
        } else {
            // $pdf->Rect($xPos + 2, $yPosition + 2, $maxWidth, $maxHeight);
            // $pdf->MultiCell($maxWidth, 5, $problemText, 0, 'L');
        }

        // Kolom Counter Measure
        $pdf->SetXY(68, $yPosition);
        $pdf->MultiCell(40, 5, $counterMeasure, 0, 'L');

        // Kolom PIC
        $pdf->SetXY(113, $yPosition);
        $pdf->MultiCell(30, 5, $pic, 0, 'L');

        // Kolom Target
        $pdf->SetXY(147, $yPosition);
        $pdf->MultiCell(29, $rowHeight, $target, 0, 0, 'C');

        // Kolom Progress (Lingkaran Progress)
        $progressImage = $this->generateProgressCircle($progressValue);
        $progressX = 182;
        $progressY = $yPosition + ($rowHeight / 2) - 10;
        $pdf->Image($progressImage, $progressX, $progressY, 20, 20);

        // Pindah ke baris berikutnya
        $yPosition += $rowHeight;
        $no++;
        $itemCount++;
    }



    $partNo = str_replace('/', '-', $project['part_no']);  // mengganti slash agar valid untuk nama file
    $process = $project['process'];
    $dateStr = date('d-m-Y', strtotime($tryout['dates']));
    $filename = 'TRIAL-REPORT_' . $partNo . '_' . $process . '_' . $dateStr . '.pdf';

    $pdf->Output($filename, 'I');
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



// Helper function untuk mendapatkan data user
private function getUserData($userId) {
    if (is_numeric($userId)) {
        $user = $this->userModel->find($userId);
        return $user ? ($user['nama'] ) : 'Unknown';
    }
    return $userId;
}
/**as
 * Fungsi untuk menambahkan satuan ke nilai jika ada.
 */

public function edit($id)
{
    $userModel = model('UserModel');
    $projectModel = model('ProjectModel');

    // Ambil data tryout berdasarkan ID
    $data['tryout'] = $this->tryoutModel->find($id);

    if (!$data['tryout']) {
        return redirect()->to('/tryout')->with('error', 'Data Tryout tidak ditemukan!');
    }

    // Ambil data project berdasarkan project_id dari tryout
    $data['project'] = $projectModel->find($data['tryout']['project_id']);
    
    // Ambil semua project untuk dropdown
    $data['projects'] = $projectModel->findAll();

    // Ambil data konfirmasi (Produksi, QC, Tooling, R&D)
    $data['konfirmasi_produksi'] = is_numeric($data['tryout']['konfirmasi_produksi']) 
        ? $userModel->find($data['tryout']['konfirmasi_produksi']) 
        : ['nama' => $data['tryout']['konfirmasi_produksi'], 'department' => ''];
    $data['konfirmasi_qc'] = is_numeric($data['tryout']['konfirmasi_qc']) 
        ? $userModel->find($data['tryout']['konfirmasi_qc']) 
        : ['nama' => $data['tryout']['konfirmasi_qc'], 'department' => ''];
    $data['konfirmasi_tooling'] = is_numeric($data['tryout']['konfirmasi_tooling']) 
        ? $userModel->find($data['tryout']['konfirmasi_tooling']) 
        : ['nama' => $data['tryout']['konfirmasi_tooling'], 'department' => ''];
    $data['konfirmasi_rd'] = is_numeric($data['tryout']['konfirmasi_rd']) 
        ? $userModel->find($data['tryout']['konfirmasi_rd']) 
        : ['nama' => $data['tryout']['konfirmasi_rd'], 'department' => ''];

    // Ambil data detail_tryouts berdasarkan tryout_id
    $detailTryouts = $this->detailTryoutModel->where('tryout_id', $id)->findAll();

    // Loop untuk mengganti ID PIC dengan nama dan departemen
    foreach ($detailTryouts as &$detail) {
        if (is_numeric($detail['pic'])) {
            $user = $userModel->find($detail['pic']);
            $detail['pic'] = $user ? $user['nama'] . ' - ' . $user['department'] : 'Data tidak ditemukan';
        }
    }

    $data['detail_tryouts'] = $detailTryouts;
    // Tambahkan data users untuk dropdown konfirmasi di view edit
    $data['users'] = $this->db->table('users')
        ->select('id, nama, department')
        ->get()
        ->getResult();

    return view('tryout/edit', $data);
}


public function update($id)
{
    // Handle Upload Image Part Trial
    $tryout = $this->tryoutModel->find($id);

    // Handle Upload Image Part Trial
    $partTrialImage = $this->request->getFile('part_trial_image');
    $partTrialImageName = $this->request->getPost('existing_part_trial_image'); // Gunakan gambar lama

    if ($partTrialImage && $partTrialImage->isValid() && !$partTrialImage->hasMoved()) {
        $partTrialImageName = $partTrialImage->getRandomName();
        $partTrialImage->move('uploads/part_trial/', $partTrialImageName);

        // Hapus gambar lama jika ada yang baru diunggah
        if (!empty($this->request->getPost('existing_part_trial_image'))) {
            unlink('uploads/part_trial/' . $this->request->getPost('existing_part_trial_image'));
        }
    }

    // Handle Upload Image Material
    $materialImage = $this->request->getFile('material_image');
    $materialImageName = $this->request->getPost('existing_material_image'); // Gunakan gambar lama

    if ($materialImage && $materialImage->isValid() && !$materialImage->hasMoved()) {
        $materialImageName = $materialImage->getRandomName();
        $materialImage->move('uploads/material/', $materialImageName);

        // Hapus gambar lama jika ada yang baru diunggah
        if (!empty($this->request->getPost('existing_material_image'))) {
            unlink('uploads/material/' . $this->request->getPost('existing_material_image'));
        }
    }

    // Untuk field trial_maker, jika nilainya "OTHERS" gunakan nilai dari trial_maker_manual
    $trialMaker = $this->request->getPost('trial_maker');
    if ($trialMaker === 'OTHERS') {
        $trialMaker = $this->request->getPost('trial_maker_manual') ?? '';
    }

    // Update data utama ke database tryouts.
    // Catatan: Pastikan fungsi formatValueWithUnit tidak menambahkan satuan jika sudah ada.
    $this->tryoutModel->update($id, [
        'project_id'            => trim($this->request->getPost('project_id')),
        'mc_line'               => trim($this->request->getPost('mc_line')),
        'slide_dh'              => $this->formatValueWithUnit($this->request->getPost('slide_dh'), 'mm'),
        'adaptor'               => $this->formatValueWithUnit($this->request->getPost('adaptor'), 'mm'),
        'cush_press'            => $this->formatValueWithUnit($this->request->getPost('cush_press'), $this->request->getPost('cush_press_unit')),
        'cush_h'                => $this->formatValueWithUnit($this->request->getPost('cush_h'), 'mm'),
        'main_press'            => $this->formatValueWithUnit($this->request->getPost('main_press'), 'N'),
        'spm'                   => $this->formatValueWithUnit($this->request->getPost('spm'), 'stroke'),
        'gsph'                  => $this->formatValueWithUnit($this->request->getPost('gsph'), 'stroke/jam'),
        'boolster'              => trim($this->request->getPost('boolster')),
        'dates'                 => trim($this->request->getPost('dates')),
        'part_trial_image'      => $partTrialImageName,
        'material_image'        => $materialImageName,
        'material_pakai'        => trim($this->request->getPost('material_pakai')),
        'material_sisa'         => trim($this->request->getPost('material_sisa')),
        'part_target'           => trim($this->request->getPost('part_target')),
        'part_act'              => trim($this->request->getPost('part_act')),
        'part_judge'            => trim($this->request->getPost('part_judge')),
        'trial_time'            => trim($this->request->getPost('trial_time')),
        'trial_maker'           => $trialMaker,
        'projek'                => trim($this->request->getPost('projek')),
        'step'                  => trim($this->request->getPost('step')),
        'event'                 => trim($this->request->getPost('event')),
        'part_up'               => trim($this->request->getPost('part_up')),
        'part_std'              => trim($this->request->getPost('part_std')),
        'part_down'             => trim($this->request->getPost('part_down')),
        'panel_ok'              => trim($this->request->getPost('panel_ok')),
        'material'              => trim($this->request->getPost('material')),
        'activity'              => trim($this->request->getPost('activity')),
        'cust'                  => trim($this->request->getPost('cust')),
        // Konfirmasi (gunakan nilai manual jika ada)
        'konfirmasi_produksi'   => trim($this->request->getPost('konfirmasi_produksi')) === 'manual' 
            ? trim($this->request->getPost('konfirmasi_produksi_manual')) 
            : trim($this->request->getPost('konfirmasi_produksi')),

        'konfirmasi_qc'         => trim($this->request->getPost('konfirmasi_qc')) === 'manual' 
                ? trim($this->request->getPost('konfirmasi_qc_manual')) 
                : trim($this->request->getPost('konfirmasi_qc')),

        'konfirmasi_tooling'    => trim($this->request->getPost('konfirmasi_tooling')) === 'manual' 
                ? trim($this->request->getPost('konfirmasi_tooling_manual')) 
                : trim($this->request->getPost('konfirmasi_tooling')),

        'konfirmasi_rd'         => trim($this->request->getPost('konfirmasi_rd')) === 'manual' 
                ? trim($this->request->getPost('konfirmasi_rd_manual')) 
                : trim($this->request->getPost('konfirmasi_rd')),
     ]);

    // Hapus detail tryout yang lama
    $this->detailTryoutModel->where('tryout_id', $id)->delete();

    // Handle Problem Data (update detail_tryouts)
    $problemData = [];
    $index = 0;
    while ($this->request->getFile("problem_image_$index")) {
        $problemImage = $this->request->getFile("problem_image_$index");
        $problemImageName = $this->request->getPost("existing_problem_image_$index"); // nilai lama

        if ($problemImage && $problemImage->isValid() && !$problemImage->hasMoved()) {
            $problemImageName = $problemImage->getRandomName();
            $problemImage->move('uploads/problems/', $problemImageName);
        }
        $selectedPIC = $this->request->getPost("pic_$index");
        $manualPIC = $this->request->getPost("pic_manual_$index");
        $finalPIC = ($selectedPIC === "manual" && !empty($manualPIC)) ? $manualPIC : $selectedPIC;

        $problemData[] = [
            'tryout_id'      => $id,
            'problem_image'  => $problemImageName,
            'problem_text'   => $this->request->getPost("problem_text_$index"),
            'counter_measure'=> $this->request->getPost("counter_measure_$index"),
            'pic'            => $finalPIC,
            'target'         => $this->request->getPost("target_$index"),
            'progress'       => $this->request->getPost("progress_$index"),
        ];

        $index++;
    }

    if (!empty($problemData)) {
        $this->detailTryoutModel->insertBatch($problemData);
    }

    return redirect()->to('/tryout')->with('success', 'Data Tryout berhasil diperbarui!');
}

/**
 * Fungsi untuk menambahkan satuan ke nilai jika belum ada.
 */
private function formatValueWithUnit($value, $unit)
{
    $value = trim($value);
    // Hapus satuan yang sudah ada
    $value = str_replace($unit, '', $value);
    return $value ? $value . ' ' . $unit : null;
}

/**
 * Fungsi helper untuk mendapatkan data user berdasarkan ID atau teks.
 */


    
public function delete($id)
{
    // Cek apakah data tryout ada
    $tryout = $this->tryoutModel->find($id);
    if (!$tryout) {
        return redirect()->to('/tryout')->with('error', 'Data Tryout tidak ditemukan!');
    }

    // Hapus data detail tryout yang terkait (jika ada)
    $this->detailTryoutModel->where('tryout_id', $id)->delete();

    // Hapus data tryout utama
    $this->tryoutModel->delete($id);

    return redirect()->to('/tryout')->with('success', 'Data Tryout berhasil dihapus!');
}



}
