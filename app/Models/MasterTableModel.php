<?php namespace App\Models;

use CodeIgniter\Model;

class MasterTableModel extends Model
{
    protected $table         = 'master_table';  // Nama tabel di database
    protected $primaryKey    = 'id';            // Primary key tabel
    protected $allowedFields = [
        'machine',      // Kolom machine
        'capacity',     // Kolom capacity
        'cushion',      // Kolom cushion
        'status',       // Kolom status
        'dh_dies'       // Kolom dh_dies
    ];
    // protected $useTimestamps = true;  // Mengaktifkan penggunaan timestamp
    // protected $createdField  = 'created_at';  // Nama kolom untuk created_at
    // protected $updatedField  = 'modified_at'; // Nama kolom untuk modified_at

    // Jika diperlukan, Anda bisa menambahkan fungsi validasi atau relasi lainnya.
}