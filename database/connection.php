<?php
// $host = 'localhost'; // Ganti dengan host MySQL Anda
// $username = 'root'; // Ganti dengan username MySQL Anda
// $password = ''; // Ganti dengan password MySQL Anda
// $database = 'skripsi-aziz'; // Ganti dengan nama database Anda

// // Membuat koneksi
// $conn = new mysqli($host, $username, $password, $database);

// // Memeriksa koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// // Base URL Configuration
// $baseUrl = "http://localhost/skripsi-aziz/";

$hostname = "localhost";
$db_username = "ikiz5613_skripsi_aziz";
$db_password = "yongalah";
$db_name = "ikiz5613_skripsi-aziz";

// Membuat koneksi
$conn = new mysqli($hostname, $db_username, $db_password, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Base URL Configuration
$baseUrl = "https://asadulaziz.arbiet.my.id/";
