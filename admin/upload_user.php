<?php
// JANGAN PROSES JIKA BELUM SUBMIT
if (!isset($_POST['submit'])) return;

require '../vendor/autoload.php';

$err = "";
$success = "";

$file_name = $_FILES['filexls']['name'];
$file_tmp  = $_FILES['filexls']['tmp_name'];

if (empty($file_name)) {
    $err .= "<li>Silakan pilih file Excel.</li>";
} else {
    $ekstensi = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($ekstensi, ['xls','xlsx'])) {
        $err .= "<li>File harus bertipe XLS atau XLSX.</li>";
    }
}

if (empty($err)) {

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_tmp);
    $spreadsheet = $reader->load($file_tmp);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    $jumlahData = 0;
    for ($i = 0; $i < count($sheetData); $i++) {

        $npp_user   = trim($sheetData[$i][1]);
        $nik_user   = trim($sheetData[$i][2]);
        $npwp_user  = trim($sheetData[$i][3]);
        $norek_user = trim($sheetData[$i][4]);
        $nama_user  = trim($sheetData[$i][5]);
        $nohp_user  = trim($sheetData[$i][6]);

        if ($npp_user == '' || !is_numeric($npp_user)) continue;

        $cek = mysqli_query($koneksi,
            "SELECT id_user FROM t_user WHERE npp_user='$npp_user'"
        );

        if (mysqli_num_rows($cek) > 0) continue;

        $role_user = 'staff';
        $pw_user = md5($npp_user);
        $honor_persks = 0;

        $insert = mysqli_query($koneksi, "
            INSERT INTO t_user
            (npp_user, nik_user, npwp_user, norek_user, nama_user, nohp_user, pw_user, role_user, honor_persks)
            VALUES
            ('$npp_user','$nik_user','$npwp_user','$norek_user','$nama_user','$nohp_user','$pw_user','$role_user','$honor_persks')
        ");

        if ($insert) $jumlahData++;
    }

    $success = "<li>Berhasil mengimport <b>$jumlahData</b> data user baru.</li>";
}

if ($err) {
    echo "<div class='alert alert-danger'><ul>$err</ul></div>";
}

if ($success) {
    echo "<div class='alert alert-success'><ul>$success</ul></div>";
}
