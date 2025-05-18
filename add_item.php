<?php
include 'config/database.php';
include 'includes/header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-plus-circle me-2"></i>Tambah Barang Baru</h1>
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
                <form action="actions/add_item.php" method="post" class="item-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang / Barcode</label>
                                <input type="text" class="form-control" id="kode_barang" name="kode_barang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="satuan_barang" class="form-label">Satuan Barang</label>
                                <select class="form-select" id="satuan_barang" name="satuan_barang" required>
                                    <option value="" selected disabled>Pilih Satuan</option>
                                    <option value="kg">kg</option>
                                    <option value="pcs">pcs</option>
                                    <option value="liter">liter</option>
                                    <option value="meter">meter</option>
                                    <option value="box">box</option>
                                    <option value="pack">pack</option>
                                    <option value="lusin">lusin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" min="0" step="0.01" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Barang</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_barang" id="status_available" value="1" checked>
                                    <label class="form-check-label" for="status_available">
                                        <span class="badge bg-success">Available</span>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_barang" id="status_not_available" value="0">
                                    <label class="form-check-label" for="status_not_available">
                                        <span class="badge bg-danger">Not Available</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>