<?php

namespace App\Models;

use CodeIgniter\Model;

class LapanganModel extends Model
{
    protected $table            = 'lapangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_lapangan',
        'jenis_lantai',
        'harga_per_jam',
        'deskripsi',
        'status',
        'gambar',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_lapangan' => 'required|min_length[3]|max_length[150]',
        'jenis_lantai'  => 'required|max_length[150]',
        'harga_per_jam' => 'required|numeric|greater_than[0]',
        'status'        => 'required|in_list[Tersedia,Tidak Aktif]',
        'deskripsi'     => 'permit_empty|max_length[150]',
    ];

    protected $validationMessages = [
        'nama_lapangan' => [
            'required'   => 'Nama lapangan wajib diisi.',
            'min_length' => 'Nama lapangan minimal 3 karakter.',
        ],
        'jenis_lantai' => [
            'required' => 'Jenis lantai wajib dipilih atau diisi.',
        ],
        'harga_per_jam' => [
            'required'     => 'Harga per jam wajib diisi.',
            'numeric'      => 'Harga per jam harus berupa angka.',
            'greater_than' => 'Harga per jam harus lebih besar dari 0.',
        ],
        'status' => [
            'required' => 'Status lapangan wajib dipilih.',
            'in_list'  => 'Status harus Tersedia atau Tidak Aktif.',
        ],
    ];

    public function getAvailableFields()
    {
        return $this->where('status', 'Tersedia')
                    ->orderBy('nama_lapangan', 'ASC')
                    ->findAll();
    }
}
