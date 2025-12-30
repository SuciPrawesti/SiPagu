<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
// VALIDASI LOGIN & ROLE
if (!isset($_SESSION['status_user']) || $_SESSION['status_user'] != 'login') {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role_user'] != 'admin') {
    echo "<div class='alert alert-danger'>Akses ditolak. Hanya admin yang boleh import.</div>";
    exit;
}

require '../vendor/autoload.php';
include '../koneksi.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Excel User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
if (isset($_POST['submit'])) {

    $err = "";
    $success = "";

    $file_name = $_FILES['filexls']['name'];
    $file_tmp  = $_FILES['filexls']['tmp_name'];

    if (empty($file_name)) {
        $err .= "<li>Silakan pilih file Excel.</li>";
    } else {
        $ekstensi = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed  = ['xls', 'xlsx'];

        if (!in_array($ekstensi, $allowed)) {
            $err .= "<li>File harus bertipe XLS atau XLSX.</li>";
        }
    }

    if (empty($err)) {

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_tmp);
        $spreadsheet = $reader->load($file_tmp);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 0; $i < count($sheetData); $i++) {

            $npp_user   = trim($sheetData[$i][1]);
            $nik_user   = trim($sheetData[$i][2]);
            $npwp_user  = trim($sheetData[$i][3]);
            $norek_user = trim($sheetData[$i][4]);
            $nama_user  = trim($sheetData[$i][5]);
            $nohp_user  = trim($sheetData[$i][6]);

            // skip baris kosong
            if ($npp_user == '' || !is_numeric($npp_user)) {
            continue;
            }

            // CEK USER SUDAH ADA
            $cek = mysqli_query($koneksi, "
                SELECT id_user FROM t_user WHERE npp_user='$npp_user'
            ");

            if (mysqli_num_rows($cek) > 0) {
                continue; // user lama tidak diubah
            }

            // DEFAULT SISTEM
            $role_user = 'staff';
            $pw_user = md5($npp_user); // password awal = npp
            $honor_persks = 0;

            $insert = mysqli_query($koneksi, "
                INSERT INTO t_user
                (npp_user, nik_user, npwp_user, norek_user, nama_user, nohp_user, pw_user, role_user, honor_persks)
                VALUES
                ('$npp_user', '$nik_user', '$npwp_user', '$norek_user', '$nama_user', '$nohp_user', '$pw_user', '$role_user', '$honor_persks')
            ");

            if ($insert) {
                $jumlahData++;
            }
        }

        $success = "<li>Berhasil mengimport <b>$jumlahData</b> data user baru.</li>";
    }

    if ($err) {
        echo "<div class='alert alert-danger'><ul>$err</ul></div>";
    }

    if ($success) {
        echo "<div class='alert alert-success'><ul>$success</ul></div>";
    }
}
?>