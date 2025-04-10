<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Produk</h1>
        
        <div class="mb-3 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Produk</button>
        </div>

        <!-- Tabel Daftar Produk -->
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Satuan</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Gambar Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                
                <?php $no= 1; ?>
                <?php foreach ($produk as $p): ?>

                <tr>
                    <td><?= $no++?></td>
                    <td><?= $p['NamaProduk']; ?></td>
                    <td>Rp <?= number_format($p['HargaSatuan'], 2, ',', '.'); ?></td>
                    <td><?= $p['Kategori']; ?></td>
                    <td><?= $p['Stok']; ?></td>
                    <td>
    <?php if (!empty($p['Gambar_Produk'])): ?>
        <img src="uploads/<?= $p['Gambar_Produk']; ?>" alt="Gambar Produk" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
    <?php else: ?>
        <p>No Image</p>
    <?php endif; ?>
</td>
                    <td>
                        <!-- Tombol Ubah -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahModal<?= $p['ProdukID']; ?>">Ubah</button>
                        
                        <!-- Modal Ubah -->
                        <div class="modal fade" id="ubahModal<?= $p['ProdukID']; ?>" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ubahModalLabel">Ubah Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php?action=ubah&id=<?= $p['ProdukID']; ?>" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="NamaProduk" value="<?= $p['NamaProduk']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                                <input type="number" class="form-control" id="harga_satuan" name="HargaSatuan" value="<?= $p['HargaSatuan']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <input type="text" class="form-control" id="kategori" name="Kategori" value="<?= $p['Kategori']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Stok</label>
                                                <input type="number" class="form-control" id="stok" name="Stok" value="<?= $p['Stok']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                                <input type="file" class="form-control" id="gambar_produk" name="Gambar_Produk">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <a href="index.php?action=hapus&id=<?= $p['ProdukID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?action=tambah" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="NamaProduk" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control" id="harga_satuan" name="HargaSatuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="Kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="Stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar_produk" name="Gambar_Produk" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>