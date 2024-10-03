<?php
session_start();
header('Content-Type: application/json'); // Mengatur header untuk JSON

// Koneksi ke database
$conn = new mysqli("localhost", "username_db", "password_db", "nama_database");

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

// Pastikan sesi pengguna telah dimulai
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Ambil data pengguna dari database
    $sql = "SELECT name, email, phone, address, bio FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row); // Mengembalikan data sebagai JSON
    } else {
        echo json_encode(["error" => "Data tidak ditemukan."]);
    }
} else {
    echo json_encode(["error" => "User not logged in."]);
}

$conn->close();
?>
