<?php 
require "../lib/functions.php";

// pagination
// konfigurasi
$dataPerHalaman = 3;
$jumlahData = count(tampilkanData("SELECT * FROM movies"));
$jumlahHalaman = ceil($jumlahData / $dataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$dataAwal = ( $dataPerHalaman * $halamanAktif ) - $dataPerHalaman;

$movies = tampilkanData("SELECT * FROM movies LIMIT $dataAwal, $dataPerHalaman");

?>

<?php 
        
// search
        
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
    <?php endif; ?>

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