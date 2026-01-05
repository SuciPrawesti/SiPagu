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
    if (!in_array($ekstensi, ['xls', 'xlsx'])) {
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

        $semester            = trim($sheetData[$i][1]);
        $periode_wisuda      = trim($sheetData[$i][2]);
        $id_user             = trim($sheetData[$i][3]);
        $prodi               = trim($sheetData[$i][4]);
        $jml_mhs_prodi       = trim($sheetData[$i][5]);
        $jml_mhs_bimbingan   = trim($sheetData[$i][6]);
        $jml_pgji_1          = trim($sheetData[$i][7]);
        $jml_pgji_2          = trim($sheetData[$i][8]);
        $ketua_pgji          = trim($sheetData[$i][9]);

        // skip baris kosong
        if ($semester == '' || $id_user == '') continue;

        // OPTIONAL: cegah duplikat
        $cek = mysqli_query($koneksi, "
            SELECT id_panitia FROM t_panitia
            WHERE semester='$semester'
            AND id_user='$id_user'
            AND prodi='$prodi'
        ");

        if (mysqli_num_rows($cek) > 0) continue;

        $insert = mysqli_query($koneksi, "
            INSERT INTO t_panitia
            (semester, periode_wisuda, id_user, prodi,
             jml_mhs_prodi, jml_mhs_bimbingan,
             jml_pgji_1, jml_pgji_2, ketua_pgji)
            VALUES
            ('$semester', '$periode_wisuda', '$id_user', '$prodi',
             '$jml_mhs_prodi', '$jml_mhs_bimbingan',
             '$jml_pgji_1', '$jml_pgji_2', '$ketua_pgji')
        ");

        if ($insert) $jumlahData++;
    }

    $success = "<li>Berhasil mengimport <b>$jumlahData</b> data panitia PA/TA baru.</li>";
}

if ($err) {
    echo "<div class='alert alert-danger'><ul>$err</ul></div>";
}

if ($success) {
    echo "<div class='alert alert-success'><ul>$success</ul></div>";
}
