<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Tambah Data Tagihan</title>
    <style>
        body {
            background: #2A7B9B;
            background: radial-gradient(circle,rgba(42, 123, 155, 1) 0%, rgba(87, 147, 199, 1) 50%, rgba(127, 83, 237, 1) 100%);
        }
        .form-tagihan {
            width: 100%;
        }
    </style>
</head>
<body>

    <!--

        PR 

    -->

    <!-- aleerts -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success custom-alert" id="alertBox">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger custom-alert" id="alertBox">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="form-tagihan">
            <!-- app/Views/tagihan/create.php -->
            <h2>Tambah Data Tagihan</h2>
            <form id="formAddTagihan" action="<?= base_url('/tagihan/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" value="<?= old('nama_pelanggan', $data['nama_pelanggan'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>Nomor Meter</label>
                    <input type="text" name="nomor_meter" value="<?= old('nomor_meter', $data['nomor_meter'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="month" name="periode" value="<?= old('periode', $data['periode'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Tagihan</label>
                    <input type="number" name="jumlah_tagihan" value="<?= old('jumlah_tagihan', $data['jumlah_tagihan'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Lunas" <?= (old('status', $data['status'] ?? '') == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                        <option value="Belum Lunas" <?= (old('status', $data['status'] ?? '') == 'Belum Lunas') ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>
                </div>

                <button type="submit" id="btnAddTagihan" class="btn-simpan">Simpan</button>
            </form>
            <a href="<?= base_url('/tagihan') ?>" class="btn-kembali">← Kembali ke Daftar Tagihan</a>
        </div>
    </div>

    <script src="<?= base_url('js/script.js') ?>" defer></script>
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('btnAddTagihan').addEventListener('click', function(e) {
            e.preventDefault(); // Cegah submit form langsung

            Swal.fire({
                title: 'Yakin ingin menambahkan data tagihan?',
                text: "Pastikan data sudah benar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika konfirmasi OK
                    document.getElementById('formAddTagihan').submit();
                }
            });
        });
    </script>
</body>
</html>