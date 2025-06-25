<?php 
namespace App\Controllers;

use App\Models\McSpecModel;
use CodeIgniter\Controller;
use App\Models\MasterTableModel;
class MasterPps extends BaseController
{
    protected $mcSpecModel;
    protected $masterTableModel;

    public function __construct()
    {
        $this->mcSpecModel = new McSpecModel();
        $this->masterTableModel = new MasterTableModel(); // Tambah ini
    }
    public function index()
    {
        $this->mcSpecModel->select('mc_spec.*, master_table.capacity as master_capacity, master_table.cushion as master_cushion, master_table.dh_dies as master_dh_dies');
        $this->mcSpecModel->join('master_table', 'master_table.machine = mc_spec.machine', 'left');
        $data['specs'] = $this->mcSpecModel->findAll();
    
        $db = \Config\Database::connect();
        $query = $db->query("SELECT die_length, die_width, die_height, category, jenis_proses, proses FROM standard_die_design");
        $data['design'] = $query->getResultArray();
    
        return view('master_pps/index', $data);
    }

    public function create()
    {
        return view('master_pps/form');
    }

    public function store()
    {
        $post = $this->request->getPost();
    
        $saveMcSpec = $this->mcSpecModel->save([
            'machine' => $post['machine'],
            'capacity' => $post['capacity'],
            'bolster_length' => $post['bolster_length'],
            'bolster_width' => $post['bolster_width'],
            'slide_area_length' => $post['slide_area_length'],
            'slide_area_width' => $post['slide_area_width'],
            'die_height' => $post['die_height'],
            'cushion_pad_length' => $post['cushion_pad_length'],
            'cushion_pad_width' => $post['cushion_pad_width'],
            'cushion_stroke' => $post['cushion_stroke'],
            'cushion' => $post['cushion']
        ]);
      
        $saveMasterTable = $this->masterTableModel->save([
            'machine' => $post['machine'],
            'capacity' => $post['capacity'],
            'cushion' => $post['cushion'],
         
            'dh_dies' => $post['die_height'] 
        ]);
      
        if ($saveMcSpec && $saveMasterTable) {
            return redirect()->to('/master-pps')->with('success', 'Data berhasil disimpan ke dua tabel.');
        } else {
            $errors = array_merge(
                $this->mcSpecModel->errors() ?? [],
                $this->masterTableModel->errors() ?? []
            );
    
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . implode(', ', $errors));
        }
    }
    

    public function edit($id)
    {
        $data['spec'] = $this->mcSpecModel->find($id);
        if (!$data['spec']) {
            return redirect()->to('/master-pps')->with('error', 'Data tidak ditemukan.');
        }
        return view('master_pps/form', $data);
    }

    public function update($id)
    {
        $spec = $this->mcSpecModel->find($id);
        if (!$spec) {
            return redirect()->to('/master-pps')->with('error', 'Data tidak ditemukan.');
        }
    
        $post = $this->request->getPost();
    
        $this->mcSpecModel->update($id, [
            'machine' => $post['machine'],
            'capacity' => $post['capacity'],
            'bolster_length' => $post['bolster_length'],
            'bolster_width' => $post['bolster_width'],
            'slide_area_length' => $post['slide_area_length'],
            'slide_area_width' => $post['slide_area_width'],
            'die_height' => $post['die_height'],
            'cushion_pad_length' => $post['cushion_pad_length'],
            'cushion_pad_width' => $post['cushion_pad_width'],
            'cushion_stroke' => $post['cushion_stroke'],
            'cushion' => $post['cushion']
        ]);
    
        $this->masterTableModel->where('machine', $post['machine'])->set([
            'capacity' => $post['capacity'],
            'cushion' => $post['cushion'],
            'dh_dies' => $post['die_height'],
            'status' => 1
        ])->update();
    
        return redirect()->to('/master-pps')->with('success', 'Data berhasil diperbarui di dua tabel.');
    }
    

    public function delete($id)
    {
        if (!$this->mcSpecModel->find($id)) {
            return redirect()->to('/master-pps')->with('error', 'Data tidak ditemukan.');
        }

        $this->mcSpecModel->delete($id);
        return redirect()->to('/master-pps')->with('success', 'Data berhasil dihapus.');
    }
}
