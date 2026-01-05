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

    // mulai dari baris 1 (0 = header)
    for ($i = 1; $i < count($sheetData); $i++) {

        $jbtn_pnt  = trim($sheetData[$i][1]);
        $honor_std = trim($sheetData[$i][2]);
        $honor_p1  = trim($sheetData[$i][3]);
        $honor_p2  = trim($sheetData[$i][4]);

        // skip baris kosong
        if ($jbtn_pnt == '' || $honor_p1 == '' || $honor_p2 == '') continue;

        // cegah duplikat (pakai jabatan)
        $cek = mysqli_query($koneksi, "
            SELECT id_pnt 
            FROM t_pnt 
            WHERE jbtn_pnt='$jbtn_pnt'
        ");

        if (mysqli_num_rows($cek) > 0) continue;

        $insert = mysqli_query($koneksi, "
            INSERT INTO t_pnt
            (jbtn_pnt, honor_std, honor_p1, honor_p2)
            VALUES
            ('$jbtn_pnt', '$honor_std', '$honor_p1', '$honor_p2')
        ");

        if ($insert) $jumlahData++;
    }

    $success = "<li>Berhasil mengimport <b>$jumlahData</b> data panitia baru.</li>";
}

if ($err) {
    echo "<div class='alert alert-danger'><ul>$err</ul></div>";
}

if ($success) {
    echo "<div class='alert alert-success'><ul>$success</ul></div>";
}
