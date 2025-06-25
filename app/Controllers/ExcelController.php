<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\CuttingToolModel;

class ExcelController extends BaseController
{
    public function index()
    {   return view('user/excel_upload');
    }
    // public function upload()
    // {
    //     $file = $this->request->getFile('excel_file');
    //     if (!$file->isValid()) {
    //         session()->setFlashdata('error', $file->getErrorString());
    //         return redirect()->back();
    //     }
        
    //     // Dapatkan nama file asli
    //     $originalName = $file->getClientName();
        
    //     $file->move(FCPATH . 'uploads/template', $originalName, false);
        
    //     session()->setFlashdata('success', 'File berhasil diupload.');
    //     return redirect()->back();
    // }
    
    public function upload()
    {
        try {
            $file = $this->request->getFile('excel_file');
            if (!$file->isValid()) {
                session()->setFlashdata('error', $file->getErrorString());
                return redirect()->back();
            }

            $filepath = $file->getTempName();

            $spreadsheet = IOFactory::load($filepath);

            $db = \Config\Database::connect();

            $allSheets = $spreadsheet->getAllSheets();

            foreach ($allSheets as $sheet) {
       
                if (stripos($sheet->getTitle(), 'OP') === false) {
                    continue; // Lewati worksheet yang tidak mengandung "OP"
                }

                // ====== UPDATE UNTUK WORKSHEET INI DIMULAI DARI SINI ======

                $part_no   = $sheet->getCell('I3')->getValue();
                $part_name = $sheet->getCell('I4')->getValue();
                $process = $sheet->getCell('I5')->getValue();

                $keywords = ['DR', 'BE', 'FO', 'FL', 'BL', 'TR', 'CUT', 'PI', 'SEP'];
                $found = [];

                foreach ($keywords as $keyword) {
                    if (stripos($process, $keyword) !== false) {
                        $found[] = $keyword;
                    }
                }
                if (!empty($found)) {
                    // Untuk tabel finishing
                    $maxCountFinishing = 0;
                    $process_finishing = $process; // fallback default
                    foreach ($found as $kw) {
                        $builderFinishing = $db->table('finishing');
                        $builderFinishing->like('process', $kw);
                        $count = $builderFinishing->countAllResults();
                        if ($count > $maxCountFinishing) {
                            $maxCountFinishing = $count;
                            $process_finishing = $kw;
                        }
                    }

                    // Untuk tabel cutting_tools
                    $maxCountCutting = 0;
                    $process_cutting = $process; // fallback default
                    foreach ($found as $kw) {
                        $builderCutting = $db->table('cutting_tools');
                        $builderCutting->like('process', $kw);
                        $count = $builderCutting->countAllResults();
                        if ($count > $maxCountCutting) {
                            $maxCountCutting = $count;
                            $process_cutting = $kw;
                        }
                    }
                } else {
                    // Jika tidak ditemukan keyword, gunakan nilai asli
                    $process_finishing = $process;
                    $process_cutting   = $process;
                }

                $class = null; // Array untuk menyimpan nilai dari cell yang warnanya berbeda
                for ($row = 3; $row <= 8; $row++) {
                    $cell = $sheet->getCell("O{$row}");
                    // Dapatkan nilai warna isian (RGB) dari cell
                    $fillColor = $cell->getStyle()->getFill()->getStartColor()->getRGB();
                    
                    // Misalnya, warna default adalah putih (FFFFFF)
                    if ($fillColor !== 'FFFFFF') {
                        $class = $cell->getValue();
                    }
                }
                print_r($class);
                exit();
                $process_leadtime = $sheet->getCell('I5')->getValue();

                if (
                    stripos($process_leadtime, 'C.') !== false ||
                    stripos($process_leadtime, 'C/') !== false ||
                    stripos($process_leadtime, 'C-') !== false
                ) {
                    $process_leadtime = 'CAM';
                } else {
                    $process_leadtime = $process_finishing;
                }

                // ----------------------------------
                // 1. Update data dari tabel cutting_tools
                // ----------------------------------
                $builder = $db->table('cutting_tools');
                $builder->like('process', $process_cutting);
                $builder->where('class', $class);
                $query = $builder->get();
                $results = $query->getResultArray();

                if ($results) {
                    $startRow = 62;
                    foreach ($results as $data) {
                        $sheet->setCellValue('N' . $startRow, $data['spec_cutter']);
                        $sheet->setCellValue('O' . $startRow, $data['diameter']);
                        $sheet->setCellValue('P' . $startRow, $data['jenis_chip']);
                        $sheet->setCellValue('Q' . $startRow, $data['kebutuhan_chip']);
                        $startRow++;
                    }
                } else {
                    $sheet->setCellValue('O62', 'Data tidak ditemukan');
                }

                // ----------------------------------
                // 2. Update data dari tabel lead_time
                // ----------------------------------
                 // (a) Category 'DESIGN' -> cell F13
                $builderLead = $db->table('lead_time');
                $builder->like('process', $process_leadtime);
                $builderLead->where('class', $class);
                $builderLead->where('category', 'DESIGN');
                $queryDesign = $builderLead->get();
                $designRow = $queryDesign->getRowArray();
                if ($designRow) {
                    $sheet->setCellValue('F13', $designRow['hour']);
                } else {
                    $sheet->setCellValue('F13', 'Data tidak ditemukan');
                }

                // (b) Category 'CAD CAM' -> cell F14
                $builderLead = $db->table('lead_time'); // Reset builder
                $builder->like('process', $process_leadtime);
                $builderLead->where('class', $class);
                $builderLead->where('category', 'CAD CAM');
                $queryCadCam = $builderLead->get();
                $cadCamRow = $queryCadCam->getRowArray();
                if ($cadCamRow) {
                    $sheet->setCellValue('F14', $cadCamRow['hour']);
                } else {
                    $sheet->setCellValue('F14', 'Data tidak ditemukan');
                }

                // (c) Category 'POLY' -> cell F21
                $builderLead = $db->table('lead_time');
                $builderLead->where('process', $process_leadtime);
                $builderLead->where('class', $class);
                $builderLead->where('category', 'POLY');
                $queryPoly = $builderLead->get();
                $polyRow = $queryPoly->getRowArray();
                if ($polyRow) {
                    $sheet->setCellValue('F21', $polyRow['hour']);
                } else {
                    $sheet->setCellValue('F21', 'Data tidak ditemukan');
                }

                // (d) Category 'MACHINING'
                $builderLead = $db->table('lead_time');
                $builderLead->where('process', $process_leadtime);
                $builderLead->where('class', $class);
                $builderLead->where('category', 'FINISHING');
                $queryMachining = $builderLead->get();
                $machiningRow = $queryMachining->getRowArray();
                if ($machiningRow) {
                    $hoursMachining = floatval($machiningRow['hour']);
                    $remaining = $hoursMachining - 8;
                    $value40 = ($remaining * 40) / 100;
                    $value35 = ($remaining * 35) / 100;
                    $value25 = ($remaining * 25) / 100;
                    $sheet->setCellValue('P57', $value40);
                    $sheet->setCellValue('P56', $value35);
                    $sheet->setCellValue('P37', $value25);
                    $sheet->setCellValue('P58', 8);
                } else {
                    $sheet->setCellValue('P57', 'Data tidak ditemukan');
                    $sheet->setCellValue('P56', 'Data tidak ditemukan');
                    $sheet->setCellValue('P37', 'Data tidak ditemukan');
                    $sheet->setCellValue('P58', 'Data tidak ditemukan');
                }

                // E
                $builderLead = $db->table('lead_time');
                $builderLead->where('process', $process_leadtime);
                $builderLead->where('class', $class);
                $builderLead->where('category', 'MACHINING');
                $queryPoly = $builderLead->get();
                $polyRow = $queryPoly->getRowArray();
                if ($polyRow) {
                    $sheet->setCellValue('H118', $polyRow['hour']);
                } else {
                    $sheet->setCellValue('H118', 'Data tidak ditemukan');
                }
                // ----------------------------------
                // 3. Update data dari tabel finishing
                // ----------------------------------
                $builderFinishing = $db->table('finishing');
                $builderFinishing->like('process', $process_finishing);
                $builderFinishing->where('class', $class);
                $queryFinishing = $builderFinishing->get();
                $finishingResults = $queryFinishing->getResultArray();

                if ($finishingResults) {
                    $startRow = 13; // Mulai update dari baris 13
                    foreach ($finishingResults as $row) {
                        $sheet->setCellValue('N' . $startRow, $row['part_list']);
                        $sheet->setCellValue('O' . $startRow, $row['material']);
                        $sheet->setCellValue('P' . $startRow, $row['diameter']);
                        $sheet->setCellValue('R' . $startRow, $row['qty']);
                        $startRow++;
                    }
                } else {
                    $sheet->setCellValue('N13', 'Data tidak ditemukan');
                }
                // ====== UPDATE UNTUK WORKSHEET INI SELESAI ======
            } 

            $writer = new Xlsx($spreadsheet);
            $filename = 'DCP_' . $part_no . '_' . $part_name . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Throwable $e) {
            // Simpan pesan error ke flashdata agar bisa ditampilkan di view
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
