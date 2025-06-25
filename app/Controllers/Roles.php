<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RoleFeatureModel;

class Roles extends BaseController
{
    public function index()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->where('status', 1)->findAll();
        return view('roles/index', $data);
    }

    public function create()
    {
        // Assume $fitur_list is fetched from database or defined as array
        // Example:
        // $fitur_list = [
        //     ['Id_Fitur' => 1, 'Nama' => 'User::index()'],
        //     ['Id_Fitur' => 2, 'Nama' => 'User::create()'],
        //     // ...
        // ];
        $data['fitur_list'] = $this->getFiturList();
        return view('roles/create', $data);
    }

    public function store()
    {
        $roleModel = new RoleModel();
        $data = [
            'role_name'   => $this->request->getPost('role_name'),
            'created_by'  => session()->get('user_id') ?? 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'status'      => 1
        ];
        $roleModel->save($data);
        $role_id = $roleModel->getInsertID();

        $fitur = $this->request->getPost('fitur');
        if ($fitur) {
            $roleFeatureModel = new RoleFeatureModel();
            foreach ($fitur as $fitur_id) {
                $roleFeatureModel->save([
                    'role_id'    => $role_id,
                    'fitur_id'   => $fitur_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return redirect()->to(site_url('role'));
    }

    public function edit($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $roleModel = new RoleModel();
        $data['role'] = $roleModel->find($id);

        $roleFeatureModel = new RoleFeatureModel();
        $data['role_features'] = $roleFeatureModel->where('role_id', $id)->findAll();

        $data['fitur_list'] = $this->getFiturList();
        return view('roles/edit', $data);
    }

    public function update($id)
    {
        $roleModel = new RoleModel();
        $data = [
            'role_name'   => $this->request->getPost('role_name'),
            'modified_by' => session()->get('user_id') ?? 1,
            'modified_at' => date('Y-m-d H:i:s')
        ];
        $roleModel->update($id, $data);

        $roleFeatureModel = new RoleFeatureModel();
        $roleFeatureModel->where('role_id', $id)->delete();

        $fitur = $this->request->getPost('fitur');
        if ($fitur) {
            foreach ($fitur as $fitur_id) {
                $roleFeatureModel->save([
                    'role_id'    => $id,
                    'fitur_id'   => $fitur_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return redirect()->to(site_url('role'));
    }

    public function delete($id)
    {
        if (in_array($id, [5, 6])) {
            return redirect()->to(site_url('role'))->with('error', 'Role ini tidak bisa dihapus.');
        }
    
        $roleModel = new RoleModel();
        
        if (!$roleModel->find($id)) {
            return redirect()->to(site_url('role'))->with('error', 'Role tidak ditemukan.');
        }
        $roleModel = new RoleModel();
        $data = [
            'status'      => 0,
            'modified_by' => session()->get('user_id') ?? 1,
            'modified_at' => date('Y-m-d H:i:s')
        ];
        $roleModel->update($id, $data);
        return redirect()->to(site_url('role'));
    }

    private function getFiturList()
    {
        return [
            ['Id_Fitur' => 1, 'Nama' => 'Lihat Pengguna'],
            ['Id_Fitur' => 2, 'Nama' => 'Tambah Pengguna'],
            ['Id_Fitur' => 3, 'Nama' => 'Edit Pengguna'],
            ['Id_Fitur' => 4, 'Nama' => 'Hapus Pengguna'],
        
            ['Id_Fitur' => 5, 'Nama' => 'Daftar Project'],
            ['Id_Fitur' => 6, 'Nama' => 'Simpan Project'],
            ['Id_Fitur' => 7, 'Nama' => 'Perbarui Project'],
            ['Id_Fitur' => 8, 'Nama' => 'Hapus Project'],
        
            ['Id_Fitur' => 9, 'Nama' => 'Daftar Role'],
            ['Id_Fitur' => 10, 'Nama' => 'Simpan Role'],
            ['Id_Fitur' => 11, 'Nama' => 'Perbarui Role'],
            ['Id_Fitur' => 12, 'Nama' => 'Hapus Role'],
        
            ['Id_Fitur' => 13, 'Nama' => 'Daftar Aktivitas'],
            ['Id_Fitur' => 14, 'Nama' => 'Simpan Aktivitas'],
            ['Id_Fitur' => 15, 'Nama' => 'Perbarui Aktivitas'],
            ['Id_Fitur' => 16, 'Nama' => 'Hapus Aktivitas'],
        
            ['Id_Fitur' => 17, 'Nama' => 'Daftar LKH'],
            ['Id_Fitur' => 18, 'Nama' => 'Hapus LKH Detail'],
            ['Id_Fitur' => 19, 'Nama' => 'Daftar LKH Pribadi'],
            ['Id_Fitur' => 20, 'Nama' => 'Simpan LKH'],
            ['Id_Fitur' => 21, 'Nama' => 'Perbarui LKH'],
            ['Id_Fitur' => 22, 'Nama' => 'Detail LKH'],
        
            ['Id_Fitur' => 23, 'Nama' => 'Dashboard'],
        
            ['Id_Fitur' => 24, 'Nama' => 'Riwayat Aktivitas'],
            ['Id_Fitur' => 25, 'Nama' => 'Profil Riwayat'],
            ['Id_Fitur' => 26, 'Nama' => 'Detail Profil Riwayat'],

            ['Id_Fitur' => 27, 'Nama' => 'Submit LKH'],
            ['Id_Fitur' => 28, 'Nama' => 'Lihat Holiday'],
            ['Id_Fitur' => 29, 'Nama' => 'Tambah Holiday'],
            ['Id_Fitur' => 30, 'Nama' => 'Hapus Holiday'],

            ['Id_Fitur' => 31, 'Nama' => 'Lihat Perizinan'],
            ['Id_Fitur' => 32, 'Nama' => 'Tambah Perizinan'],
            ['Id_Fitur' => 33, 'Nama' => 'Hapus Perizinan'],
            ['Id_Fitur' => 34, 'Nama' => 'Rollback LKH'],
            ['Id_Fitur' => 35, 'Nama' => 'Set Perizinan Pengguna Lain'],
            ['Id_Fitur' => 36, 'Nama' => 'Master PPS DCP'],
            ['Id_Fitur' => 37, 'Nama' => 'Lihat PPS'],
            ['Id_Fitur' => 38, 'Nama' => 'Tambah PPS'],
            ['Id_Fitur' => 39, 'Nama' => 'Perbarui PPS'],
            ['Id_Fitur' => 40, 'Nama' => 'Hapus PPS'],
            
            ['Id_Fitur' => 41, 'Nama' => 'Lihat DCP'],
            ['Id_Fitur' => 42, 'Nama' => 'Tambah DCP'],
            ['Id_Fitur' => 43, 'Nama' => 'Perbarui DCP'],
            ['Id_Fitur' => 44, 'Nama' => 'Hapus DCP'],
            ['Id_Fitur' => 45, 'Nama' => 'Copy PPS'],
            ['Id_Fitur' => 46, 'Nama' => 'Rollback PPS'],
            ['Id_Fitur' => 47, 'Nama' => 'Kalender'],
            ['Id_Fitur' => 48, 'Nama' => 'Outdoor Activity'],

            ['Id_Fitur' => 49, 'Nama' => 'Edit Tryout Report Dies'],
            ['Id_Fitur' => 50, 'Nama' => 'Hapus Tryout Report Dies'],
            ['Id_Fitur' => 51, 'Nama' => 'Print Tryout Report Dies'],

            ['Id_Fitur' => 52, 'Nama' => 'Edit Tryout Report Jig'],
            ['Id_Fitur' => 53, 'Nama' => 'Hapus Tryout Report Jig'],
            ['Id_Fitur' => 54, 'Nama' => 'Print Tryout Report Jig'],

            ['Id_Fitur' => 55, 'Nama' => 'Lihat Master CCF JCP'],
            ['Id_Fitur' => 56, 'Nama' => 'Tambah Master CCF JCP'],
            ['Id_Fitur' => 57, 'Nama' => 'Edit Master CCF JCP'],
            ['Id_Fitur' => 58, 'Nama' => 'Hapus Master CCF JCP'],
            ['Id_Fitur' => 59, 'Nama' => 'Lihat Form CCF'],
            ['Id_Fitur' => 60, 'Nama' => 'Tambah Form CCF'],
            ['Id_Fitur' => 61, 'Nama' => 'Edit Form CCF'],
            ['Id_Fitur' => 62, 'Nama' => 'Hapus Form CCF'],
            ['Id_Fitur' => 63, 'Nama' => 'Lihat Form JCP'],
            ['Id_Fitur' => 64, 'Nama' => 'Tambah Form JCP'],
            ['Id_Fitur' => 65, 'Nama' => 'Edit Form JCP'],
            ['Id_Fitur' => 66, 'Nama' => 'Hapus Form JCP'],

            ['Id_Fitur' => 67, 'Nama' => 'Lihat Piket'],
            ['Id_Fitur' => 68, 'Nama' => 'Tambah Piket'],
            ['Id_Fitur' => 69, 'Nama' => 'Edit Piket'],
            ['Id_Fitur' => 70, 'Nama' => 'Hapus Piket'],
            ['Id_Fitur' => 71, 'Nama' => 'Tambah Petugas Briefing'],

        ];
    }
}
