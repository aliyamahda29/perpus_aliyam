<?php include('config.php'); ?>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Manajemen Buku</h2>

    <?php
    $id_buku = '';
    $judul_buku = '';
    $penulis = '';
    $penerbit = '';
    $tahun_terbit = '';
    $id_kategori = '';
    $jumlah = '';

    // Edit mode
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $mysqli->query("SELECT * FROM buku WHERE id_buku=$id") or die($mysqli->error());
        if ($result->num_rows) {
            $row = $result->fetch_array();
            $id_buku = $row['id_buku'];
            $judul_buku = $row['judul_buku'];
            $penulis = $row['penulis'];
            $penerbit = $row['penerbit'];
            $tahun_terbit = $row['tahun_terbit'];
            $id_kategori = $row['id_kategori'];
            $jumlah = $row['jumlah'];
        }
    }

    // Save book
    if (isset($_POST['save'])) {
        $id_buku = $_POST['id_buku'];
        $judul_buku = $_POST['judul_buku'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $id_kategori = $_POST['id_kategori'];
        $jumlah = $_POST['jumlah'];

        if ($id_buku == '') {
            $mysqli->query("INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit, id_kategori, jumlah) VALUES('$judul_buku', '$penulis', '$penerbit', '$tahun_terbit', '$id_kategori', '$jumlah')") or die($mysqli->error);
        } else {
            $mysqli->query("UPDATE buku SET judul_buku='$judul_buku', penulis='$penulis', penerbit='$penerbit', tahun_terbit='$tahun_terbit', id_kategori='$id_kategori', jumlah='$jumlah' WHERE id_buku=$id_buku") or die($mysqli->error);
        }

        header('location: buku.php');
    }

    // Delete book
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $mysqli->query("DELETE FROM buku WHERE id_buku=$id") or die($mysqli->error());
        header('location: buku.php');
    }
    ?>

    <form action="buku.php" method="POST">
        <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
        
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" name="judul_buku" value="<?php echo $judul_buku; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" name="penulis" value="<?php echo $penulis; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" name="penerbit" value="<?php echo $penerbit; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="text" class="form-control" name="tahun_terbit" value="<?php echo $tahun_terbit; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select" required>
                <option value="">Pilih Kategori</option>
                <?php
                $result = $mysqli->query("SELECT * FROM kategori");
                while ($row = $result->fetch_assoc()) {
                    $selected = $row['id_kategori'] == $id_kategori ? 'selected' : '';
                    echo "<option value='{$row['id_kategori']}' $selected>{$row['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="<?php echo $jumlah; ?>" required>
        </div>
        
        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

    <div class="container mt-5">
        <h2>Daftar Buku</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $mysqli->query("SELECT buku.*, kategori.nama_kategori 
                                          FROM buku 
                                          JOIN kategori ON buku.id_kategori = kategori.id_kategori");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_buku']}</td>
                            <td>{$row['judul_buku']}</td>
                            <td>{$row['penulis']}</td>
                            <td>{$row['penerbit']}</td>
                            <td>{$row['tahun_terbit']}</td>
                            <td>{$row['nama_kategori']}</td>
                            <td>{$row['jumlah']}</td>
                            <td>
                                <a href='buku.php?edit={$row['id_buku']}' class='btn btn-warning'>Edit</a>
                                <a href='buku.php?delete={$row['id_buku']}' class='btn btn-danger' onclick=\"return confirm('Yakin ingin menghapus buku ini?');\">Hapus</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
