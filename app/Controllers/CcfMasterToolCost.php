<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ccf\CcfMasterToolCostModel;

class CcfMasterToolCost extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CcfMasterToolCostModel();
    }

    public function index()
    {
        $data['items'] = $this->model->findAll();
        return view('masterCcf/master_toolcost/index', $data); // pastikan folder dan view sesuai
    }

    public function create()
    {
        return view('masterCcf/master_toolcost/create'); // pastikan view ini ada
    }

    public function store()
    {
        $data = [
            'tool_cost_process' => $this->request->getPost('tool_cost_process'),
            'tool_cost_tool'    => $this->request->getPost('tool_cost_tool'),
            'tool_cost_spec'    => $this->request->getPost('tool_cost_spec'),
            'tool_cost_qty'     => $this->request->getPost('tool_cost_qty'),
            'jenis'             => $this->request->getPost('jenis'),
            'class'             => $this->request->getPost('class'),
        ];

        if ($this->model->insert($data)) {
            return redirect()->to('/ccf-master-tool-cost')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data. ' . json_encode($this->model->errors()));
        }
    }

    public function edit($id)
    {
        $data['item'] = $this->model->find($id);
        if (!$data['item']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }

        return view('masterCcf/master_toolcost/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'tool_cost_process' => $this->request->getPost('tool_cost_process'),
            'tool_cost_tool'    => $this->request->getPost('tool_cost_tool'),
            'tool_cost_spec'    => $this->request->getPost('tool_cost_spec'),
            'tool_cost_qty'     => $this->request->getPost('tool_cost_qty'),
            'jenis'             => $this->request->getPost('jenis'),
            'class'             => $this->request->getPost('class'),
        ];

        if ($this->model->update($id, $data)) {
            return redirect()->to('/ccf-master-tool-cost')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data. ' . json_encode($this->model->errors()));
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/ccf-master-tool-cost')->with('success', 'Data berhasil dihapus');
    }
}