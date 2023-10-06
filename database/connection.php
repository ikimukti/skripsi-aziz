<?php
$host = 'localhost'; // Ganti dengan host MySQL Anda
$username = 'root'; // Ganti dengan username MySQL Anda
$password = ''; // Ganti dengan password MySQL Anda
$database = 'skripsi-aziz'; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Base URL Configuration
$baseUrl = "http://localhost/skripsi-aziz/";
