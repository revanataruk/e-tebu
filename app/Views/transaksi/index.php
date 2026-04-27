<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Buku Transaksi</h2>
    <div>
        <a href="/transaksi/ekspor" target="_blank" class="btn btn-outline-secondary me-2">Ekspor PDF</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
            + Input Transaksi Baru
        </button>
    </div>
</div>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('pesan') ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?= session()->getFlashdata('error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="table-wrapper">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Metode Bayar</th>
                <th>Status</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($transaksi)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi di musim ini.</td></tr>
            <?php else: ?>
                <?php foreach($transaksi as $t): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                    <td><?= $t['keterangan'] ?></td>
                    <td><?= $t['nama_kategori'] ?></td>
                    <td><?= $t['jenis_pembayaran'] ?></td>
                    <td>
                        <?php if($t['status_lunas'] == 1): ?>
                            <span class="badge bg-success">Lunas</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Belum Lunas</span>
                            <br><small class="text-danger" style="font-size: 0.75rem;">JT: <?= date('d/m/y', strtotime($t['jatuh_tempo'])) ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="<?= $t['tipe_akun'] == 'Pemasukan' ? 'text-success' : 'text-danger' ?> fw-bold">
                        <?= $t['tipe_akun'] == 'Pemasukan' ? '+' : '-' ?> Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTransaksi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Transaksi Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="/transaksi/simpan" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori Biaya/Pendapatan</label>
                    <select class="form-select" name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>">[<?= $k['tipe_akun'] ?>] <?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nominal (Rp)</label>
                    <input type="number" class="form-control" name="nominal" placeholder="Contoh: 1500000" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-select" name="jenis_pembayaran" id="metodeBayar" onchange="cekTempo()" required>
                        <option value="Tunai">Tunai / Transfer</option>
                        <option value="Kredit">Kredit / Tempo</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="divTempo" style="display: none;">
                    <label class="form-label text-danger">Tanggal Jatuh Tempo</label>
                    <input type="date" class="form-control" name="jatuh_tempo" id="inputTempo">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan transaksi..."></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Upload Bukti Nota (Opsional)</label>
                    <input type="file" class="form-control" name="foto_nota" accept="image/*">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success w-100">Simpan Transaksi</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function cekTempo() {
        var metode = document.getElementById("metodeBayar").value;
        var divTempo = document.getElementById("divTempo");
        var inputTempo = document.getElementById("inputTempo");
        
        if (metode === "Kredit") {
            divTempo.style.display = "block";
            inputTempo.required = true;
        } else {
            divTempo.style.display = "none";
            inputTempo.required = false;
            inputTempo.value = "";
        }
    }
</script>
<?= $this->endSection() ?>