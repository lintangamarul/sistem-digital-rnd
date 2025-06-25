<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function login() {
    
        return view('auth/login');
    }

    public function attemptLogin() {
        $userModel = new UserModel();
        $nik = $this->request->getPost('nik');
        $password = $this->request->getPost('password');
    
        if (empty($nik) || empty($password)) {
            return redirect()->back()->with('error', 'NIK dan Password wajib diisi.');
        }
    
        $user = $userModel->where('nik', $nik)->first();
    
        if ($user) {
            if (password_verify($password, $user['password'])) {
             
                $roleFeatureModel = new \App\Models\RoleFeatureModel();
                $roleFeatures = $roleFeatureModel->where('role_id', $user['role_id'])->findAll();
                $allowedFeatures = [];
                foreach ($roleFeatures as $feature) {
                    $allowedFeatures[] = $feature['fitur_id'];
                }
                session()->set([
                    'user_id'    => $user['id'],
                    'role_id'    => $user['role_id'],
                    'user_name'  => $user['nama'],
                    'foto'       => $user['foto'],
                    'isLoggedIn' => true,
                    'nik'        => $user['nik'],
                    'nickname'        => $user['nickname'],
                    'fitur'      => $allowedFeatures  
                ]);
            
                return redirect()->to('/actual-activity/personal')->with('success', 'Login berhasil!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Password salah.');
            }
        }
        return redirect()->back()->withInput()->with('error', 'NIK tidak ditemukan.');
    }
    
    public function reset($nik)
    {
      
        $data = [
            'nik' => $nik
        ];

        return view('auth/reset_password', $data);
    }
    public function updatePassword($nik)
    {
        
        $oldPassword     = $this->request->getPost('old_password');
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Password baru dan konfirmasi tidak cocok.');
        }

        $user = $this->userModel->where('nik', $nik)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'User tidak ditemukan.');
        }

        if (!password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password lama salah.');
        }

        $updatedData = [
            'password'    => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
            'modified_by' => session()->get('user_id') 
        ];

        $this->userModel->update($user['id'], $updatedData);

        return redirect()->to('profile')->with('success', 'Password berhasil direset.');
    }
    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
