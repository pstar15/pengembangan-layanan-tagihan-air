<div class="form-tagihan">
    <div class="img-edit-tagihan">
        <img src="<?= base_url('img/logo-bumdes.png') ?>" alt="logo-BUMDesa">
    </div>
    <h5>Edit Data Tagihan</h5>
    <hr>
    <form id="formUpdateTagihan" action="<?= base_url('/tagihan/update/' . $tagihan['id']) ?>" method="post" style="margin-top: 20px;">
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
            <input type="month" name="periode" value="<?= esc($tagihan['periode']) ?>" required><br>
        </div>

        <div class="form-group">
            <label>Jumlah Tagihan</label>
            <input type="number" name="jumlah_tagihan" value="<?= esc($tagihan['jumlah_tagihan']) ?>" required><br>
        </div>

        <div class="form-group">
            <label style="margin-bottom: 10px;">Status</label>
            <select name="status">
                <option value="Lunas" <?= $tagihan['status'] === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                <option value="Belum Lunas" <?= $tagihan['status'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                <option value="Tidak Ada" <?= $tagihan['status'] === 'Tidak Ada' ? 'selected' : '' ?>>Tidak Ada</option>
            </select>
        </div>
        <hr style="margin-top: 20px;">
        <button class="btn-updatetagihan" id="btnUpdatetagihan" type="submit">Update</button>
    </form>
</div>