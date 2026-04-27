<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'E-Tebu' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #e9ecef; }
        .bg-success-light { background-color: #d1e7dd; color: #0f5132; }
        
        /* Desain Card & Tabel */
        .card-summary, .card-musim, .card-report, .table-wrapper { 
            background: #fff; border: none; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
        }
        .table-wrapper { padding: 20px; }
        
        /* Animasi Card Musim */
        .card-musim { transition: 0.3s; }
        .card-musim:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-3">
            <h4 class="text-success fw-bold mb-4">E-Tebu</h4>
            <ul class="nav flex-column">
                <?php $uri = service('uri')->getSegment(1); ?>
                
                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'dashboard' || $uri == '') ? 'fw-bold text-success' : 'text-secondary' ?>" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'musimtanam') ? 'fw-bold text-success' : 'text-secondary' ?>" href="/musimtanam">Daftar Musim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'transaksi') ? 'fw-bold text-success' : 'text-secondary' ?>" href="/transaksi">Buku Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'laporan') ? 'fw-bold text-success' : 'text-secondary' ?>" href="/laporan">Laporan</a>
                </li>
                <li class="nav-item mt-5">
                    <a class="nav-link text-danger" href="/logout">Keluar (Logout)</a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>