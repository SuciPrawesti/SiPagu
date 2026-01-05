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

    // mulai dari baris 1 (0 = header)
    for ($i = 1; $i < count($sheetData); $i++) {

        $semester         = trim($sheetData[$i][1]);
        $id_panitia       = trim($sheetData[$i][2]);
        $id_user          = trim($sheetData[$i][3]);
        $jml_mhs_prodi    = trim($sheetData[$i][4]);
        $jml_mhs          = trim($sheetData[$i][5]);
        $jml_koreksi      = trim($sheetData[$i][6]);
        $jml_matkul       = trim($sheetData[$i][7]);
        $jml_pgws_pagi    = trim($sheetData[$i][8]);
        $jml_pgws_sore    = trim($sheetData[$i][9]);
        $jml_koor_pagi    = trim($sheetData[$i][10]);
        $jml_koor_sore    = trim($sheetData[$i][11]);

        if ($semester == '' || $id_panitia == '' || $id_user == '') continue;

        // cegah duplikat
        $cek = mysqli_query($koneksi, "
            SELECT id_tu FROM transaksi_ujian
            WHERE semester='$semester'
            AND id_panitia='$id_panitia'
            AND id_user='$id_user'
        ");

        if (mysqli_num_rows($cek) > 0) continue;

        $insert = mysqli_query($koneksi, "
            INSERT INTO transaksi_ujian
            (semester, id_panitia, id_user,
             jml_mhs_prodi, jml_mhs, jml_koreksi, jml_matkul,
             jml_pgws_pagi, jml_pgws_sore, jml_koor_pagi, jml_koor_sore)
            VALUES
            ('$semester', '$id_panitia', '$id_user',
             '$jml_mhs_prodi', '$jml_mhs', '$jml_koreksi', '$jml_matkul',
             '$jml_pgws_pagi', '$jml_pgws_sore', '$jml_koor_pagi', '$jml_koor_sore')
        ");

        if ($insert) $jumlahData++;
    }

    $success = "<li>Berhasil mengimport <b>$jumlahData</b> data transaksi ujian baru.</li>";
}

if ($err) {
    echo "<div class='alert alert-danger'><ul>$err</ul></div>";
}

if ($success) {
    echo "<div class='alert alert-success'><ul>$success</ul></div>";
}
