<?php

namespace App\Controllers;

use App\Models\dcp\FinishingModel;

class FinishingController extends BaseController
{
    public function index()
    {
        $model = new FinishingModel();
        $data['finishing'] = $model->findAll();
        return view('finishing/index', $data);
    }

    public function create()
    {
        return view('finishing/create');
    }

    public function store()
    {
        $model = new FinishingModel();
        $data = [
            'part_list'  => $this->request->getPost('part_list'),
            'material'   => $this->request->getPost('material'),
            'diameter'   => $this->request->getPost('diameter'),
            'class'      => $this->request->getPost('class'),
            'qty'        => $this->request->getPost('qty'),
            'remarks'    => $this->request->getPost('remarks'),
            'status'     => $this->request->getPost('status'),
            'process'    => $this->request->getPost('process'),
        ];
        $model->save($data);
        return redirect()->to('/finishing')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new FinishingModel();
        $data['finishing'] = $model->find($id);
        if (!$data['finishing']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }
        return view('finishing/edit', $data);
    }

    public function update($id)
    {
        $model = new FinishingModel();
        $data = [
            'part_list'  => $this->request->getPost('part_list'),
            'material'   => $this->request->getPost('material'),
            'diameter'   => $this->request->getPost('diameter'),
            'class'      => $this->request->getPost('class'),
            'qty'        => $this->request->getPost('qty'),
            'remarks'    => $this->request->getPost('remarks'),
            'process'    => $this->request->getPost('process'),
        ];
        $model->update($id, $data);
        return redirect()->to('/finishing')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new FinishingModel();
        $model->delete($id);
        return redirect()->to('/finishing')->with('success', 'Data berhasil dihapus');
    }
}
