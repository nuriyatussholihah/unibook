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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

  $idbuku = "";
  $kategoribuku = "";
  $namabuku = "";
  $harga = "";
  $stok = "";
  $penerbit = "";
  $sukses = "";
  $error = "";

  if (isset($_GET['op'])) {
    $op = $_GET['op'];
  } else {
    $op = "";
  }


  if ($op == 'edit') {
    $idbuku = $_GET['id_buku'];
    $sql1 = "SELECT * from buku where id_buku = '$idbuku'";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1 && mysqli_num_rows($q1) > 0) {
      $r1 = mysqli_fetch_array($q1);
      $idbuku = $r1['id_buku'];
      $kategoribuku = isset($r1['kategori']) ? $r1['kategori'] : '';
      $namabuku = $r1['nama_buku'];
      $harga = $r1['harga'];
      $stok = $r1['stok'];
      $penerbit = isset($r1['penerbit']) ? $r1['penerbit'] : '';
    }

    if ($op == 'edit' && $kategoribuku != $r1['kategori']) {
      $kategori_awal_baru = strtoupper(substr($kategoribuku, 0, 1));
      $sql_count_baru = "SELECT COUNT(id_buku) AS jumlah_buku FROM buku WHERE kategori = '$kategoribuku'";
      $result_count_baru = mysqli_query($koneksi, $sql_count_baru);
      $row_count_baru = mysqli_fetch_assoc($result_count_baru);
      $jumlah_buku_baru = $row_count_baru['jumlah_buku'];
      $idbuku = $kategori_awal_baru . ($jumlah_buku_baru + 1001);
    }
  }

  if ($op == 'del') {
    $idbuku = $_GET['id_buku'];
    $sql1 = "DELETE FROM buku WHERE id_buku = '$idbuku'";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
      $sukses = "Berhasil Menghapus Data";
    } else {
      $error = "Gagal Menghapus Data: " . mysqli_error($koneksi);
    }
  }

  if (isset($_POST['simpan'])) {
    $idbuku = $_POST['id_buku'];
    $kategoribuku = isset($_POST['kategori']) ? $_POST['kategori'] : '';
    $namabuku = $_POST['nama_buku'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $penerbit = isset($_POST['penerbit']) ? $_POST['penerbit'] : '';
    $op = $_POST['op'];

    #masih hrs dibenerin
    if ($op != 'edit') {
      $kategori_awal = strtoupper(substr($kategoribuku, 0, 1));
      $sql_count = "SELECT COUNT(id_buku) AS jumlah_buku FROM buku WHERE kategori = '$kategoribuku'";
      $result_count = mysqli_query($koneksi, $sql_count);
      $row_count = mysqli_fetch_assoc($result_count);
      $jumlah_buku = $row_count['jumlah_buku'];
      $idbuku = $kategori_awal . ($jumlah_buku + 1001);
    }

    if ($kategoribuku && $namabuku && $harga && $stok && $penerbit) {
      if ($op == 'edit') {
        $sql1 = "UPDATE buku SET kategori='$kategoribuku', nama_buku='$namabuku', harga='$harga', stok='$stok', penerbit='$penerbit' WHERE id_buku = '$idbuku'";
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
          $sukses = "Data Berhasil di Update";
        } else {
          $error = "Data Gagal di Update: " . mysqli_error($koneksi);
        }
      } else {
        $sql1 = "INSERT INTO buku (id_buku, kategori, nama_buku, harga, stok, penerbit) VALUES ('$idbuku','$kategoribuku','$namabuku','$harga', '$stok', '$penerbit')";
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
        Create / Edit Data Buku
      </div>

      <?php
      if ($error) {
        ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error ?>
        </div>
        <?php

        header("refresh:1;url=admin1.php");
      }
      ?>

      <?php
      if ($sukses) {
        ?>
        <div class="alert alert-success" role="alert">
          <?php echo $sukses ?>
        </div>
        <?php

        header("refresh:1;url=admin1.php");
      }
      ?>

      <form action="admin1.php" method="POST">
        <div class="card-body">

          <input type="hidden" class="form-control" id="id_buku" name="id_buku"
            value="<?php echo isset($idbuku) ? $idbuku : ''; ?>">

          <div class="mb-3 row">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori Buku</label>
            <div class="col-sm-10">
              <select class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                <option value="" disabled selected>Daftar Kategori</option>
                <option value="Bisnis" <?php echo ($kategoribuku == 'Bisnis') ? 'selected' : ''; ?>>Bisnis</option>
                <option value="Keilmuan" <?php echo ($kategoribuku == 'Keilmuan') ? 'selected' : ''; ?>>Keilmuan
                </option>
                <option value="Novel" <?php echo ($kategoribuku == 'Novel') ? 'selected' : ''; ?>>Novel</option>
                <option value="Agama" <?php echo ($kategoribuku == 'Agama') ? 'selected' : ''; ?>>Agama</option>
              </select>

            </div>
          </div>

          <div class="mb-3 row">
            <label for="nama_buku" class="col-sm-2 col-form-label">Nama Buku</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_buku" name="nama_buku"
                value="<?php echo isset($namabuku) ? $namabuku : ''; ?>" placeholder="Nama Buku">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
              <input type="number" step="any" class="form-control" id="harga" name="harga"
                value="<?php echo isset($harga) ? $harga : ''; ?>" placeholder="Harga">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="stok" name="stok"
                value="<?php echo isset($stok) ? $stok : ''; ?>" placeholder="Stok">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
            <div class="col-sm-10">
              <select class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit">
                <option value="" disabled selected>Daftar Penerbit</option>
                <?php
                // Ambil data penerbit dari tabel penerbit
                $sql_penerbit = "SELECT nama FROM penerbit";
                $result_penerbit = mysqli_query($koneksi, $sql_penerbit);

                while ($row_penerbit = mysqli_fetch_assoc($result_penerbit)) {
                  $penerbit_name = $row_penerbit['nama'];
                  echo "<option value=\"$penerbit_name\" " . ($penerbit == $penerbit_name ? 'selected' : '') . ">$penerbit_name</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="col-12">
            <input type="submit" name="simpan" class="btn btn-primary">
            <input type="hidden" name="op" value="<?php echo $op; ?>">
            <a href="admin1.php" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>

    <div class="card">
      <div class="card-header text-light bg-secondary">
        Data Buku
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
              <th scope="col">Aksi</th>
            </tr>
          <tbody>
            <?php
            // Define the number of items per page
            $itemsPerPage = 5;

            // Get the current page number from the query parameter
            $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

            // Calculate the starting point for the data retrieval
            $startIndex = ($currentPage - 1) * $itemsPerPage;

            // Modify the SQL query to retrieve limited data based on the page
            $sql2 = "SELECT buku.id_buku, buku.kategori, buku.nama_buku, buku.harga, buku.stok, buku.penerbit, COUNT(b.id_buku) AS jumlah_buku
                FROM buku
                LEFT JOIN buku b ON buku.kategori = b.kategori
                GROUP BY buku.id_buku, buku.kategori, buku.nama_buku, buku.harga, buku.stok, buku.penerbit
                LIMIT $startIndex, $itemsPerPage";

            $q2 = mysqli_query($koneksi, $sql2);
            while ($r2 = mysqli_fetch_array($q2)) {
              $idbuku = $r2['id_buku'];
              $kategoribuku = $r2['kategori'];
              $namabuku = $r2['nama_buku'];
              $harga = $r2['harga'];
              $stok = $r2['stok'];
              $penerbit = $r2['penerbit'];
              ?>

              <tr>
                <td scope="row">
                  <?php echo $idbuku ?>
                </td>
                <td scope="row">
                  <?php echo $kategoribuku ?>
                </td>
                <td scope="row">
                  <?php echo $namabuku ?>
                </td>
                <td scope="row">
                  <?php echo 'Rp ' .  number_format("$harga", 0, ",", ".") ?>
                </td>
                <td scope="row">
                  <?php echo $stok ?>
                </td>
                <td scope="row">
                  <?php echo $penerbit ?>
                </td>
                <td scope="row">
                  <a href="admin1.php?op=edit&id_buku=<?php echo $idbuku ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>

                  <a href="admin1.php?op=del&id_buku=<?php echo $idbuku ?>"
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
        <!-- Pagination controls -->
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php
            // Calculate the total number of pages
            $sqlCount = "SELECT COUNT(*) as total FROM buku";
            $resultCount = mysqli_query($koneksi, $sqlCount);
            $rowCount = mysqli_fetch_assoc($resultCount);
            $totalPages = ceil($rowCount['total'] / $itemsPerPage);

            // Render pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
              $activeClass = ($i == $currentPage) ? 'active' : '';
              echo "<li class='page-item $activeClass'><a class='page-link' href='admin1.php?page=$i'>$i</a></li>";
            }
            ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</body>

</html>