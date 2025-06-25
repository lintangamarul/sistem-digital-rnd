<?php namespace App\Controllers;

use App\Models\DieConsImageModel;
use CodeIgniter\Controller;

class DieConsController extends Controller
{
    protected $model;
    protected $uploadPath;

    public function __construct()
    {
        $this->model      = new DieConsImageModel();
        $this->uploadPath = FCPATH . 'uploads/die_cons/';
        if (! is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index()
    {
        $data['items'] = $this->model->findAll();
        return view('die_cons/index', $data);
    }

    public function new()
    {
        return view('die_cons/create');
    }

    public function create()
    {
        $prosesArr        = $this->request->getPost('proses') ?: [];
        $castingArr       = $this->request->getPost('casting_plate') ?: [];
        $padLifter        = $this->request->getPost('pad_lifter');

        // Gabungkan proses, pad_lifter, dan casting_plate untuk membuat nama file
        $fileNameParts = array_merge($prosesArr, [$padLifter], $castingArr);
        $fileNameBase  = implode('_', $fileNameParts);

        $data = [
            'proses'        => implode(',', $prosesArr),         // ← checkbox array jadi string
            'pad_lifter'    => $padLifter,
            'casting_plate' => implode(',', $castingArr),
        ];

        // 2) Handle upload image
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $ext           = $file->getExtension();
            $fileName      = "{$fileNameBase}_" . time() . ".$ext";  // Gunakan gabungan sebagai bagian nama file
            $file->move($this->uploadPath, $fileName);
            $data['image'] = $fileName;
        }

        // 3) Simpan
        $this->model->save($data);
        return redirect()->to('/die-cons')->with('success','Data berhasil ditambah');
    }


    public function edit($id = null)
    {
        $data['item'] = $this->model->find($id);
        return view('die_cons/edit', $data);
    }

    public function update($id = null)
    {
        $existing = $this->model->find($id);
        if (! $existing) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data #{$id} tidak ditemukan");
        }

        // 1) Ambil dan olah input
        $prosesArr        = $this->request->getPost('proses') ?: [];
        $castingArr       = $this->request->getPost('casting_plate') ?: [];
        $padLifter        = $this->request->getPost('pad_lifter');

        // Gabungkan proses, pad_lifter, dan casting_plate untuk membuat nama file
        $fileNameParts = array_merge($prosesArr, [$padLifter], $castingArr);
        $fileNameBase  = implode('_', $fileNameParts);

        $data = [
            'id'            => $id,
            'proses'        => implode(',', $prosesArr),
            'pad_lifter'    => $padLifter,
            'casting_plate' => implode(',', $castingArr),
        ];

        // 2) Handle upload / pertahankan
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            // hapus file lama jika ada
            if (! empty($existing['image'])) {
                @unlink($this->uploadPath . $existing['image']);
            }
            $ext           = $file->getExtension();
            $fileName      = "{$fileNameBase}_" . time() . ".$ext";  // Gunakan gabungan sebagai bagian nama file
            $file->move($this->uploadPath, $fileName);
            $data['image'] = $fileName;
        } else {
            // tidak upload → gunakan nama lama
            $data['image'] = $existing['image'];
        }

        // 3) Simpan update
        $this->model->save($data);
        return redirect()->to('/die-cons')->with('success','Data berhasil diupdate');
    }

    public function delete($id = null)
    {
        $item = $this->model->find($id);
        if ($item && ! empty($item['image'])) {
            @unlink($this->uploadPath . $item['image']);
        }
        $this->model->delete($id);
        return redirect()->to('/die-cons')->with('success','Data berhasil dihapus');
    }
}
