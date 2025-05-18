$(document).ready(function() {
    // Inisialisasi DataTables
    $('#dataTable').DataTable();
    
    // Konfirmasi sebelum menghapus data
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
            window.location.href = 'actions/delete_item.php?id=' + id;
        }
    });
    
    // Validasi form penambahan dan penggunaan barang
    $('.item-form').on('submit', function(e) {
        const jumlah = parseInt($('#jumlah_barang').val());
        
        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah barang harus lebih dari 0!');
        }
    });
    
    // Validasi form penggunaan barang
    $('.use-form').on('submit', function(e) {
        const jumlah = parseInt($('#jumlah_pakai').val());
        const stok = parseInt($('#stok_tersedia').val());
        
        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah pemakaian harus lebih dari 0!');
        } else if (jumlah > stok) {
            e.preventDefault();
            alert('Jumlah pemakaian tidak boleh melebihi stok yang tersedia!');
        }
    });
});