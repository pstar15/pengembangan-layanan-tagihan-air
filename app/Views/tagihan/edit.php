<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Edit Data Tagihan</title>
    <style>
        body {
            background: #2A7B9B;
            height: 100vh;
            background: radial-gradient(circle,rgba(42, 123, 155, 1) 0%, rgba(87, 147, 199, 1) 50%, rgba(127, 83, 237, 1) 100%);
        }
        .form-tagihan {
            width: 100%;
        }
        .btn-updatetagihan{
            background: rgb(64, 135, 241);
            color: #fff;
        }
        .form-group input {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <!--

        PR add SweetAlert button update

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
            <h2>Edit Data Tagihan</h2>

            <form id="formUpdateTagihan" action="<?= base_url('/tagihan/update/' . $tagihan['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_pelanggan" value="<?= esc($tagihan['nama_pelanggan']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="<?= esc($tagihan['alamat']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label>No.Meter</label>
                    <input type="text" name="nomor_meter" value="<?= esc($tagihan['nomor_meter']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label>Jumlah Meter</label>
                    <input type="number" name="jumlah_meter" value="<?= esc($tagihan['jumlah_meter']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode" value="<?= esc($tagihan['periode']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label>Jumlah Tagihan</label>
                    <input type="number" name="jumlah_tagihan" value="<?= esc($tagihan['jumlah_tagihan']) ?>" required><br>
                </div>

                <div class="form-group">
                    <label style="margin-bottom: 10px;">Status</label>
                    <select name="status">
                        <option value="Belum Lunas" <?= $tagihan['status'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                        <option value="Lunas" <?= $tagihan['status'] === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                    </select>
                </div>

                <button class="btn-updatetagihan" id="btnUpdatetagihan" type="submit">Update</button>
            </form>
            <a href="<?= base_url('/tagihan') ?>" class="btn-kembali">← Kembali ke Daftar Tagihan</a>
        </div>
    </div>

    <script src="<?= base_url('js/script.js') ?>" defer></script>
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('btnUpdatetagihan').addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah submit otomatis

            Swal.fire({
                title: 'Yakin ingin menyimpan data ini?',
                text: "Pastikan data sudah sesuai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form secara manual setelah konfirmasi
                    document.getElementById('formUpdateTagihan').submit();
                }
            });
        });

    </script>
</body>
</html>