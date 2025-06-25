<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HolidayModel;

class HolidayController extends BaseController
{
    protected $holidayModel;

    public function __construct()
    {
        $this->holidayModel = new HolidayModel();
    }

    public function index()
    {
        $data['holidays'] = $this->holidayModel->orderBy('holiday_date', 'DESC')->findAll();
        return view('holiday/index', $data);
    }

    public function create()
    {
        return view('holiday/create');
    }

    public function store()
    {
        $holiday_date = $this->request->getPost('holiday_date');
        $description  = $this->request->getPost('description');

        if (!$holiday_date) {
            return redirect()->back()->withInput()->with('error', 'Holiday date is required.');
        }

        $this->holidayModel->insert([
            'holiday_date' => $holiday_date,
            'description'  => $description,
        ]);

        return redirect()->to(site_url('holiday'))->with('success', 'Holiday added successfully.');
    }

    public function delete($id)
    {
        $this->holidayModel->delete($id);
        return redirect()->to(site_url('holiday'))->with('success', 'Holiday deleted successfully.');
    }
}
