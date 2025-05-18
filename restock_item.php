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
            <h1><i class="bi bi-cart-plus me-2"></i>Penambahan Stok Barang</h1>
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
                    <form action="actions/restock_item.php" method="post" class="restock-form">
                        <input type="hidden" name="id_barang" value="<?php echo $item['id_barang']; ?>">
                        
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
                                    <label class="form-label">Stok Saat Ini</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $item['jumlah_barang']; ?>" readonly>
                                        <span class="input-group-text"><?php echo $item['satuan_barang']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah_tambah" class="form-label">Jumlah Penambahan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="jumlah_tambah" name="jumlah_tambah" min="1" required>
                                        <span class="input-group-text"><?php echo $item['satuan_barang']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Stok
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select class="form-select" id="selectItem" onchange="redirectToRestockItem()">
                            <option value="" selected disabled>Pilih Barang</option>
                            <?php
                            $sql = "SELECT * FROM tb_inventory ORDER BY nama_barang ASC";
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
                        function redirectToRestockItem() {
                            var itemId = document.getElementById('selectItem').value;
                            if (itemId) {
                                window.location.href = 'restock_item.php?id=' + itemId;
                            }
                        }
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>