<?php
session_start();
require "lib/functions.php";

if( !isset($_SESSION["login"]) ) {
    header("Location: login/login.php");
    exit;
}

$idMovie = $_GET["id"];

if( hapusData($idMovie) > 0 ) {
    echo alert("Data berhasil dihapus!") . redirect("index.php");
} else {
    echo alert("Data gagal dihapus!") . redirect("index.php");
}

?>