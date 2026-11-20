<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\BookingModel;

class Lapangan extends BaseController
{
    protected $lapanganModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
        $this->bookingModel  = new BookingModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Data Lapangan - SportRent Admin',
            'lapangan' => $this->lapanganModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('admin/lapangan/index', $data);
    }

    public function tambah()
    {
        return view('admin/lapangan/tambah', [
            'title' => 'Tambah Lapangan Baru - SportRent Admin'
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama_lapangan' => 'required|min_length[3]|max_length[150]',
            'jenis_lantai'  => 'required|max_length[150]',
            'harga_per_jam' => 'required|numeric|greater_than[0]',
            'status'        => 'required|in_list[Tersedia,Tidak Aktif]',
            'deskripsi'     => 'permit_empty|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload foto jika ada
        $gambarFile = $this->request->getFile('gambar');
        $namaGambar = 'default-court.jpg';

        if ($gambarFile && $gambarFile->isValid() && !$gambarFile->hasMoved()) {
            $namaGambar = $gambarFile->getRandomName();
            $gambarFile->move(FCPATH . 'assets/images/lapangan', $namaGambar);
        }

        $this->lapanganModel->save([
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis_lantai'  => $this->request->getPost('jenis_lantai'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'status'        => $this->request->getPost('status'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'gambar'        => $namaGambar,
        ]);

        return redirect()->to('/admin/lapangan')->with('success', 'Data lapangan baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lapangan = $this->lapanganModel->find($id);
        if (!$lapangan) {
            return redirect()->to('/admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        return view('admin/lapangan/edit', [
            'title'    => 'Edit Data Lapangan - SportRent Admin',
            'lapangan' => $lapangan,
        ]);
    }

    public function update($id)
    {
        $lapangan = $this->lapanganModel->find($id);
        if (!$lapangan) {
            return redirect()->to('/admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        $rules = [
            'nama_lapangan' => 'required|min_length[3]|max_length[150]',
            'jenis_lantai'  => 'required|max_length[150]',
            'harga_per_jam' => 'required|numeric|greater_than[0]',
            'status'        => 'required|in_list[Tersedia,Tidak Aktif]',
            'deskripsi'     => 'permit_empty|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGambar = $lapangan['gambar'];
        $gambarFile = $this->request->getFile('gambar');
        if ($gambarFile && $gambarFile->isValid() && !$gambarFile->hasMoved()) {
            $namaGambar = $gambarFile->getRandomName();
            $gambarFile->move(FCPATH . 'assets/images/lapangan', $namaGambar);
        }

        $this->lapanganModel->update($id, [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis_lantai'  => $this->request->getPost('jenis_lantai'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'status'        => $this->request->getPost('status'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'gambar'        => $namaGambar,
        ]);

        return redirect()->to('/admin/lapangan')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $lapangan = $this->lapanganModel->find($id);
        if (!$lapangan) {
            return redirect()->to('/admin/lapangan')->with('error', 'Data lapangan tidak ditemukan.');
        }

        // Cek foreign key safety: apakah ada riwayat booking?
        $hasBookings = $this->bookingModel->where('lapangan_id', $id)->countAllResults();
        if ($hasBookings > 0) {
            $force = $this->request->getPost('force_delete');
            if ($force === '1') {
                // Hapus payments terkait semua booking lapangan ini, lalu hapus bookings, lalu hapus lapangan
                $bookings = $this->bookingModel->where('lapangan_id', $id)->findAll();
                foreach ($bookings as $b) {
                    $this->paymentModel->where('booking_id', $b['id'])->delete();
                }
                $this->bookingModel->where('lapangan_id', $id)->delete();
                $this->lapanganModel->delete($id);
                return redirect()->to('/admin/lapangan')->with('success', 'Data lapangan beserta seluruh riwayat booking terkait berhasil dihapus permanen!');
            }

            // Ubah status ke Tidak Aktif untuk menjaga integritas data riwayat transaksi
            $this->lapanganModel->update($id, ['status' => 'Tidak Aktif']);
            return redirect()->to('/admin/lapangan')->with('warning', 'Lapangan memiliki riwayat transaksi booking dan dinonaktifkan (Status: Tidak Aktif). Anda juga dapat memilih opsi Hapus Bersih jika ingin menghapus permanen.');
        }

        $this->lapanganModel->delete($id);
        return redirect()->to('/admin/lapangan')->with('success', 'Data lapangan berhasil dihapus permanen!');
    }
}
