<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barang = $_POST['id_barang'];
    $jumlah_pakai = $_POST['jumlah_pakai'];
    
    // Cek data barang
    $sql = "SELECT * FROM tb_inventory WHERE id_barang = $id_barang";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Validasi jumlah pemakaian
        if ($jumlah_pakai <= 0) {
            header("Location: ../use_item.php?id=$id_barang&status=error&message=Jumlah pemakaian harus lebih dari 0");
            exit();
        }
        
        // Validasi stok cukup
        if ($jumlah_pakai > $row['jumlah_barang']) {
            header("Location: ../use_item.php?id=$id_barang&status=error&message=Stok tidak mencukupi untuk pemakaian sebanyak $jumlah_pakai {$row['satuan_barang']}");
            exit();
        }
        
        // Hitung stok baru
        $new_stock = $row['jumlah_barang'] - $jumlah_pakai;
        $status_barang = ($new_stock > 0) ? 1 : 0;
        
        // Update stok di database
        $update_sql = "UPDATE tb_inventory SET jumlah_barang = $new_stock, status_barang = $status_barang WHERE id_barang = $id_barang";
        
        if ($conn->query($update_sql) === TRUE) {
            header("Location: ../items.php?status=success&message=Berhasil menggunakan {$jumlah_pakai} {$row['satuan_barang']} {$row['nama_barang']}");
        } else {
            header("Location: ../use_item.php?id=$id_barang&status=error&message=Error: " . $conn->error);
        }
    } else {
        header("Location: ../items.php?status=error&message=Barang tidak ditemukan");
    }
} else {
    header("Location: ../items.php");
}

$conn->close();
?>