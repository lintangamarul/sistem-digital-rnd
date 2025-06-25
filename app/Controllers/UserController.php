<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
class UserController extends BaseController {
    protected $userModel;
    protected $roleModel; 
    public function __construct() {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

   public function index() {
        $data = [
            'title' => 'Data Pengguna',
            'users' => $this->userModel->where('status', 1)
            ->orderBy('group', 'ASC')
                                    ->orderBy('nama', 'ASC')
                                    ->findAll()
        ];  
        return view('user/index', $data);
    }

  public function updatePhoto()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id'); 

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->to('/profile')->with('error', 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.');
            }

            $newName = $file->getRandomName();
            $file->move('uploads/users/', $newName);

            $userModel->update($userId, ['foto' => $newName]);
            session()->set(['foto' => $newName]);

            return redirect()->to('/profile')->with('success', 'Foto berhasil diperbarui.');
        }
        return redirect()->to('/profile')->with('error', 'Gagal memperbarui foto.');
    }


    public function edit($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $data['user'] = $this->userModel->find($id);
        $data['roles'] = $this->roleModel->where('status', 1)->findAll();
        return view('user/edit', $data);
    }
    
    public function create() {
        $data['roles'] = $this->roleModel->where('status', 1)->findAll();
        return view('user/create', $data);
    }
    
    public function store() {
        $file = $this->request->getFile('foto');
        $fotoName = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoName = $file->getRandomName();
            $file->move('uploads/users', $fotoName);
        }
        $by = session()->get('user_id');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $data = [
            'nama'       => $this->request->getPost('nama'),
            'nik'        => $this->request->getPost('nik'),
            'password'   => $password,
            'department'      => $this->request->getPost('department'),
            'nickname'        => $this->request->getPost('nickname'),
            'group'    => $this->request->getPost('group'),
            'role_id'    => $this->request->getPost('role_id'),
            'foto'       => $fotoName,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $by,
            'updated_at' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('user_id'),
            'status'     => 1
        ];
        $this->userModel->save($data);
        return redirect()->to('/user');
    }
    
    public function update($id) {
        $file = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('old_foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoName = $file->getRandomName();
            $file->move('uploads/users', $fotoName);
            if (!empty($this->request->getPost('old_foto'))) {
                $oldFotoPath = 'uploads/users/' . $this->request->getPost('old_foto');
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }
        }
        $data = [
            'nama'       => $this->request->getPost('nama'),
            'nik'        => $this->request->getPost('nik'),
            'nickname'        => $this->request->getPost('nickname'),
            'email'      => $this->request->getPost('email'),
            'department'      => $this->request->getPost('department'),
            'role_id'    => $this->request->getPost('role_id'),
            'group'    => $this->request->getPost('group'),
            'foto'       => $fotoName,
            'updated_at' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('user_id')
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->userModel->update($id, $data);
        return redirect()->to('/user');
    }
    
    public function delete($id) {
        $data = [
            'status'     => 0,
            'updated_at' => date('Y-m-d H:i:s'),
          'modified_by' => session()->get('user_id')
        ];
     
        $this->userModel->update($id, $data);
        return redirect()->to('/user');
    }
    public function downloadExcel() {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Group');
        
        $users = $this->userModel
                    ->where('status', 1)
                    ->orderBy('group', 'ASC')
                    ->orderBy('nama', 'ASC')
                    ->findAll();
        
        $rowNumber = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $rowNumber, $user['nik']);
            $sheet->setCellValue('B' . $rowNumber, $user['nama']);
            $sheet->setCellValue('C' . $rowNumber, $user['group']);
            $rowNumber++;
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data_pengguna.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    
}
