<?php
session_start();
include 'koneksi.php';

$npp_user= $_POST['npp_user'];
$pw_user= MD5($_POST['pw_user']);

$data= mysqli_query($koneksi, "select * from t_user where npp_user='$npp_user' 
and pw_user='$pw_user'");

$cek= mysqli_num_rows($data);
if($cek > 0){
    $row = mysqli_fetch_array($data);

$_SESSION['id_user']=$row['id_user'];
$_SESSION['npp_user']=$row['npp_user'];
$_SESSION['nik_user']=$row['nik_user'];
$_SESSION['npwp_user']=$row['npwp_user'];
$_SESSION['norek_user']=$row['norek_user'];
$_SESSION['nama_user']=$row['nama_user'];
$_SESSION['nohp_user']=$row['nohp_user'];
// $_SESSION['pw_user']=$row['pw_user'];
$_SESSION['role_user']=$row['role_user'];
$_SESSION['honor_persks']=$row['honor_persks'];
$_SESSION['status_user']="login";

if($_SESSION['role_user'] == 'admin'){
    header("location: admin/index.php");
}else if($_SESSION['role_user'] == 'koordinator'){
    header("location: koordinator/index.php");
}else if($_SESSION['role_user'] == 'staff'){
    header("location: staff/index.php");
}
}
// else{
//     header("location:login.php?pesan=gagal");
// }
?>
