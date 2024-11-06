<?php include('config.php'); ?>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Manajemen Anggota</h2>
    
    <!-- Form tambah atau update anggota -->
    <?php
    $id_anggota = '';
    $nama_anggota = '';
    $alamat = '';
    $no_telp = '';
    $email = '';
    $tanggal_bergabung = '';

    // Cek jika ada parameter ID untuk edit
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $mysqli->query("SELECT * FROM anggota WHERE id_anggota=$id") or die($mysqli->error());
        if ($result->num_rows) {
            $row = $result->fetch_array();
            $id_anggota = $row['id_anggota'];
            $nama_anggota = $row['nama_anggota'];
            $alamat = $row['alamat'];
            $no_telp = $row['no_telp'];
            $email = $row['email'];
            $tanggal_bergabung = $row['tanggal_bergabung'];
        }
    }

    // Proses simpan atau update anggota
    if (isset($_POST['save'])) {
        $id_anggota = $_POST['id_anggota'];
        $nama_anggota = $_POST['nama_anggota'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $email = $_POST['email'];
        $tanggal_bergabung = $_POST['tanggal_bergabung'];

        if ($id_anggota == '') {
            $mysqli->query("INSERT INTO anggota (nama_anggota, alamat, no_telp, email, tanggal_bergabung) VALUES('$nama_anggota', '$alamat', '$no_telp', '$email', '$tanggal_bergabung')") or die($mysqli->error);
        } else {
            $mysqli->query("UPDATE anggota SET nama_anggota='$nama_anggota', alamat='$alamat', no_telp='$no_telp', email='$email', tanggal_bergabung='$tanggal_bergabung' WHERE id_anggota=$id_anggota") or die($mysqli->error);
        }
        
        header('location: anggota.php');
    }

    // Proses hapus anggota
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $mysqli->query("DELETE FROM anggota WHERE id_anggota=$id") or die($mysqli->error());
        header('location: anggota.php');
    }
    ?>

    <form action="anggota.php" method="POST">
        <input type="hidden" name="id_anggota" value="<?php echo $id_anggota; ?>">
        <div class="mb-3">
            <label for="nama_anggota" class="form-label">Nama Anggota</label>
            <input type="text" class="form-control" name="nama_anggota" value="<?php echo $nama_anggota; ?>" required>
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
        <div class="mb-3">
            <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
            <input type="date" class="form-control" name="tanggal_bergabung" value="<?php echo $tanggal_bergabung; ?>" required>
        </div>
        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

    <!-- Tabel daftar anggota -->
    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>ID Anggota</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Email</th>
                <th>Tanggal Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $mysqli->query("SELECT * FROM anggota");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $row['id_anggota']; ?></td>
                <td><?php echo $row['nama_anggota']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['tanggal_bergabung']; ?></td>
                <td>
                    <a href="anggota.php?edit=<?php echo $row['id_anggota']; ?>" class="btn btn-warning">Edit</a>
                    <a href="anggota.php?delete=<?php echo $row['id_anggota']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
