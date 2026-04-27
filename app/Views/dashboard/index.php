<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Halo, <?= session()->get('nama_lengkap') ?>! 👋</h2>
    
    <?php if($musimAktif): ?>
        <span class="badge bg-success-light p-2 fs-6">🌱 <?= $musimAktif['nama_musim'] ?> (Aktif)</span>
    <?php else: ?>
        <span class="badge bg-danger p-2 fs-6">⚠️ Belum ada musim tanam yang aktif!</span>
    <?php endif; ?>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-summary p-3">
            <p class="text-muted mb-1">Total Pemasukan</p>
            <h3>Rp <?= number_format($pemasukan, 0, ',', '.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-summary p-3">
            <p class="text-muted mb-1">Total Pengeluaran</p>
            <h3>Rp <?= number_format($pengeluaran, 0, ',', '.') ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-summary p-3 <?= $saldo >= 0 ? 'bg-success text-white' : 'bg-danger text-white' ?>">
            <p class="mb-1 text-white-50">Saldo Saat Ini</p>
            <h3>Rp <?= number_format($saldo, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-summary p-4 h-100 text-center text-muted">
            <i>[Area Grafik Arus Kas Bulanan akan tampil di sini]</i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-summary p-4 h-100">
            <h5 class="mb-4">Jatuh Tempo (Belum Lunas)</h5>
            
            <?php if(empty($tagihan)): ?>
                <p class="text-muted small">Hebat! Tidak ada tagihan yang tertunda.</p>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach($tagihan as $t): ?>
                        <div class="list-group-item px-0 py-2 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 text-danger fw-bold"><?= $t['nama_kategori'] ?></h6>
                                <small class="text-muted"><?= date('d M Y', strtotime($t['jatuh_tempo'])) ?></small>
                            </div>
                            <p class="mb-1 small"><?= $t['keterangan'] ?></p>
                            <small class="fw-bold">Rp <?= number_format($t['nominal'], 0, ',', '.') ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?= $this->endSection() ?>