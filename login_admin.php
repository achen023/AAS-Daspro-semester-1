<?php
// Mengimpor file koneksi ke database
require 'koneksi.php';

// Mengambil nilai username dan password dari form yang dikirim melalui POST
$username = $_POST["username"];
$password = $_POST["password"];

// Menyiapkan query SQL untuk memeriksa kecocokan username dan password
$query_sql = "SELECT * FROM admin_data WHERE username = ? AND password = ?";
// Mempersiapkan statement SQL dengan koneksi yang sudah dibuat
$stmt = mysqli_prepare($conn, $query_sql);

// Memeriksa apakah persiapan statement berhasil
if ($stmt) {
    // Mengikat parameter username dan password ke statement SQL
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    
    // Menjalankan query yang sudah dipersiapkan
    mysqli_stmt_execute($stmt);
    
    // Mendapatkan hasil query yang dieksekusi
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa apakah ada baris yang dikembalikan (artinya login berhasil)
    if (mysqli_num_rows($result) > 0) {
        // Jika login berhasil, redirect ke halaman dashboard admin
        header("Location: /dashboard-admin/");
        exit();  // Menghentikan eksekusi lebih lanjut
    } else {
        // Jika login gagal (username atau password salah)
        echo "Login Gagal: Username atau Password salah.";
    }

    // Menutup statement SQL setelah selesai digunakan
    mysqli_stmt_close($stmt);
} else {
    // Menampilkan pesan kesalahan jika terjadi masalah pada persiapan query
    echo "Terjadi kesalahan pada query.";
}

// Menutup koneksi database
mysqli_close($conn);
?>
