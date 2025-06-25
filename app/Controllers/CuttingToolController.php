<?php

namespace App\Controllers;

use App\Models\dcp\CuttingToolModel;

class CuttingToolController extends BaseController
{
    public function index()
    {
        $model = new CuttingToolModel();
        $data['cuttingtools'] = $model->findAll();
        return view('cuttingtools/index', $data);
    }

    public function create()
    {
        return view('cuttingtools/create');
    }

    public function store()
    {
        $model = new CuttingToolModel();    
        $data = [
            'spec_cutter'   => $this->request->getPost('spec_cutter'),
            'jenis_chip'    => $this->request->getPost('jenis_chip'),
            'class'         => $this->request->getPost('class'),
            'diameter'      => $this->request->getPost('diameter'),
            'kebutuhan_chip'=> $this->request->getPost('kebutuhan_chip'),
            'remarks'       => $this->request->getPost('remarks'),
            'process'       => $this->request->getPost('process'),
            'status'        => $this->request->getPost('status'),
        ];
        $model->save($data);
        return redirect()->to('/cuttingtools')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new CuttingToolModel();
        $data['cuttingtool'] = $model->find($id);
        if (!$data['cuttingtool']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }
        return view('cuttingtools/edit', $data);
    }

    public function update($id)
    {
        $model = new CuttingToolModel();
        $data = [
            'spec_cutter'   => $this->request->getPost('spec_cutter'),
            'jenis_chip'    => $this->request->getPost('jenis_chip'),
            'class'         => $this->request->getPost('class'),
            'diameter'      => $this->request->getPost('diameter'),
            'kebutuhan_chip'=> $this->request->getPost('kebutuhan_chip'),
            'remarks'       => $this->request->getPost('remarks'),
            'process'       => $this->request->getPost('process'),
            'status'        => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        return redirect()->to('/cuttingtools')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new CuttingToolModel();
        $model->delete($id);
        return redirect()->to('/cuttingtools')->with('success', 'Data berhasil dihapus');
    }
}
