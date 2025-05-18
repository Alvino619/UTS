<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barang = $_POST['id_barang'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan_barang = $_POST['satuan_barang'];
    $harga_beli = $_POST['harga_beli'];
    $status_barang = $_POST['status_barang'];
    
    // Validasi jumlah harus lebih dari 0 jika status available
    if ($status_barang == 1 && $jumlah_barang <= 0) {
        header("Location: ../items.php?status=error&message=Jumlah barang harus lebih dari 0 jika status Available");
        exit();
    }
    
    // Validasi jika jumlah 0, status harus not available
    if ($jumlah_barang == 0) {
        $status_barang = 0;
    }
    
    // Cek apakah kode barang sudah ada (selain barang yang sedang diedit)
    $check_sql = "SELECT * FROM tb_inventory WHERE kode_barang = '$kode_barang' AND id_barang != $id_barang";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        header("Location: ../items.php?status=error&message=Kode barang sudah ada di database");
        exit();
    }
    
    // Update data di database
    $sql = "UPDATE tb_inventory SET 
            kode_barang = '$kode_barang', 
            nama_barang = '$nama_barang', 
            jumlah_barang = $jumlah_barang, 
            satuan_barang = '$satuan_barang', 
            harga_beli = $harga_beli, 
            status_barang = $status_barang 
            WHERE id_barang = $id_barang";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../items.php?status=success&message=Barang berhasil diupdate");
    } else {
        header("Location: ../items.php?status=error&message=Error: " . $conn->error);
    }
} else {
    header("Location: ../items.php");
}

$conn->close();
?>