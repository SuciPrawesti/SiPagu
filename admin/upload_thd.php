<?php
// JANGAN JALAN JIKA BELUM SUBMIT
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

    // mulai dari baris 1 (baris 0 = header)
    for ($i = 1; $i < count($sheetData); $i++) {

        $semester   = trim($sheetData[$i][1]);
        $bulan      = trim($sheetData[$i][2]);
        $jml_tm     = trim($sheetData[$i][3]);
        $sks_tempuh = trim($sheetData[$i][4]);

        // skip baris kosong
        if ($semester == '' || $bulan == '') continue;

        // OPTIONAL: cegah duplikat jadwal
        $cek = mysqli_query($koneksi, "
            SELECT id_jadwal FROM t_jadwal
            WHERE semester='$semester'
            AND bulan='$bulan'
        ");

        if (mysqli_num_rows($cek) > 0) continue;

        $insert = mysqli_query($koneksi, "
            INSERT INTO t_jadwal
            (semester, bulan, jml_tm, sks_tempuh)
            VALUES
            ('$semester', '$bulan', '$jml_tm', '$sks_tempuh')
        ");

        if ($insert) $jumlahData++;
    }

    $success = "<li>Berhasil mengimport <b>$jumlahData</b> data jadwal baru.</li>";
}

if ($err) {
    echo "<div class='alert alert-danger'><ul>$err</ul></div>";
}

if ($success) {
    echo "<div class='alert alert-success'><ul>$success</ul></div>";
}
