<?php

namespace App\Controllers;

use App\Models\dcp\LeadTimeModel;

class LeadTimeController extends BaseController
{
  
    public function index()
    {
        $model = new LeadTimeModel();
        $data['leadtimes'] = $model->findAll();
        return view('leadtime/index', $data);
    }

    public function create()
    {
        return view('leadtime/create');
    }
  
    public function store()
    {
        $model = new LeadTimeModel();
        $data = [
            'category' => $this->request->getPost('category'),
            'process'  => $this->request->getPost('process'),
            'class'    => $this->request->getPost('class'),
            'hour'     => $this->request->getPost('hour'),
            'week'     => $this->request->getPost('week'),
            'status'   => 1,
        ];
        $model->save($data);
        return redirect()->to('/leadtime')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new LeadTimeModel();
        $data['leadtime'] = $model->find($id);
        if (!$data['leadtime']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }
        return view('leadtime/edit', $data);
    }

    public function update($id)
    {
        $model = new LeadTimeModel();
        $data = [
            'category' => $this->request->getPost('category'),
            'process'  => $this->request->getPost('process'),
            'class'    => $this->request->getPost('class'),
            'hour'     => $this->request->getPost('hour'),
            'week'     => $this->request->getPost('week'),
            'status'   => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        return redirect()->to('/leadtime')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new LeadTimeModel();
        $model->delete($id);
        return redirect()->to('/leadtime')->with('success', 'Data berhasil dihapus');
    }
}
