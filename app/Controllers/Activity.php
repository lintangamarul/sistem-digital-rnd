<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\ActivityModel;
use CodeIgniter\Controller;
class Activity extends Controller
{
    protected $activityModel;
    protected $projectModel;

    public function __construct()
    {
        $this->activityModel = new ActivityModel();
        $this->projectModel  = new ProjectModel();
  
    }
    public function index()
    {
        $data['activities'] = $this->activityModel
            ->select('activities.id, activities.name, activities.status, projects.jenis, projects.another_project')
            ->join('projects', 'projects.id = activities.project_id', 'left')
            ->where('activities.status', 1)
            ->groupBy(['activities.id', 'activities.name', 'activities.status', 'projects.jenis', 'projects.another_project'])
            ->orderBy('activities.name', 'ASC') 
            ->findAll();
    
        return view('activity/index', $data);
    }
    
    
    public function create()
    {
        $data['projects'] = $this->projectModel->where('status', 1)->findAll();
        return view('activity/create', $data);
    }

    public function store()
    {
        $createdBy = session()->get('user_id');
    
        $this->activityModel->save([
            'name'        => $this->request->getPost('name'),
            'created_by'  => $createdBy, 
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(site_url('activity'));
    }

    public function edit($encrypted_id)
    {
        $encrypted = urlsafe_b64decode($encrypted_id);
        $id = service('encrypter')->decrypt($encrypted);
        $data['activity'] = $this->activityModel->find($id);
        $data['projects'] = $this->projectModel->where('status', 1)->findAll();
        return view('activity/edit', $data);
    }
    public function update($id)
    {
        $modified_by = session()->get('user_id');
    
        $this->activityModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'modified_by' => $modified_by, 
            'modified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(site_url('activity'));
    }
     

    public function delete($id)
    {
        $modifiedBy = session()->get('user_id');
        
        $this->activityModel->update($id, [
            'status'      => 0,
            'modified_by' => $modifiedBy,
            'modified_at' => date('Y-m-d H:i:s')
        ]);
    
        return redirect()->to('/activity')->with('success', 'Project berhasil diubah status menjadi tidak aktif.');
    }
    
}
