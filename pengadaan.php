<!doctype html>
<html lang="en">

<head>
    <style>
        .mx-auto {
            width: 1500px;
        }

        .card {
            margin-top: 10px;
        }

        .urgent {
            color: #FFFFFF;
            background-color: #FF0000;
            /* Merah */
        }

        .persiapan {
            color: #000000;
            background-color: #FFFF00;
            /* Kuning */
        }

        .banyak {
            color: #000000;
            background-color: #00FF00;
            /* Hijau */
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>UNIBOOKSTORE</title>
</head>

<body>
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

    // Fungsi untuk melakukan pembaruan stok
    function updateStok($id_buku, $jumlah) {
        global $koneksi;

        $sqlUpdate = "UPDATE buku SET stok = stok + $jumlah WHERE id_buku = '$id_buku'";
        $resultUpdate = mysqli_query($koneksi, $sqlUpdate);

        if ($resultUpdate) {
            return true; // Pembaruan berhasil
        } else {
            return false; // Pembaruan gagal
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['update_stok'])) {
            $id_buku = $_POST['id_buku'];
            $jumlah = $_POST['jumlah'];

            // Panggil fungsi untuk melakukan pembaruan stok
            $updateResult = updateStok($id_buku, $jumlah);

            if ($updateResult) {
                echo "<script>alert('Stok berhasil diperbarui.');</script>";
            } else {
                echo "<script>alert('Gagal memperbarui stok.');</script>";
            }
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
    <nav class="navbar navbar-expand-lg bg-info ">
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
    <div class="mx-auto">
        <div class="card">
            <div class="card-header text-light bg-secondary text-center">
                Laporan Pengadaan Buku
            </div>
            <div class="row">
                <div class="col-md">
                    <form action="" method="POST">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="masukkan kata kunci pencarian" autocomplete="off" autofocus>
                            <button type="submit" name="cari" class="btn btn-primary"
                                style="width: 100px;">cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th> <!-- Tambah kolom aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT id_buku, nama_buku, penerbit, stok FROM buku ORDER BY stok ASC LIMIT 10";
                        $q2 = mysqli_query($koneksi, $sql2);

                        if (isset($_POST["cari"])) {
                            $keyword = $_POST["keyword"];
                            $sql2 = "SELECT * FROM buku WHERE nama_buku LIKE '%$keyword%'";
                            $q2 = mysqli_query($koneksi, $sql2);
                        }

                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_buku = $r2['id_buku'];
                            $namabuku = $r2['nama_buku'];
                            $penerbit = $r2['penerbit'];
                            $stok = $r2['stok'];

                            // Tentukan status dan warna berdasarkan kondisi stok
                            $status_class = '';
                            if ($stok <= 10) {
                                $status_class = 'Urgent';
                                $status = 'urgent';
                            } elseif ($stok > 10 && $stok <= 30) {
                                $status_class = 'Persiapan';
                                $status = 'persiapan';
                            } else {
                                $status_class = 'Banyak';
                                $status = 'banyak';
                            }
                            ?>
                            <tr>
                                <td scope="row">
                                    <?php echo $namabuku ?>
                                </td>
                                <td scope="row">
                                    <?php echo $penerbit ?>
                                </td>
                                <td scope="row">
                                    <?php echo $stok ?>
                                </td>
                                <td scope="row" class="<?php echo $status_class; ?>">
                                    <?php echo $status ?>
                                </td>
                                <td scope="row">
                                    <!-- Tombol aksi "Update Stok" -->
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                                        <div class="input-group">
                                            <input type="number" name="jumlah" class="form-control"
                                                placeholder="Jumlah Stok Baru" required>
                                            <button type="submit" name="update_stok" class="btn btn-success"
                                                style="width: 100px;">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
