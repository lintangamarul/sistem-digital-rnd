<?php namespace App\Controllers;

use App\Models\CalendarModel;
use CodeIgniter\Controller;

class Calendar extends Controller
{
    protected $activityModel;
    
    public function __construct()
    {
        $this->activityModel = new \App\Models\ActivityModel();
    }
    
    public function index()
    {
        return view('calendar/index');
    }

    public function add()
    {
   
        $session = session();
        $model = new CalendarModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'date' => $this->request->getPost('date'),
            'start_time' => $this->request->getPost('start_time') ?: null,
            // 'notes' => $this->request->getPost('notes'),
            'is_private' => $this->request->getPost('is_private') ? 1 : 0,
            'created_by' => $session->get('user_id')
        ];

        $model->insert($data);
        return redirect()->to('/calendar');
    }

    public function delete($id)
    {
        $model = new CalendarModel();
        $session = session();
        $currentUserId = $session->get('id');
        
       $event = $model->find($id);
        
        if (!$event) {
            return $this->response->setJSON(['success' => false, 'message' => 'Event not found']);
        }
        
        if ($event['is_private'] && $event['created_by'] != $currentUserId) {
            return $this->response->setJSON(['success' => false, 'message' => 'You do not have permission to delete this event']);
        }
        
        $deleted = $model->delete($id);
        return $this->response->setJSON(['success' => $deleted]);
    }
}