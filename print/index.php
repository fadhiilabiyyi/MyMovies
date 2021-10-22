<?php 
session_start();
require "../lib/functions.php";

if( !isset($_SESSION["login"]) ) {
    header("Location: ../login/login.php");
    exit;
}

$movies = tampilkanData("SELECT * FROM movies");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Movies</title>
    <style>
        @media print {
            @page { 
                margin: 0; 
                size: auto;
            }
            body { margin: 1.6cm; }
        }

        h1, tr {
            text-align: center;
        }

        .center {
            margin: auto;
        }
    </style>
</head>
<body>
    <h1>My Movies</h1>

    <table class="center" border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Poster</th>
            <th>Title</th>
            <th>Genres</th>
            <th>Director</th>
            <th>Release Date</th>
            <th>Rating</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($movies as $movie) : ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><img src="../img/<?= $movie["poster_img"]; ?>" width="45px" alt="poster"></td>
            <td><?= $movie["title"]; ?></td>
            <td><?= $movie["genres"]; ?></td>
            <td><?= $movie["director"]; ?></td>
            <td><?= $movie["release_date"]; ?></td>
            <td><?= $movie["rating"]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <script>
        window.print();
    </script>
</body>
</html>