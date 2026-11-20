<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'email',
        'password',
        'no_hp',
        'role',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama'  => 'required|min_length[3]|max_length[150]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'no_hp' => 'permit_empty|min_length[8]|max_length[20]',
        'role'  => 'required|in_list[admin,customer]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique'   => 'Email ini sudah terdaftar.',
        ],
        'role' => [
            'required' => 'Role wajib ditentukan.',
            'in_list'  => 'Role harus admin atau customer.',
        ],
    ];

    public function getCustomersWithBookingCount()
    {
        return $this->select('users.*, COUNT(bookings.id) as total_booking')
                    ->join('bookings', 'bookings.user_id = users.id', 'left')
                    ->where('users.role', 'customer')
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }
}
