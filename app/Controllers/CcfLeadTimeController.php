<?php

namespace App\Controllers;

use App\Models\ccf\CcfLeadTimeModel;
use CodeIgniter\Controller;

class CcfLeadTimeController extends Controller
{
    protected $model;
    protected $helpers = ['form', 'url', 'filesystem'];

    public function __construct()
    {
        $this->model = new CcfLeadTimeModel();
    }

    public function index()
    {
        $data['records'] = $this->model->orderBy('id', 'DESC')->findAll();
        return view('masterCcf/master_leadtime/index', $data);
    }

    public function create()
    {
        return view('masterCcf/master_leadtime/create');
    }

    /** Simpan record baru */
    public function store()
    {
        $post = $this->request->getPost();
    
        $data = [
            'category'    => $post['category'],
            'class'       => $post['class'],
            'hour'        => $post['hour'],
            'week'        => $post['week'],
            'status'      => 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => session()->get('user_id') ?? null,
        ];
    
        $this->model->insert($data);
    
        return redirect()->route('ccf-master-leadtime.index')
                         ->with('success', 'Data berhasil ditambah');
    }
    

    public function edit($id)
    {
        $record = $this->model->find($id);
      
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("ID $id tidak ditemukan");
        }
    
        return view('masterCcf/master_leadtime/edit', ['record' => $record]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();
        $this->model->update($id, [
            'category'    => $post['category'],
            'class'       => $post['class'],
            'hour'        => $post['hour'],
            'week'        => $post['week'],
            'status'      => 1,
            'modified_at' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('user_id') ?? null
        ]);
        return redirect()->route('ccf-master-leadtime.index')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->route('ccf-master-leadtime.index')->with('success', 'Data berhasil dihapus');
    }
}
