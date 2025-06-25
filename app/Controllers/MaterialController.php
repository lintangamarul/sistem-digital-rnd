<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use CodeIgniter\Controller;

class MaterialController extends Controller
{
    protected $materialModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
    }

    public function index()
    {
        $materials = $this->materialModel->where('status', 1)->findAll();
        return view('material/index', ['materials' => $materials]);
    }

    public function create()
    {
        return view('material/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = session()->get('id'); 
        $data['status'] = 1;  
        
        if ($this->materialModel->insert($data)) {
            return redirect()->to('/material')->with('message', 'Material berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambah material');
        }
    }

    public function edit($id)
    {
        $material = $this->materialModel->find($id);
        if ($material) {
            return view('material/edit', ['material' => $material]);
        } else {
            return redirect()->to('/material')->with('error', 'Material tidak ditemukan');
        }
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = session()->get('id');

        if ($this->materialModel->update($id, $data)) {
            return redirect()->to('/material')->with('message', 'Material berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui material');
        }
    }

    public function delete($id)
    {
        $data = ['status' => 0, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => session()->get('id')];

        if ($this->materialModel->update($id, $data)) {
            return redirect()->to('/material')->with('message', 'Material berhasil dihapus');
        } else {
            return redirect()->to('/material')->with('error', 'Gagal menghapus material');
        }
    }

    
}
