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
        $json = $this->request->getJSON(true);
        $ids = $json['ids'] ?? [];

        if (empty($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada data yang dipilih.'
            ]);
        }

        $RiwayatTagihanModel = new \App\Models\RiwayatTagihanModel();
        $TagihanModel = new \App\Models\TagihanModel();

        try {
            $dataToMove = $RiwayatTagihanModel->whereIn('id', $ids)->findAll();

            if (empty($dataToMove)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan di riwayat.'
                ]);
            }

            foreach ($dataToMove as $item) {
                unset($item['id']);
                $TagihanModel->insert($item);
            }

            $RiwayatTagihanModel->whereIn('id', $ids)->delete();

            session()->setFlashdata('success', 'Data berhasil dikembalikan ke tabel tagihan.');

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dikembalikan.'
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengembalikan data: ' . $e->getMessage()
            ]);
        }
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
            $sheet->fromArray(['No', 'Nama Pelanggan', 'Nomor Meter', 'Periode', 'Jumlah Tagihan', 'Status'], NULL, 'A1');

            $rowIndex = 2;
            foreach ($data as $key => $row) {
                $sheet->setCellValue('A' . $rowIndex, $key + 1);
                $sheet->setCellValue('B' . $rowIndex, $row['nama_pelanggan']);
                $sheet->setCellValue('C' . $rowIndex, $row['nomor_meter']);
                $sheet->setCellValue('D' . $rowIndex, $row['periode']);
                $sheet->setCellValue('E' . $rowIndex, $row['jumlah_tagihan']);
                $sheet->setCellValue('F' . $rowIndex, $row['status']);
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
