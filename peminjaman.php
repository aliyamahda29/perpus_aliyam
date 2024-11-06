<?php include('config.php'); ?>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Manajemen Peminjaman Buku</h2>

    <?php
    $id_peminjaman = '';
    $id_anggota = '';
    $id_buku = '';
    $tanggal_pinjam = '';
    $tanggal_kembali = '';

    // Cek jika ada parameter ID untuk edit
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $mysqli->query("SELECT * FROM peminjaman WHERE id_peminjaman=$id") or die($mysqli->error());
        if ($result->num_rows) {
            $row = $result->fetch_array();
            $id_peminjaman = $row['id_peminjaman'];
            $id_anggota = $row['id_anggota'];
            $id_buku = $row['id_buku'];
            $tanggal_pinjam = $row['tanggal_pinjam'];
            $tanggal_kembali = $row['tanggal_kembali'];
        }
    }

    // Proses simpan atau update peminjaman
    if (isset($_POST['save'])) {
        $id_peminjaman = $_POST['id_peminjaman'];
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tanggal_pinjam = $_POST['tanggal_pinjam'];
        $tanggal_kembali = $_POST['tanggal_kembali'];

        if ($id_peminjaman == '') {
            $mysqli->query("INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali) VALUES('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali')") or die($mysqli->error);
        } else {
            $mysqli->query("UPDATE peminjaman SET id_anggota='$id_anggota', id_buku='$id_buku', tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali' WHERE id_peminjaman=$id_peminjaman") or die($mysqli->error);
        }

        header('location: peminjaman.php');
    }

    // Proses hapus peminjaman
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $mysqli->query("DELETE FROM peminjaman WHERE id_peminjaman=$id") or die($mysqli->error());
        header('location: peminjaman.php');
    }
    ?>

    <form action="peminjaman.php" method="POST">
        <input type="hidden" name="id_peminjaman" value="<?php echo $id_peminjaman; ?>">

        <div class="mb-3">
            <label for="id_anggota" class="form-label">Anggota</label>
            <select name="id_anggota" class="form-select" required>
                <option value="">Pilih Anggota</option>
                <?php
                $result = $mysqli->query("SELECT * FROM anggota");
                while ($row = $result->fetch_assoc()) {
                    $selected = $row['id_anggota'] == $id_anggota ? 'selected' : '';
                    echo "<option value='{$row['id_anggota']}' $selected>{$row['nama_anggota']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_buku" class="form-label">Buku</label>
            <select name="id_buku" class="form-select" required>
                <option value="">Pilih Buku</option>
                <?php
                $result = $mysqli->query("SELECT * FROM buku");
                while ($row = $result->fetch_assoc()) {
                    $selected = $row['id_buku'] == $id_buku ? 'selected' : '';
                    echo "<option value='{$row['id_buku']}' $selected>{$row['judul_buku']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" class="form-control" name="tanggal_pinjam" value="<?php echo $tanggal_pinjam; ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" class="form-control" name="tanggal_kembali" value="<?php echo $tanggal_kembali; ?>" required>
        </div>

        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

    <!-- Tabel daftar peminjaman -->
    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $mysqli->query("SELECT peminjaman.*, anggota.nama_anggota, buku.judul_buku 
                                      FROM peminjaman 
                                      JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota 
                                      JOIN buku ON peminjaman.id_buku = buku.id_buku");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $row['id_peminjaman']; ?></td>
                <td><?php echo $row['nama_anggota']; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['tanggal_pinjam']; ?></td>
                <td><?php echo $row['tanggal_kembali']; ?></td>
                <td>
                    <a href="peminjaman.php?edit=<?php echo $row['id_peminjaman']; ?>" class="btn btn-warning">Edit</a>
                    <a href="peminjaman.php?delete=<?php echo $row['id_peminjaman']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
