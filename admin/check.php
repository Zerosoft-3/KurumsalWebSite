<?php

session_start();

include '../config.php';
$query = new Database();

// Kullanıcı oturum açmamışsa veya oturum geçersizse giriş sayfasına yönlendir
if (!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // login/ yerine login.php olarak güncellendi
    exit;
}
