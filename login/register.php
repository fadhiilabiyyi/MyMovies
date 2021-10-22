<?php 
require "../lib/functions.php";

if( isset($_POST["register"]) ) {
    if( register($_POST) > 0 ) {
        echo alert("Pengguna baru berhasil ditambahkan!") . redirect("login.php");
    } else {
        echo alert("Gagal menambahkan pengguna baru!");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
</head>
<body>

    <h1>Halaman Registrasi</h1>

    <a href="login.php">Login</a>
    <br><br>

    <form action="" method="post" autocomplete="off">
        <table>
            <tr>
                <td><label for="1">Username</label></td>
                <td><input type="text" name="username" id="1" autofocus required></td>
            </tr>
            <tr>
                <td><label for="2">Password</label></td>
                <td><input type="password" name="password" id="2" required></td>
            </tr>
            <tr>
                <td><label for="3">Konfirmasi Password</label></td>
                <td><input type="password" name="confirmPass" id="3" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="register">Sign Up!</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>