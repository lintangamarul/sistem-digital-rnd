<?php
namespace App\Controllers;

use App\Models\OutdoorActivityModel;
use App\Models\UserModel;

class OutdoorActivity extends BaseController {

    protected $activityModel;
    protected $userModel;

    public function __construct(){
         $this->activityModel = new OutdoorActivityModel();
         $this->userModel = new UserModel();
    }

    // Menampilkan daftar outdoor activity dalam bentuk tabel
    public function index()
    {

        // Gunakan tabel 'users' sebagai basis query
        $builder = $this->userModel->db->table('users');
        $builder->select("users.*, 
            outdoor_activities.id as activity_id, 
            COALESCE(outdoor_activities.kehadiran, 0) as kehadiran, 
            COALESCE(outdoor_activities.cuti, 0) as cuti, 
            COALESCE(outdoor_activities.genba, 0) as genba, 
            COALESCE(outdoor_activities.night_shift, 0) as night_shift");
        $builder->where('users.status', 1);
        
        // Left join sehingga semua user tampil, meskipun tidak ada record di outdoor_activities
        $builder->join('outdoor_activities', 'outdoor_activities.user_id = users.id', 'left');
        $query = $builder->get();
        $data['activities'] = $query->getResultArray();
    
        return view('outdoor_activity/index', $data);
    }
    

    // Form tambah activity
    public function create() {
         $data['users'] = $this->userModel->findAll();
         return view('outdoor_activity/create', $data);
    }

    // Simpan data baru
    public function store() {
         $post = $this->request->getPost();
         $insertData = [
              'user_id'     => $post['user_id'],
              'kehadiran'   => isset($post['kehadiran']) ? 1 : 0,
              'cuti'        => isset($post['cuti']) ? 1 : 0,
              'genba'       => isset($post['genba']) ? 1 : 0,
              'night_shift' => isset($post['night_shift']) ? 1 : 0,
         ];
         $this->activityModel->insert($insertData);
         return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil disimpan.');
    }

    // Form edit activity
    public function edit($id) {
         $data['activity'] = $this->activityModel->find($id);
         $data['users'] = $this->userModel->findAll();
         return view('outdoor_activity/edit', $data);
    }

    // Update data yang diedit
    public function update($id) {
         $post = $this->request->getPost();
         $updateData = [
              'user_id'     => $post['user_id'],
              'kehadiran'   => isset($post['kehadiran']) ? 1 : 0,
              'cuti'        => isset($post['cuti']) ? 1 : 0,
              'genba'       => isset($post['genba']) ? 1 : 0,
              'night_shift' => isset($post['night_shift']) ? 1 : 0,
         ];
         $this->activityModel->update($id, $updateData);
         return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus data activity
    public function delete($id) {
         $this->activityModel->delete($id);
         return redirect()->to(site_url('outdoor-activity'))->with('success', 'Data berhasil dihapus.');
    }
}
