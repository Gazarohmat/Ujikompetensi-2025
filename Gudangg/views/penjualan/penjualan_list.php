<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Penjualan</h1>
        
        <!-- Tombol Tambah Penjualan -->
        <div class="mb-3 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPenjualanModal">Tambah Penjualan</button>
        </div>

        <!-- Tabel Daftar Penjualan -->
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>Tanggal Penjualan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Kuantitas</th>
                    <th>Total Pembayaran</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $no= 1; ?>
                <?php foreach ($penjualanList as $penjualan): ?>
                <tr>
                <td><?= $no++?></td>
                    <td><?= $penjualan['TanggalPenjualan']; ?></td>
                    <td><?= $penjualan['PelangganNama']; ?></td>
                    <td>
                        <?php 
                        echo !empty($penjualan['NamaProduk']) ? $penjualan['NamaProduk'] : 'Tidak ada produk';
                        ?>
                    </td>
                    <td><?= $penjualan['Stok']?></td>
                    <td><?= $penjualan['Kuantitas']; ?></td>
                    <td>Rp <?= number_format($penjualan['TotalPembayaran'], 2, ',', '.'); ?></td>
                    <td><?= $penjualan['MetodePembayaran']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Penjualan -->
    <div class="modal fade" id="tambahPenjualanModal" tabindex="-1" aria-labelledby="tambahPenjualanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPenjualanModalLabel">Tambah Penjualan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?action=penjualan_tambah" method="POST">
                        <div class="mb-3">
                            <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                            <input type="date" class="form-control" id="tanggal_penjualan" name="TanggalPenjualan" required>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pelanggan</label>
                            <select class="form-select" id="pelanggan_id" name="PelangganID" required>
                                <option value="" disabled selected>Pilih Pelanggan</option>
                                <?php foreach ($pelangganList as $pelanggan): ?>
                                    <option value="<?= $pelanggan['PelangganID']; ?>"><?= $pelanggan['Nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="produk_id" class="form-label">Produk</label>
                            <select class="form-select" id="produk_id" name="ProdukID" required>
                                <option value="" disabled selected>Pilih Produk</option>
                                <?php foreach ($produkList as $produk): ?>
                                    <option value="<?= $produk['ProdukID']; ?>" data-price="<?= $produk['HargaSatuan']; ?>" data-stock="<?= $produk['Stok']; ?>">
                                        <?= $produk['NamaProduk']; ?> - Rp <?= number_format($produk['HargaSatuan'], 0, ',', '.'); ?> - Stok: <?= $produk['Stok']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="kuantitas" class="form-label">Kuantitas</label>
                                <input type="number" class="form-control" id="kuantitas" name="Kuantitas" value="1" min="1" required>
                            </div>
                            <div class="col">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="text" class="form-control" id="stok" value="0" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control" id="total_pembayaran" name="TotalPembayaran" value="0" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <input type="text" class="form-control" id="metode_pembayaran" name="MetodePembayaran" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Penjualan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk menghitung total pembayaran dan stok produk
        function updateTotalPayment() {
            var selectedOption = document.getElementById('produk_id').options[document.getElementById('produk_id').selectedIndex];
            var price = parseFloat(selectedOption.getAttribute('data-price'));
            var stock = parseInt(selectedOption.getAttribute('data-stock'));
            var quantity = document.getElementById('kuantitas').value;

            // Update stok produk di sebelah kuantitas
            document.getElementById('stok').value = stock;

            // Validasi kuantitas tidak melebihi stok
            if (quantity > stock) {
                alert("Jumlah kuantitas melebihi stok yang tersedia!");
                document.getElementById('kuantitas').value = stock;
                quantity = stock;
            }

            // Update total pembayaran
            var totalPayment = price * quantity;
            document.getElementById('total_pembayaran').value = totalPayment.toFixed(2);
        }

        // Event listener untuk modal tambah penjualan
        document.getElementById('tambahPenjualanModal').addEventListener('shown.bs.modal', function () {
            updateTotalPayment();
            document.getElementById('produk_id').addEventListener('change', updateTotalPayment);
            document.getElementById('kuantitas').addEventListener('input', updateTotalPayment);
        });
    </script>
</body>
</html>
