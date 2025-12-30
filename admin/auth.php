<?php
session_start();

if (!isset($_SESSION['status_user']) || $_SESSION['role_user'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

?>