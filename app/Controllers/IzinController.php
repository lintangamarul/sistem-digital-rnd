<?php 

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\ActualActivityModel;
use CodeIgniter\Controller;

class IzinController extends Controller
{
    protected $izinModel;
    protected $userModel;
    public function __construct()
    {
        $this->izinModel = new ActualActivityModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
       
        $userId = session()->get('user_id');
    
        if (has_permission(36)) {
            $data['izins'] = $this->izinModel
                ->select('actual_activity.*, users.nama as nama, users.nik')
                ->join('users', 'users.id = actual_activity.created_by', 'left')
                ->whereIn('actual_activity.status', [3, 4, 5, 6])
                ->orderBy('actual_activity.dates', 'DESC')
                ->findAll();
        } else {
            $data['izins'] = $this->izinModel
            ->select('actual_activity.*, users.nama as nama, users.nik')
            ->join('users', 'users.id = actual_activity.created_by', 'left')
                ->where('actual_activity.created_by', $userId)
                ->whereIn('actual_activity.status', [3, 4, 5, 6])
                ->orderBy('dates', 'DESC')
                ->findAll();
        }
    
        return view('izin/index', $data);
    }
    
// public function index()
// {
//     $userId = session()->get('user_id');
//     $roleId = session()->get('role_id');

//         $data['izins'] = $this->izinModel
//             ->where('created_by', $userId)
//             ->whereIn('status', [3, 4, 5, 6])
//             ->orderBy('dates', 'DESC')
//             ->findAll();
   

//     return view('izin/index', $data);
// }

    public function delete($id)
    {
        $izin = $this->izinModel->find($id);
        if (!$izin) {
            return redirect()->back()->with('error', 'Data izin tidak ditemukan.');
        }

        $this->izinModel->delete($id);
        return redirect()->to(site_url('izin'))->with('success', 'Data izin berhasil dihapus.');
    }
    
    public function create()
    {
    
        return view('izin/create');
    }
    public function store()
    {
     
        $tanggal  = $this->request->getPost('dates');
        $status   = $this->request->getPost('status');

        if ( !$tanggal || !$status) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi.');
        }
        $data = [
            'created_by' => session()->get('user_id'),
            'dates'      => $tanggal,
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
  
        $this->izinModel->insert($data);

        return redirect()->to(site_url('izin'))->with('success', 'Data perizinan berhasil disimpan.');
    }
}
