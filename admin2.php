<!doctype html>
<html lang="en">

<head>
    <style>
        .mx-auto {
            width: 1500px
        }

        .card {
            margin-top: 10px
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <nav class="navbar navbar-expand-lg bg-info  ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admin1.php">Data Buku</a></li>
                            <li><a class="dropdown-item" href="admin2.php">Data Penerbit</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengadaan.php">Pengadaan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- PHP -->
    <?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "unibookstore";

    $koneksi = mysqli_connect($host, $user, $pass, $db);
    if (!$koneksi) {
        die("Tidak bisa Terkoneksi");
    }

    $idpenerbit = "";
    $namapenerbit = "";
    $alamat = "";
    $kota = "";
    $telepon = "";
    $sukses = "";
    $error = "";

    if (isset($_GET['op'])) {
        $op = $_GET['op'];
    } else {
        $op = "";
    }

    if ($op == 'edit') {
        $idpenerbit = $_GET['id_penerbit'];
        $sql1 = "SELECT * from penerbit WHERE id_penerbit = '$idpenerbit'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1 && mysqli_num_rows($q1) > 0) {
        $r1 = mysqli_fetch_array($q1);
        $idpenerbit = $r1['id_penerbit'];
        $namapenerbit = $r1['nama'];
        $alamat = $r1['alamat'];
        $kota = $r1['kota'];
        $telepon = $r1['telepon'];
        }
    }

    if ($op == 'del') {
        $idpenerbit = $_GET['id_penerbit'];
        $sql1 = "DELETE from penerbit WHERE id_penerbit = '$idpenerbit'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Berhasil Menghapus Data";
        } else {
            $error = "Gagal Menghapus Data: " . mysqli_error($koneksi);
        }
    }
    if (isset($_POST['simpan'])) {
        $idpenerbit= $_POST['id_penerbit'];
        $namapenerbit = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $telepon = $_POST['telepon'];
        $op = $_POST['op'];
    
        if ($namapenerbit && $alamat && $kota && $telepon) {
            if ($op == 'edit') {
                // logika pengkondisian huruf pertama ID Penerbit pada mode edit
                #$sql_count = "SELECT COUNT(id_penerbit) AS jumlah_penerbit FROM penerbit WHERE id_penerbit LIKE 'SP%'";
                #$result_count = mysqli_query($koneksi, $sql_count);
                #$row_count = mysqli_fetch_assoc($result_count);
                #$jumlah_penerbit = $row_count['jumlah_penerbit'];
                #$idpenerbit = 'SP' . str_pad(($jumlah_penerbit + 1), 2, '0', STR_PAD_LEFT);
                // end of logika pengkondisian
                $sql1 = "UPDATE penerbit set nama ='$namapenerbit', alamat='$alamat', kota='$kota', telepon='$telepon' WHERE id_penerbit = '$idpenerbit'";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Data Berhasil di Update";
                } else {
                    $error = "Data Gagal di Update";
                }
            } else {
                // logika pengkondisian huruf pertama ID Penerbit pada mode tambah
                $sql_count = "SELECT COUNT(id_penerbit) AS jumlah_penerbit FROM penerbit WHERE id_penerbit LIKE 'SP%'";
                $result_count = mysqli_query($koneksi, $sql_count);
                $row_count = mysqli_fetch_assoc($result_count);
                $jumlah_penerbit = $row_count['jumlah_penerbit'];
                $idpenerbit = 'SP' . str_pad(($jumlah_penerbit + 1), 2, '0', STR_PAD_LEFT);
                // end of logika pengkondisian
                $sql1 = "INSERT into penerbit(id_penerbit, nama, alamat, kota, telepon) values ('$idpenerbit','$namapenerbit','$alamat','$kota', '$telepon')";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Berhasil Memasukkan Data";
                } else {
                    $error = "Gagal Memasukkan Data";
                }
            }
        }
    }
    ?>
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Create / Edit Data Penerbit
                </div>
                <?php
            if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php

                header("refresh:1;url=admin2.php");
            }
            ?>

                <?php
            if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php

                header("refresh:1;url=admin2.php");
            }
            ?>

                <form action="admin2.php" method="POST">
                    <div class="card-body">

                        
                    <input type="hidden" class="form-control" id="id_penerbit" name="id_penerbit" value="<?php echo isset($idpenerbit) ? $idpenerbit : ''; ?>">
                            

                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="<?php echo $namapenerbit ?>" placeholder="Nama Penerbit">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    value="<?php echo $alamat ?>" placeholder="Alamat">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="kota" class="col-sm-2 col-form-label">Kota</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kota" name="kota"
                                    value="<?php echo $kota ?>" placeholder="Kota">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    value="<?php echo $telepon ?>" placeholder="Telepon">
                            </div>
                        </div>

                        <div class="col-12">
                            <input type="submit" name="simpan" class="btn btn-primary">
                            <input type="hidden" name="op" value="<?php echo $op; ?>">
                            <a href="admin2.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
    
    <div class="card">
        <div class="card-header text-light bg-secondary">
            Data Penerbit
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Penerbit</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Telepon</th>
                        <th scope="col">Aksi</th>
                    </tr>
                <tbody>
                    <?php
                              $page = isset($_GET['page']) ? $_GET['page'] : 1;
                              $per_page = 5;
                              $offset = ($page - 1) * $per_page;
                              $sql_count = "SELECT COUNT(id_penerbit) AS total FROM penerbit";
                              $result_count = mysqli_query($koneksi, $sql_count);
                              $row_count = mysqli_fetch_assoc($result_count);
                              $total_pages = ceil($row_count['total'] / $per_page);
                          
                              $sql2 = "SELECT penerbit.id_penerbit, penerbit.nama, penerbit.alamat, penerbit.kota, penerbit.telepon, COUNT(buku.id_buku) AS jumlah_buku
                                      FROM penerbit
                                      LEFT JOIN buku ON penerbit.nama = buku.penerbit
                                      GROUP BY penerbit.id_penerbit, penerbit.nama, penerbit.alamat, penerbit.kota, penerbit.telepon
                                      LIMIT $per_page OFFSET $offset";

                        $q2 = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $idpenerbit = $r2['id_penerbit'];
                            $namapenerbit = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $kota = $r2['kota'];
                            $telepon = $r2['telepon'];
                            ?>

                    <tr>
                        <td scope="row">
                            <?php echo $idpenerbit ?>
                        </td>
                        <td scope="row">
                            <?php echo $namapenerbit ?>
                        </td>
                        <td scope="row">
                            <?php echo $alamat ?>
                        </td>
                        <td scope="row">
                            <?php echo $kota ?>
                        </td>
                        <td scope="row">
                            <?php echo $telepon ?>
                        </td>
                        <td scope="row">
                            <a href="admin2.php?op=edit&id_penerbit=<?php echo $idpenerbit ?>"><button type="button"
                                    class="btn btn-warning">Edit</button></a>

                            <a href="admin2.php?op=del&id_penerbit=<?php echo $idpenerbit ?>"
                                onclick="return confirm('yakin mau delete?')"><button type="button"
                                    class="btn btn-danger">Delete</button></a>
                        </td>
                    </tr>
                    <?php
                        }
                        ?>
                </tbody>
                </thead>
            </table>
            <div class="container mt-3">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="admin2.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    </div>
    </div>
</body>

</html>