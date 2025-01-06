<?php
// Mengimpor file koneksi ke database
require_once 'koneksi.php';

// Memeriksa apakah permintaan HTTP adalah metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form yang dikirim melalui POST, dengan nilai default kosong jika tidak ada
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $nama_lengkap = $_POST["nama_lengkap"] ?? '';
    $email = $_POST["email"] ?? '';
    $no_telp = $_POST["no_telp"] ?? '';
    $alamat = $_POST["alamat"] ?? '';
    
    // Memvalidasi bahwa username dan password wajib diisi
    if (empty($username) || empty($password)) {
        // Menyimpan pesan error di session dan mengarahkan kembali ke halaman utama
        $_SESSION['error'] = "Username dan password harus diisi!";
        header("Location: index.php");
        exit();
    }
    
    try {
        // Mengecek apakah username sudah terdaftar di database
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM pembeli WHERE username = ?");
        if (!$check_stmt) {
            // Jika query gagal disiapkan, melemparkan exception
            throw new Exception("Gagal memeriksa username");
        }
        
        // Mengikat parameter username ke statement dan mengeksekusi query
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        // Memeriksa apakah username sudah ada di database
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            // Jika username sudah terdaftar, menyimpan pesan error dan mengarah
