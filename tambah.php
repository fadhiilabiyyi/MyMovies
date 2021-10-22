<?php
session_start();
// functions config
require "lib/functions.php";

if( !isset($_SESSION["login"]) ) {
    header("Location: login/login.php");
    exit;
}

// function insert new data
if( isset($_POST["submit"]) ) {
    if( tambahData($_POST) > 0 ) {
        echo alert("Data berhasil ditambahkan!") . redirect("index.php");
    } else {
        echo alert("Data gagal ditambahkan!") . redirect("index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Data</title>
</head>
<body>
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="1">Title</label></td>
                <td><input type="text" name="title" id="1" required></td>
            </tr>
            <tr>
                <td><label for="2">Genres</label></td>
                <td><input type="text" name="genres" id="2" required></td>
            </tr>
            <tr>
                <td><label for="3">Director</label></td>
                <td><input type="text" name="director" id="3" required></td>
            </tr>
            <tr>
                <td><label for="4">Release Date</label></td>
                <td><input type="date" name="release_date" id="4" required></td>
            </tr>
            <tr>
                <td><label for="5">Rating</label></td>
                <td><input type="text" name="rating" id="5" required placeholder="10 / 10 (IMDb)"></td>
            </tr>
            <tr>
                <td><label for="6">Poster</label></td>
                <td><input type="file" name="poster_img" id="6"></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit">Tambah Data!</button></td>
            </tr>
        </table>
    </form>
</body>
</html>