<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Controller;

class Project extends Controller
{
    protected $projectModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
    }

    public function index()
    {
      
        $data['projects'] = $this->projectModel
        ->whereIn('status', [1, 2])
          ->whereIn('status', [1, 2])
        ->orderBy('jenis', 'ASC')
        ->orderBy('another_project', 'ASC')
        ->findAll();
    
        return view('project/index', $data);
    }
    

    public function create()
    {
        return view('project/create');
    }

    public function store()
    {
        $jenis = $this->request->getPost('jenis');
        $tingkatan = $this->request->getPost('tingkatan'); // Ambil input tingkatan
    
        $data = [
            'jenis'      => $jenis,
            'created_by' => 1, // Ini nanti akan di-overwrite lagi di bawah
        ];
    
        if ($tingkatan == 'RFQ') {
            $data['status'] = 2;
        } else if ($tingkatan == 'Production') {
            $data['status'] = 1;
        }
    
        if ($jenis == 'Tooling Project') {
            $data['model']           = $this->request->getPost('model');
            $data['part_no']         = $this->request->getPost('part_no');
            $data['part_name']         = $this->request->getPost('part_name');
            $process1 = $this->request->getPost('process');
            $process2 = $this->request->getPost('process2');
            $process = !empty($process2) ? $process1 . ', ' . $process2 : $process1;
              $data['customer']         = $this->request->getPost('customer');
            $data['process']         = $process;
            $data['proses']          = $this->request->getPost('proses');
            $data['jenis_tooling']   = $this->request->getPost('jenis_tooling');
            $data['another_project'] = null;
        } else if ($jenis == 'Others') {
            $data['another_project'] = $this->request->getPost('another_project');
            $data['model']           = null;
            $data['part_no']         = null;
            $data['process']         = null;
        }
    
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = session()->get('user_id');
    
        $this->projectModel->save($data);
    
        return redirect()->to('/project');
    }
    
    

    public function update($id)
    {
        $jenis = $this->request->getPost('jenis');
        $data = [
            'jenis'       => $jenis,
          
        ];
        $tingkatan = $this->request->getPost('tingkatan'); // Ambil input tingkatan
    
          if ($tingkatan == 'RFQ') {
            $data['status'] = 2;
        } else if ($tingkatan == 'Production') {
            $data['status'] = 1;
        }
        if ($jenis == 'Tooling Project') {
            $data['model']           = $this->request->getPost('model');
            $data['part_no']         = $this->request->getPost('part_no');
            $data['part_name']         = $this->request->getPost('part_name');
            $process1 = $this->request->getPost('process');
            $process2 = $this->request->getPost('process2');
            // If process2 is not empty, concatenate with a comma separator; otherwise, just use process1.
            $process = !empty($process2) ? $process1 . ', ' . $process2 : $process1;
              $data['customer']         = $this->request->getPost('customer');
            $data['process']         = $process;
            $data['proses']          = $this->request->getPost('proses');
            $data['jenis_tooling']   = $this->request->getPost('jenis_tooling');
            $data['another_project'] = null;
        } else if ($jenis == 'Others') {
            $data['another_project'] = $this->request->getPost('another_project');
            $data['model']           = null;
            $data['part_no']         = null;
            $data['process']         = null;
        }
        $data['modified_at']         = date('Y-m-d H:i:s');
        $data['modified_by']         = session()->get('user_id');
        $this->projectModel->update($id, $data);
        return redirect()->to('/project');

    }


    public function edit($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $data['project'] = $this->projectModel->find($id);

        return view('project/edit', $data);
    }

 

    public function delete($id)
    {
        $modifiedBy = session()->get('user_id');
        
        $this->projectModel->update($id, [
            'status'      => 0,
            'modified_by' => $modifiedBy,
            'modified_at' => date('Y-m-d H:i:s')
        ]);
    
        return redirect()->to('/project')->with('success', 'Project berhasil diubah status menjadi tidak aktif.');
    }
    
}
