<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<h2 class="mb-4">Laporan Laba Rugi & Breakdown Biaya</h2>

<?php if(!$musimAktif): ?>
    <div class="alert alert-warning">Belum ada musim tanam yang aktif. Laporan tidak dapat ditampilkan.</div>
<?php else: ?>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-report p-4 h-100">
                <h5 class="border-bottom pb-3 mb-3">Rekapitulasi Keuangan: <?= $musimAktif['nama_musim'] ?></h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="text-muted">Total Pendapatan</td>
                            <td class="text-end fw-bold text-success">Rp <?= number_format($pemasukan, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">(-) Total Biaya Produksi <em>(Full Costing)</em></td>
                            <td class="text-end fw-bold text-danger">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></td>
                        </tr>
                        <tr class="border-top">
                            <td class="fs-5 fw-bold">Laba Bersih</td>
                            <td class="text-end fs-5 fw-bold <?= $labaBersih >= 0 ? 'text-success' : 'text-danger' ?>">
                                Rp <?= number_format($labaBersih, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4 p-3 bg-light rounded">
                    [cite_start]<small class="text-muted d-block mb-1">Metode Full Costing[cite: 829]:</small>
                    <span class="fw-bold">HPP per Ton = Rp <?= number_format($totalBiaya, 0, ',', '.') ?> / (Total Output)</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-report p-4 h-100 d-flex flex-column align-items-center">
                <h6 class="text-center mb-3">Breakdown Biaya Produksi</h6>
                <div style="position: relative; height:200px; width:200px;">
                    <canvas id="biayaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const ctx = document.getElementById('biayaChart');
    if(ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Biaya Tetap', 'Biaya Variabel'],
                datasets: [{
                    data: [<?= $biayaTetap ?>, <?= $biayaVariabel ?>],
                    backgroundColor: ['#0dcaf0', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
</script>
<?= $this->endSection() ?>