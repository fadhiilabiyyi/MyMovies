<?php 
session_start();
require "../lib/functions.php";

// cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if( $key === hash("sha256", $row["username"]) ) {
        $_SESSION["login"] = true;
    }
}

if( isset($_SESSION["login"]) ) {
    header("Location: ../index.php");
    exit;
}

if( isset($_POST["login"]) ) {
   $username = $_POST["username"];
   $password = $_POST["password"];

   $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

   // pengecekan username
   if( mysqli_num_rows($result) === 1 ) {
        // pengecekan password
        $row = mysqli_fetch_assoc($result);
        if( $password = password_verify($password, $row["password"]) ) {
            // set session
            $_SESSION["login"] = true;

            // set cookie
            if( isset($_POST["remember"]) ) {
                setcookie('id', $row["id"], time() + 3600*24*2, "/", "localhost", 1);
                setcookie('key', hash("sha256", $row["username"]), time() + 3600*24*2, "/", "localhost", 1);
            }


            header("Location: ../index.php");
            exit;
        }
   }

   echo alert("Login gagal, silahkan periksa username dan password!");

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>
    <h1>Halaman Login</h1>

    <a href="register.php">Registrasi</a>
    <br><br>

    <form action="" method="post" autocomplete="off">
        <table>
            <tr>
                <td>Username : </td>
                <td><input type="text" name="username" autofocus required></td>
            </tr>
            <tr>
                <td>Password : </td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td>Remember Me : </td>
                <td><input type="checkbox" name="remember"></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="login">Login!</button></td>
            </tr>
        </table>
    </form>
</body>
</html>