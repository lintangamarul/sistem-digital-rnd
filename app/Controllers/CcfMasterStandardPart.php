<?php

namespace App\Controllers;

use App\Models\ccf\CcfMasterStandardPartModel;

class CcfMasterStandardPart extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CcfMasterStandardPartModel();
    }

    public function index()
    {
        
        $data['parts'] = $this->model->findAll();

        return view('masterCcf/master_standard_part/index', $data);
    }

    public function create()
    {
        return view('masterCcf/master_standard_part/create');
    }

    public function store()
    {
        $this->model->save($this->request->getPost());
        return redirect()->to('/ccf-master-standard-part')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['part'] = $this->model->find($id);
        return view('masterCcf/master_standard_part/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;
        $this->model->save($data);
        return redirect()->to('/ccf-master-standard-part')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/ccf-master-standard-part')->with('success', 'Data berhasil dihapus');
    }
}
