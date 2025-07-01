<?php

namespace App\Controllers;

use App\Models\TagihanModel;
use App\Controllers\BaseController;
use App\Models\RiwayatTagihanModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;

class Riwayat extends BaseController
{
    protected $RiwayatTagihanModel;
    protected $TagihanModel;

    public function __construct()
    {
        $this->RiwayatTagihanModel = new RiwayatTagihanModel();
        $this->TagihanModel = new TagihanModel();
    }

    public function index()
    {
        $data['riwayat'] = $this->RiwayatTagihanModel->findAll();
        return view('tagihan/riwayat', $data);
    }

    public function kembalikan()
    {
        $tagihanModel = new \App\Models\TagihanModel();
        $riwayatModel = new \App\Models\RiwayatTagihanModel();

        $json = $this->request->getJSON(true);
        $ids = $json['ids'] ?? [];

        if (empty($ids)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data yang dipilih.']);
        }

        foreach ($ids as $id) {
            $riwayat = $riwayatModel->find($id);

            if (!$riwayat) continue;

            // Cek apakah data tagihan dengan identitas yang sama sudah ada
            $existing = $tagihanModel->where([
                'nama_pelanggan' => $riwayat['nama_pelanggan'],
                'alamat'         => $riwayat['alamat'],
                'nomor_meter'    => $riwayat['nomor_meter'],
                'jumlah_meter'   => $riwayat['jumlah_meter'],
            ])->first();

            if ($existing) {
                // Update hanya jika data kosong
                $updateData = [];
                if (empty($existing['periode'])) {
                    $updateData['periode'] = $riwayat['periode'];
                }
                if (empty($existing['jumlah_tagihan'])) {
                    $updateData['jumlah_tagihan'] = $riwayat['jumlah_tagihan'];
                }
                if (empty($existing['status'])) {
                    $updateData['status'] = $riwayat['status'];
                }

                if (!empty($updateData)) {
                    $tagihanModel->update($existing['id'], $updateData);
                }
            } else {
                // Tambahkan data baru jika tidak ada yang cocok
                $tagihanModel->insert([
                    'nama_pelanggan' => $riwayat['nama_pelanggan'],
                    'alamat'         => $riwayat['alamat'],
                    'nomor_meter'    => $riwayat['nomor_meter'],
                    'jumlah_meter'   => $riwayat['jumlah_meter'],
                    'periode'        => $riwayat['periode'],
                    'jumlah_tagihan' => $riwayat['jumlah_tagihan'],
                    'status'         => $riwayat['status'] ?? 'Tidak Ada',
                ]);
            }

            // Hapus dari riwayat setelah dipindahkan
            $riwayatModel->delete($id);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil dikembalikan.']);
    }
    public function hapus()
    {
        $input = $this->request->getJSON();
        $ids = $input->ids ?? [];

        if (!is_array($ids) || empty($ids)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
        }

        $RiwayatTagihanModel = new \App\Models\RiwayatTagihanModel();

        if ($RiwayatTagihanModel->delete($ids)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data.']);
        }
    }
    public function filter()
    {
        $periode = $this->request->getGet('periode'); // Format: YYYY-MM
        $RiwayatTagihanModel = new \App\Models\RiwayatTagihanModel();

        if ($periode) {
            $data['riwayat'] = $RiwayatTagihanModel
                ->like('periode', $periode)
                ->findAll();
        } else {
            $data['riwayat'] = $RiwayatTagihanModel->findAll();
        }

        $data['periode'] = $periode;

        return view('tagihan/riwayat', $data);
    }
    public function export($type)
    {
        $periode = $this->request->getGet('periode');
        $RiwayatTagihanModel = new \App\Models\RiwayatTagihanModel();

        if ($periode) {
            $data = $RiwayatTagihanModel->like('periode', $periode)->findAll();
        } else {
            $data = $RiwayatTagihanModel->findAll();
        }

        if ($type == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Data Tagihan');

            // Header
            $sheet->fromArray(['No', 'Nama Pelanggan', 'alamat', 'Nomor Meter', 'jumlah Meter', 'Periode', 'Jumlah Tagihan', 'Status'], NULL, 'A1');

            $rowIndex = 2;
            foreach ($data as $key => $row) {
                $sheet->setCellValue('A' . $rowIndex, $key + 1);
                $sheet->setCellValue('B' . $rowIndex, $row['nama_pelanggan']);
                $sheet->setCellValue('C' . $rowIndex, $row['alamat']);
                $sheet->setCellValue('D' . $rowIndex, $row['nomor_meter']);
                $sheet->setCellValue('E' . $rowIndex, $row['jumlah_meter']);
                $sheet->setCellValue('F' . $rowIndex, $row['periode']);
                $sheet->setCellValue('G' . $rowIndex, $row['jumlah_tagihan']);
                $sheet->setCellValue('H' . $rowIndex, $row['status']);
                $rowIndex++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'data_tagihan.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer->save('php://output');
            exit;
        }

        return redirect()->to('riwayat');
    }

}
