<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Tebu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .login-container { max-width: 400px; margin-top: 100px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-success { background-color: #28a745; border: none; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-container w-100">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">E-Tebu</h3>
                <p class="text-muted">Manajemen Keuangan Tebu</p>
            </div>

            <?php if(session()->getFlashdata('error')):?>
                <div class="alert alert-danger text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif;?>

            <form action="/auth/proses_login" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2">Masuk Aplikasi</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>