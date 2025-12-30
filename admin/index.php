<?php
include '../koneksi.php';
include 'auth.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div style="margin:auto;width:600px;padding:20px">
        <?php include 'uploadaksixls.php'; ?>
        <form action="" method="POST" enctype="multipart/form-data" class="row g-2">
            <div class="col-auto">
                <input type="file" class="form-control" name="filexls" id="formFile">
            </div>
            <div class="col-auto">
                <input type="submit" name="submit" class="btn btn-primary" value="Upload file XLX/XLSX">
            </div>
        </form>
    </div>

    <div class="col-auto">
        <a href="../logout.php" class="btn btn-primary">logout</a>
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>