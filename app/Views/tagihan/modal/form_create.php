<div class="form-tagihan">
    <div class="img-create-tagihan">
        <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="logo-BUMDesa">
    </div>
    <h5>Tambah Data Tagihan</h5>
    <hr>
    <form id="formAddTagihan" action="<?= base_url('/tagihan/store') ?>" method="post" style="margin-top: 20px;">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_pelanggan" value="<?= old('nama_pelanggan', $data['nama_pelanggan'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?= old('alamat', $data['alamat'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>No.Meter</label>
            <input type="text" name="nomor_meter" value="<?= old('nomor_meter', $data['nomor_meter'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Jumlah Meter</label>
            <input type="number" name="jumlah_meter" pattern="\d{8}" maxlength="8" title="Harus 8 digit angka" value="<?= old('jumlah_meter', $data['jumlah_meter'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Periode</label>
            <input type="month" name="periode" value="<?= old('periode', $data['periode'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Total Tagihan</label>
            <input type="number" name="jumlah_tagihan" value="<?= old('jumlah_tagihan', $data['jumlah_tagihan'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" style="margin-top: 10px;">
                <option value="Lunas" <?= (old('status', $data['status'] ?? '') == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                <option value="Belum Lunas" <?= (old('status', $data['status'] ?? '') == 'Belum Lunas') ? 'selected' : '' ?>>Belum Lunas</option>
                <option value="Tidak Ada" <?= (old('status', $data['status'] ?? '') == 'Tidak Ada') ? 'selected' : '' ?>>Tidak Ada</option>
            </select>
        </div>
        <hr style="margin-top: 20px;">
        <button type="submit" id="btnAddTagihan" class="btn-simpan">Simpan</button>
    </form>
</div>