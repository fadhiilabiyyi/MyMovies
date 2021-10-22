<?php
session_start();
require "lib/functions.php";

if( !isset($_SESSION["login"]) ) {
    header("Location: login/login.php");
    exit;
}

// pagination
// konfigurasi
$dataPerHalaman = 3;
$jumlahData = count(tampilkanData("SELECT * FROM movies"));
$jumlahHalaman = ceil($jumlahData / $dataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$dataAwal = ( $dataPerHalaman * $halamanAktif ) - $dataPerHalaman;

$movies = tampilkanData("SELECT * FROM movies LIMIT $dataAwal, $dataPerHalaman");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .loader {
            width: 85px;
            position: absolute;
            top: 100px;
            z-index: -1;
            display: none;
        }

        .refresh-btn {
            text-decoration: none;
            text-align: center;
            color: blue;
        }

        .halaman-aktif {
            color: red;
        }
    </style>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <a href="login/logout.php">Logout!</a>

    <h1>Daftar Film</h1>

    <a href="tambah.php">Tambah Data</a>
    <br><br>

    <!-- Tombol cari -->
    <form action="" method="get" autocomplete="off">
        <input type="text" name="keyword" autofocus placeholder="Cari..." id="keyword">
        <button type="submit" name="cari" id="tombol-cari"></button>

        <img class="loader" src="img/loading.gif!w340" alt="loading">
    </form>
    <br>

    <a class="refresh-btn" href="index.php">Refresh!</a> | <a target="_blank" href="print/">Cetak</a>

    <br>
    <br>

    <div id="container">
        <!-- Navigasi pagination -->
        <?php if( !isset($_GET["cari"]) ) : ?>
            <?php if( $halamanAktif > 1 ) : ?>
                <a href="?halaman=<?= $halamanAktif - 1 ?>">&larr;</a>
            <?php endif; ?>

            <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
                <?php if( $i == $halamanAktif ) : ?>
                    <a class="halaman-aktif" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                <?php else : ?>
                    <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if( $halamanAktif < $jumlahHalaman ) : ?>
                <a href="?halaman=<?= $halamanAktif + 1 ?>">&rarr;</a>
            <?php endif; ?>
        <?php endif; ?>

        <!-- jika tombol search ditekan -->
        <?php 
        
        // search
        if( isset($_GET["cari"]) ) {
            $keyword = $_GET["keyword"];

            $dataAwal = ( $dataPerHalaman * $halamanAktif ) - $dataPerHalaman;
            $jumlahData = count(cariData($_GET["keyword"]));
            $jumlahHalaman = ceil($jumlahData / $dataPerHalaman);

            $movies = cariDataLimit($_GET["keyword"], $dataAwal, $dataPerHalaman);

            if( $halamanAktif > 1 ) : ?>
                <a href="?halaman=<?= $halamanAktif - 1 ?>&keyword=<?= $keyword; ?>&cari=<?php true; ?>">&larr;</a>
            <?php endif; ?>
        
            <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
                <?php if( $i == $halamanAktif ) : ?>
                    <a class="halaman-aktif" href="?halaman=<?= $i; ?>&keyword=<?= $keyword ?>&cari=<?php true; ?>"><?= $i; ?></a>
                <?php else : ?>
                    <a href="?halaman=<?= $i; ?>&keyword=<?= $keyword; ?>&cari=<?php true; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        
            <?php if( $halamanAktif < $jumlahHalaman ) : ?>
                <a href="?halaman=<?= $halamanAktif + 1 ?>&keyword=<?= $keyword; ?>&cari=<?php true; ?>">&rarr;</a>
            <?php endif; 
        

        }
        
        ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Poster</th>
                <th>Title</th>
                <th>Genres</th>
                <th>Director</th>
                <th>Release Date</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>

            <?php $i = 1 + $dataAwal; ?>
            <?php foreach( $movies as $movie ) : ?>

            <tr align="center">
                <td><?= $i; ?></td>
                <td><img src="img/<?= $movie["poster_img"]; ?>" alt="" width="55px"></td>
                <td><?= $movie["title"]; ?></td>
                <td><?= $movie["genres"]; ?></td>
                <td><?= $movie["director"]; ?></td>
                <td><?= $movie["release_date"]; ?></td>
                <td><?= $movie["rating"]; ?></td>
                <td>
                    <a href="edit.php?id=<?= $movie["id"]; ?>">Edit</a> |
                    <a href="hapus.php?id=<?= $movie["id"]; ?>" onclick="return confirm('Data akan dihapus!');">Delete</a>
                </td>
            </tr>

            <?php $i++; ?>
            <?php endforeach; ?> 

        </table>
    </div>

</body>
</html>