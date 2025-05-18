<?php
include 'config/database.php';
include 'includes/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tb_inventory WHERE id_barang = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        header("Location: items.php?status=error&message=Barang tidak ditemukan");
        exit();
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-cart-dash me-2"></i>Pemakaian Barang</h1>
            <a href="items.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        
        <?php
        if (isset($_GET['status'])) {
            $alert_type = $_GET['status'] == 'success' ? 'success' : 'danger';
            $message = $_GET['message'] ?? '';
            
            if (!empty($message)) {
                echo '<div class="alert alert-'.$alert_type.' alert-dismissible fade show" role="alert">
                        <strong>'.($alert_type == 'success' ? 'Berhasil!' : 'Gagal!').'</strong> '.htmlspecialchars($message).'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        }
        ?>
        
        <div class="card shadow">
            <div class="card-body">
                <?php if (isset($item)): ?>
                    <form action="actions/use_item.php" method="post" class="use-form">
                        <input type="hidden" name="id_barang" value="<?php echo $item['id_barang']; ?>">
                        <input type="hidden" id="stok_tersedia" value="<?php echo $item['jumlah_barang']; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kode Barang</label>
                                    <input type="text" class="form-control" value="<?php echo $item['kode_barang']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" value="<?php echo $item['nama_barang']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stok Tersedia</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $item['jumlah_barang']; ?>" readonly>
                                        <span class="input-group-text"><?php echo $item['satuan_barang']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah_pakai" class="form-label">Jumlah Pemakaian</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="jumlah_pakai" name="jumlah_pakai" min="1" max="<?php echo $item['jumlah_barang']; ?>" required <?php echo ($item['jumlah_barang'] <= 0 || $item['status_barang'] == 0) ? 'disabled' : ''; ?>>
                                        <span class="input-group-text"><?php echo $item['satuan_barang']; ?></span>
                                    </div>
                                    <?php if ($item['jumlah_barang'] <= 0 || $item['status_barang'] == 0): ?>
                                        <div class="form-text text-danger">Barang tidak tersedia untuk digunakan</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary" <?php echo ($item['jumlah_barang'] <= 0 || $item['status_barang'] == 0) ? 'disabled' : ''; ?>>
                                <i class="bi bi-check-circle me-1"></i>Gunakan Barang
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select class="form-select" id="selectItem" onchange="redirectToUseItem()">
                            <option value="" selected disabled>Pilih Barang</option>
                            <?php
                            $sql = "SELECT * FROM tb_inventory WHERE jumlah_barang > 0 AND status_barang = 1 ORDER BY nama_barang ASC";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="'.$row['id_barang'].'">'.$row['nama_barang'].' ('.$row['jumlah_barang'].' '.$row['satuan_barang'].')</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <script>
                        function redirectToUseItem() {
                            var itemId = document.getElementById('selectItem').value;
                            if (itemId) {
                                window.location.href = 'use_item.php?id=' + itemId;
                            }
                        }
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>