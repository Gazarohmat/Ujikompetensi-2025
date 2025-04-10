<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Pelanggan</h1>
        
        <!-- Tombol Tambah Pelanggan -->
        <div class="mb-3 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPelangganModal">Tambah Pelanggan</button>
        </div>

        <!-- Tabel Daftar Pelanggan -->
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no= 1; ?>
                <?php foreach ($pelangganList as $pelanggan): ?>
                <tr>
                <td><?= $no++?></td>
                    <td><?= $pelanggan['Nama']; ?></td>
                    <td><?= $pelanggan['Alamat']; ?></td>
                    <td><?= $pelanggan['Telepon']; ?></td>
                    <td><?= $pelanggan['Email']; ?></td>
                    <td>
                        <!-- Tombol Ubah -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahPelangganModal<?= $pelanggan['PelangganID']; ?>">Ubah</button> 

                        <!-- Modal Ubah -->
                        <div class="modal fade" id="ubahPelangganModal<?= $pelanggan['PelangganID']; ?>" tabindex="-1" aria-labelledby="ubahPelangganModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ubahPelangganModalLabel">Ubah Pelanggan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php?action=pelanggan_update&id=<?= $pelanggan['PelangganID']; ?>" method="POST">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="Nama" value="<?= $pelanggan['Nama']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="Alamat" value="<?= $pelanggan['Alamat']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telepon" class="form-label">Telepon</label>
                                                <input type="text" class="form-control" id="telepon" name="Telepon" value="<?= $pelanggan['Telepon']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="Email" value="<?= $pelanggan['Email']; ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <a href="index.php?action=pelanggan_destroy&id=<?= $pelanggan['PelangganID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="tambahPelangganModal" tabindex="-1" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?action=pelanggan_store" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="Nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="Alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="Telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="Email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Pelanggan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
