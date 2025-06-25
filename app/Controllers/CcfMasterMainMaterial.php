<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ccf\CcfMasterMainMaterialModel;

class CcfMasterMainMaterial extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CcfMasterMainMaterialModel();
    }

    public function index()
    {
        $data['items'] = $this->model->findAll();
        return view('masterCcf/master_main_material/index', $data);
    }

    public function create()
    {
        return view('masterCcf/master_main_material/create');
    }

    public function store()
    {
        $data = [
            'mm_part_list'     => $this->request->getPost('mm_part_list'),
            'mm_material_spec' => $this->request->getPost('mm_material_spec'),
            'mm_size_type_l'   => $this->request->getPost('mm_size_type_l'),
            'mm_size_type_w'   => $this->request->getPost('mm_size_type_w'),
            'mm_size_type_h'   => $this->request->getPost('mm_size_type_h'),
            'mm_qty'           => $this->request->getPost('mm_qty'),
            'mm_weight'        => $this->request->getPost('mm_weight'),
            'mm_category'      => $this->request->getPost('mm_category'),
            'mm_cost'          => $this->request->getPost('mm_cost'),
            'jenis'            => $this->request->getPost('jenis'),
            'class'            => $this->request->getPost('class'),
        ];

        $success = $this->model->insert($data);
        if ($success) {
            return redirect()->to('/ccf-master-main-material')->with('success', 'Data berhasil disimpan');
        } else {
            $error = $this->model->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data. ' . json_encode($error));
        }
    }

    public function edit($id)
    {
        $data['item'] = $this->model->find($id);
        if (!$data['item']) throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
   
        return view('masterCcf/master_main_material/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'mm_part_list'     => $this->request->getPost('mm_part_list'),
            'mm_material_spec' => $this->request->getPost('mm_material_spec'),
            'mm_size_type_l'   => $this->request->getPost('mm_size_type_l'),
            'mm_size_type_w'   => $this->request->getPost('mm_size_type_w'),
            'mm_size_type_h'   => $this->request->getPost('mm_size_type_h'),
            'mm_qty'           => $this->request->getPost('mm_qty'),
            'mm_weight'        => $this->request->getPost('mm_weight'),
            'mm_category'      => $this->request->getPost('mm_category'),
            'mm_cost'          => $this->request->getPost('mm_cost'),
            'jenis'            => $this->request->getPost('jenis'),
            'class'            => $this->request->getPost('class'),
        ];

        $success = $this->model->update($id, $data);
        if ($success) {
            return redirect()->to('/ccf-master-main-material')->with('success', 'Data berhasil diupdate');
        } else {
            $error = $this->model->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data. ' . json_encode($error));
        }
    }
    
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/ccf-master-main-material')->with('success','Data berhasil dihapus');
    }
}
