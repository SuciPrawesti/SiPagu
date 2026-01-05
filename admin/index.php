<?php
include '../koneksi.php';
include 'auth.php';

$page = $_GET['page'] ?? 'user';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Excel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4" style="max-width:700px">

    <h4 class="mb-3">Upload Excel</h4>

    <!-- MENU PILIH TABEL -->
    <div class="mb-3">
        <a href="?page=user" class="btn btn-outline-primary">User</a>
        <a href="?page=jadwal" class="btn btn-outline-primary">Jadwal</a>
        <a href="?page=panitia" class="btn btn-outline-primary">Panitia</a>
        <a href="?page=tu" class="btn btn-outline-primary">TU</a>
        <a href="?page=thd" class="btn btn-outline-primary">THD</a>
        <a href="?page=tpata" class="btn btn-outline-primary">TPATA</a>
    </div>

    <!-- FORM UPLOAD (SATU SAJA) -->
    <form method="POST" enctype="multipart/form-data" class="row g-2 mb-3">
        <div class="col-8">
            <input type="file" name="filexls" class="form-control" required>
        </div>
        <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary w-100">
                Upload XLS/XLSX
            </button>
        </div>
    </form>

    <!-- HASIL PROSES -->
    <?php
    if ($page === 'user')        include 'upload_user.php';
    elseif ($page === 'jadwal') include 'upload_jadwal.php';
    elseif ($page === 'panitia')include 'upload_panitia.php';
    elseif ($page === 'tu')     include 'upload_tu.php';
    elseif ($page === 'thd')    include 'upload_thd.php';
    elseif ($page === 'tpata')  include 'upload_tpata.php';
    ?>

    <hr>
    <a href="../logout.php" class="btn btn-danger">Logout</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
