<?php include('config.php'); ?>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Manajemen Kategori</h2>

    <?php
    $id_buku = '';
    $nama_kategori = '';
    $jumlah = '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $mysqli->query("SELECT * FROM kategori WHERE id_kategori=$id") or die($mysqli->error());
        if ($result->num_rows) {
            $row = $result->fetch_array();
            $id_kategori = $row['id_kategori'];
            $nama_kategori = $row['nama_kategori'];
            $jumlah = $row['jumlah'];
        }
    }

    if (isset($_POST['save'])) {
        $id_kategori = $_POST['id_kategori'];
        $nama_kategori = $_POST['nama_kategori'];
        $jumlah = $_POST['jumlah'];

        if ($id_petugas == '') {
            $mysqli->query("INSERT INTO kategori (nama_kategori, jumlah) VALUES('$nama_kategori', '$jumlah')") or die($mysqli->error);
        } else {
            $mysqli->query("UPDATE kategori SET nama_kategori='$nama_kategori' jumlah='$jumlah' WHERE id_kategori=$id_kategori") or die($mysqli->error);
        }

        header('location: kategori.php');
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $mysqli->query("DELETE FROM kategori WHERE id_kategori=$id") or die($mysqli->error());
        header('location: kategori.php');
    }
    ?>

    <form action="kategori.php" method="POST">
        <input type="hidden" name="id_kategori" value="<?php echo $id_kategori; ?>">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Kategori buku</label>
            <input type="text" class="form-control" name="nama_kategori" value="<?php echo $nama_kategori; ?>" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="text" class="form-control" name="jumlah" value="<?php echo $jumlah; ?>" required>
        </div>
        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

<div class="container mt-5">
    <h2>Daftar Kategori Buku</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $mysqli->query("SELECT * FROM kategori");
            while ($row = $result->fetch_assoc())
            ?>
            <tr>
                <td><?php echo $row['id_kategori']; ?></td>
                <td><?php echo $row['nama_kategori']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
                <td>
                    <a href="kategori.php?edit=<?php echo $row['id_kategori']; ?>" class="btn btn-warning">Edit</a>
                    <a href="kategori.php?delete=<?php echo $row['id_kategori']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
