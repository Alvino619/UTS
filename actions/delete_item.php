<?php
include '../config/database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_barang = $_GET['id'];
    
    // Hapus data dari database
    $sql = "DELETE FROM tb_inventory WHERE id_barang = $id_barang";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../items.php?status=success&message=Barang berhasil dihapus");
    } else {
        header("Location: ../items.php?status=error&message=Error: " . $conn->error);
    }
} else {
    header("Location: ../items.php");
}

$conn->close();
?>