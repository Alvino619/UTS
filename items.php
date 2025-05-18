<?php
include 'config/database.php';
include 'includes/header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-boxes me-2"></i>Data Inventory Barang</h1>
            <a href="add_item.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Tambah Barang
            </a>
        </div>
        
        <?php
        // Menampilkan pesan sukses atau error
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
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $sql = "SELECT * FROM tb_inventory ORDER BY id_barang DESC";
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    $no = 1;
                                    while($row = $result->fetch_assoc()) {
                                        $status = $row['status_barang'] ? 
                                            '<span class="badge bg-success">Available</span>' : 
                                            '<span class="badge bg-danger">Not Available</span>';
                                        echo '<tr>
                                            <td>'.$no.'</td>
                                            <td>'.htmlspecialchars($row['kode_barang']).'</td>
                                            <td>'.htmlspecialchars($row['nama_barang']).'</td>
                                            <td>'.htmlspecialchars($row['jumlah_barang']).'</td>
                                            <td>'.htmlspecialchars($row['satuan_barang']).'</td>
                                            <td>Rp '.number_format($row['harga_beli'], 0, ',', '.').'</td>
                                            <td>'.$status.'</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="edit_item.php?id='.$row['id_barang'].'" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row['id_barang'].'" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <a href="use_item.php?id='.$row['id_barang'].'" class="btn btn-sm btn-info" title="Pakai">
                                                        <i class="bi bi-cart-dash"></i>
                                                    </a>
                                                    <a href="restock_item.php?id='.$row['id_barang'].'" class="btn btn-sm btn-success" title="Tambah">
                                                        <i class="bi bi-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>';
                                        $no++;
                                    }
                                } else {
                                    echo '<tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data barang</td></tr>';
                                }
                            } catch (Exception $e) {
                                echo '<tr><td colspan="8" class="text-center text-danger py-4">Error: '.htmlspecialchars($e->getMessage()).'</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Cek apakah DataTable sudah diinisialisasi
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            },
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting for action column
            ]
        });
    }

    // Delete confirmation dengan SweetAlert
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var itemId = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'actions/delete_item.php?id=' + itemId;
            }
        });
    });
});
</script>