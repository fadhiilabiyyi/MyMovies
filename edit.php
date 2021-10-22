<?php
session_start();
// functions config
require "lib/functions.php";

if( !isset($_SESSION["login"]) ) {
    header("Location: login/login.php");
    exit;
}

$id = $_GET["id"];

// ambil data
$movie = tampilkanData("SELECT * FROM movies WHERE id = $id")[0];


// function insert new data
if( isset($_POST["submit"]) ) {
    if( ubahData($_POST) > 0 ) {
        echo alert("Data berhasil di-update!") . redirect("index.php");
    } else {
        echo alert("Data gagal di-update!") . redirect("index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Data</title>
</head>
<body>
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <!-- send movie id -->
        <input type="hidden" name="id" value="<?= $movie["id"] ?>">
        <!-- send old poster -->
        <input type="hidden" name="posterLama" value="<?= $movie["poster_img"]; ?>">
        <table>
            <tr>
                <td><label for="1">Title</label></td>
                <td><input type="text" name="title" id="1" required value="<?= $movie["title"]?>"></td>
            </tr>
            <tr>
                <td><label for="2">Genres</label></td>
                <td><input type="text" name="genres" id="2" required value="<?= $movie["genres"]?>"></td>
            </tr>
            <tr>
                <td><label for="3">Director</label></td>
                <td><input type="text" name="director" id="3" required value="<?= $movie["director"]?>"></td>
            </tr>
            <tr>
                <td><label for="4">Release Date</label></td>
                <td><input type="date" name="release_date" id="4" required value="<?= $movie["release_date"]?>"></td>
            </tr>
            <tr>
                <td><label for="5">Rating</label></td>
                <td><input type="text" name="rating" id="5" required placeholder="10 / 10 (IMDb)" value="<?= $movie["rating"]?>"></td>
            </tr>
            <tr>
                <td><label for="6">Poster</label></td>
                <td>
                    <img src="img/<?= $movie["poster_img"]; ?>" alt="poster" width="55">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="file" name="poster_img" id="6" value="<?= $movie["poster_img"]?>">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit">Update Data!</button></td>
            </tr>
        </table>
    </form>
</body>
</html>