<?php include('config.php'); ?>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Manajemen Petugas</h2>

    <?php
    $id_petugas = '';
    $nama_petugas = '';
    $alamat = '';
    $no_telp = '';
    $email = '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $mysqli->query("SELECT * FROM petugas WHERE id_petugas=$id") or die($mysqli->error());
        if ($result->num_rows) {
            $row = $result->fetch_array();
            $id_petugas = $row['id_petugas'];
            $nama_petugas = $row['nama_petugas'];
            $alamat = $row['alamat'];
            $no_telp = $row['no_telp'];
            $email = $row['email'];
        }
    }

    if (isset($_POST['save'])) {
        $id_petugas = $_POST['id_petugas'];
        $nama_petugas = $_POST['nama_petugas'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $email = $_POST['email'];

        if ($id_petugas == '') {
            $mysqli->query("INSERT INTO petugas (nama_petugas, alamat, no_telp, email) VALUES('$nama_petugas', '$alamat', '$no_telp', '$email')") or die($mysqli->error);
        } else {
            $mysqli->query("UPDATE petugas SET nama_petugas='$nama_petugas', alamat='$alamat', no_telp='$no_telp', email='$email' WHERE id_petugas=$id_petugas") or die($mysqli->error);
        }

        header('location: petugas.php');
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $mysqli->query("DELETE FROM petugas WHERE id_petugas=$id") or die($mysqli->error());
        header('location: petugas.php');
    }
    ?>

    <form action="petugas.php" method="POST">
        <input type="hidden" name="id_petugas" value="<?php echo $id_petugas; ?>">
        <div class="mb-3">
            <label for="nama_petugas" class="form-label">Nama Petugas</label>
            <input type="text" class="form-control" name="nama_petugas" value="<?php echo $nama_petugas; ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" value="<?php echo $alamat; ?>" required>
        </div>
        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telp</label>
            <input type="text" class="form-control" name="no_telp" value="<?php echo $no_telp; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>
        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>ID Petugas</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $mysqli->query("SELECT * FROM petugas");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $row['id_petugas']; ?></td>
                <td><?php echo $row['nama_petugas']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="petugas.php?edit=<?php echo $row['id_petugas']; ?>" class="btn btn-warning">Edit</a>
                    <a href="petugas.php?delete=<?php echo $row['id_petugas']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
