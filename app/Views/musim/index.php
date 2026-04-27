<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Musim Tanam</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahMusim">
        + Tambah Musim Baru
    </button>
</div>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php foreach($musim as $m) : ?>
    <div class="col-12 mb-3">
        <div class="card card-musim p-3 d-flex flex-row justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold"><?= $m['nama_musim'] ?></h5>
                <small class="text-muted">
                    <?= date('d M Y', strtotime($m['tgl_mulai'])) ?> - <?= date('d M Y', strtotime($m['tgl_selesai'])) ?>
                </small>
                <?php if($m['status_aktif'] == 1): ?>
                    <span class="badge bg-success ms-2">Aktif</span>
                <?php else: ?>
                    <span class="badge bg-secondary ms-2">Selesai</span>
                <?php endif; ?>
            </div>
            
            <div>
                <?php if($m['status_aktif'] == 0): ?>
                    <a href="/musimtanam/set_aktif/<?= $m['id_musim'] ?>" class="btn btn-outline-success btn-sm">Set sebagai Aktif</a>
                <?php else: ?>
                    <button class="btn btn-success btn-sm" disabled>Sedang Aktif</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php if(empty($musim)): ?>
        <div class="text-center text-muted mt-5">
            <p>Belum ada data musim tanam. Silakan tambah baru.</p>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalTambahMusim" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Musim Tanam Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="/musimtanam/simpan" method="post">
          <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Musim</label>
                <input type="text" class="form-control" name="nama_musim" placeholder="Contoh: Musim Tanam Awal 2026" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tgl_mulai" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tgl_selesai" required>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Musim</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>