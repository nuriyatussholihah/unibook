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
    ?>

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

    <div class="mx-auto">
        <div class="card">
            <div class="card-header text-light bg-secondary text-center">
                Data Buku
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
                            <th scope="col">ID Buku</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Penerbit</th>
                        </tr>
                    <tbody>
                        <?php
                        // Menentukan jumlah item per halaman
                        $item_per_page = 10;

                        // Menentukan halaman saat ini
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Query untuk mendapatkan jumlah total data
                        $sql2_limit = "SELECT * FROM buku";
                        $total_data = mysqli_num_rows(mysqli_query($koneksi, $sql2_limit));

                        // Menghitung jumlah halaman
                        $total_pages = ceil($total_data / $item_per_page);

                        // Menentukan offset untuk query
                        $offset = ($current_page - 1) * $item_per_page;

                        if (isset($_POST["cari"])) {
                            $keyword = $_POST["keyword"];
                            $sql2_limit = "SELECT * FROM buku WHERE nama_buku LIKE '%$keyword%' LIMIT $offset, $item_per_page";
                        } else {
                            // Query untuk mendapatkan data dengan batasan offset dan limit
                            $sql2_limit = "SELECT * FROM buku LIMIT $offset, $item_per_page";
                        }
                        $q2_limit = mysqli_query($koneksi, $sql2_limit);
                        //Loop untuk Menampilkan Data Buku
                        while ($r2 = mysqli_fetch_array($q2_limit)) {
                            $idbuku = $r2['id_buku'];
                            $kategoribuku = $r2['kategori'];
                            $namabuku = $r2['nama_buku'];
                            $harga = $r2['harga'];
                            $stok = $r2['stok'];
                            $penerbit = $r2['penerbit'];
                            ?>

                        <tr>
                            <th scope="row">
                                <?php echo $idbuku ?>
                            </th>
                            <td scope="row">
                                <?php echo $kategoribuku ?>
                            </td>
                            <td scope="row">
                                <?php echo $namabuku ?>
                            </td>
                            <td scope="row">
                                <?php echo 'Rp ' . number_format("$harga", 0, ",", ".") ?>
                            </td>
                            <td scope="row">
                                <?php echo $stok ?>
                            </td>
                            <td scope="row">
                                <?php echo $penerbit ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
                <!-- Navigasi List -->
                <nav aria-label="Navigasi List">
                    <ul class="pagination">
                        <?php
                        for ($i = 1; $i <= $item_per_page; $i++) {
                            echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>

</html>