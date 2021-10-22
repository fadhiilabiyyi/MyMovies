<?php
// koneksi database
// host, username, password, database name
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// menampilkan data table dari database
function tampilkanData($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }

    return $rows;
}

// menambah data table movies
function tambahData($data)
{
    global $conn;

    $title = htmlspecialchars($data["title"]);
    $genres = htmlspecialchars($data["genres"]);
    $director = htmlspecialchars($data["director"]);
    $release_date = htmlspecialchars($data["release_date"]);
    $rating = htmlspecialchars($data["rating"]);
    
    $poster_img = uploadPoster();
    if( !$poster_img ) {
        return false;
    }

    $query = "INSERT INTO movies 
                VALUES
             ('', '$title', '$genres', '$director', '$release_date', '$rating', '$poster_img')
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// upload gambar ke directory
function uploadPoster() 
{
    $namaFile = $_FILES["poster_img"]["name"]; // nama file poster
    $ukuranFile = $_FILES["poster_img"]["size"]; // size file poster
    $error = $_FILES["poster_img"]["error"]; // error yang menghasilkan int
    $tmpName = $_FILES["poster_img"]["tmp_name"]; // tempat penyimpanan file sementara

    // pengecekan gambar, apakah diupload?
    if( $error === 4 ) {
        echo alert("Silahkan upload poster terlebih dahulu");
        return false;
    }

    // pengecekan ekstensi file, apalah file adalah poster / img?
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png']; // ekstensi yang diperbolehkan
    $ekstensiGambar = explode('.', $namaFile); // pisah nama file dengan ekstensinya
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // ambil ekstensi gambar dan ubah ke low string
    
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) { // cek apakah ekstensi ada di dalam '$ekstensiGambarValid'
        echo alert("Silahkan upload file dengan ekstensi jpg, jpeg, dan png");
        return false;
    }

    // pengecekan size poster
    if( $ukuranFile > 1000000  ) { // 1000000 = 1 MB
        echo alert("Mohon upload gambar dengan ukuran di bawah 1 MB");
        return false;
    }

    // poster lolos, mengupload file poster
    $namaFileBaru = uniqid(); // generate new poster_img name

    $namaFileBaru .= '.' . $ekstensiGambar; // ditempel dengan ekstensi
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru); // pindahkan!

    return $namaFileBaru;

}


// menampilkan alert
function alert($message)
{
    return "<script>
                alert('$message');
            </script>";
}

// redirect user
function redirect($redirect) 
{
    return "<script>
                document.location.href = '$redirect';
            </script>";
}

// menghapus data dari table database
function hapusData($id)
{
    global $conn;

    $query = "DELETE FROM movies WHERE id = '$id'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// mengubah / update data
function ubahData($data)
{
    global $conn;

    $id = $data["id"];
    $title = htmlspecialchars($data["title"]);
    $genres = htmlspecialchars($data["genres"]);
    $director = htmlspecialchars($data["director"]);
    $release_date = htmlspecialchars($data["release_date"]);
    $rating = htmlspecialchars($data["rating"]);
    $posterLama = $data["posterLama"];

    if( $_FILES["poster_img"]["error"] === 4 ) {
        $poster_img = $posterLama;
    } else {
        $poster_img = uploadPoster();
    }

    $query = "UPDATE movies SET
                title = '$title',
                genres = '$genres',
                director = '$director',
                release_date = '$release_date',
                rating = '$rating',
                poster_img = '$poster_img'
            WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// mencari data
function cariData($keyword)
{
    $query = "SELECT * FROM movies
                WHERE
             title LIKE '%$keyword%' OR
             genres LIKE '%$keyword%' OR
             director LIKE '%$keyword%' OR
             release_date LIKE '%$keyword%' OR
             rating LIKE '%$keyword%'
            ";
    
    return TampilkanData($query);
}

// cari data (Pagination)
function cariDataLimit($keyword, $dataAwal, $dataPerhalaman)
{
    $query = "SELECT * FROM movies
                WHERE
             title LIKE '%$keyword%' OR
             genres LIKE '%$keyword%' OR
             director LIKE '%$keyword%' OR
             release_date LIKE '%$keyword%' OR
             rating LIKE '%$keyword%'
            LIMIT $dataAwal, $dataPerhalaman
            ";
    
    return TampilkanData($query);
}

// fungsi registrasi
function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_escape_string($conn, $data["password"]);
    $confimPass = mysqli_escape_string($conn, $data["confirmPass"]);

    // cek ketersediaan username
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if( mysqli_fetch_array($result) ) {
        echo alert("Username sudah terdaftar!");
        return false;
    }

    // cek jumlah character username | Maks 16.
    $cekUsernameChar = strlen($username);
    if( $cekUsernameChar > 16 ) {
        echo alert("Maksimal character username adalah 16!");
        return false;
    }

    // konfirmasi password
    if( $password !== $confimPass ) {
        echo alert("Konfirmasi password tidak sesuai!");
        return false;
    }

    // enkripsi password user
    $password = password_hash($password, PASSWORD_DEFAULT);

    // insert ke database
    $query = "INSERT INTO users VALUES('', '$username', '$password')";
    mysqli_query($conn, $query);

    // return int
    return mysqli_affected_rows($conn);

}