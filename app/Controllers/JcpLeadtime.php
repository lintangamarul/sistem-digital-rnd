<?php

namespace App\Controllers;
use App\Models\ccf\JcpLeadtimeModel;
use CodeIgniter\Controller;

class JcpLeadtime extends Controller
{
    public function index()
    {
        $model = new JcpLeadtimeModel();
        $data['leadtimes'] = $model->findAll();
        return view('jcp_leadtime/index', $data);
    }

    public function create()
    {
        return view('jcp_leadtime/create');
    }

    public function store()
    {
        $model = new JcpLeadtimeModel();
        $model->insert($this->request->getPost());
        return redirect()->to('/jcp-leadtime');
    }

    public function edit($id)
    {
        $model = new JcpLeadtimeModel();
        $data['leadtime'] = $model->find($id);
        return view('jcp_leadtime/edit', $data);
    }

    public function update($id)
    {
        $model = new JcpLeadtimeModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/jcp-leadtime');
    }

    public function delete($id)
    {
        $model = new JcpLeadtimeModel();
        $model->delete($id);
        return redirect()->to('/jcp-leadtime');
    }
}
