<?php 
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];

if(isset($_GET['id'])){
    $resto_id = $_GET['id'];

    $querySimpan = "insert into simpan_resto (username, resto_id) values ('$sessionUsername', '$resto_id')";

    if(mysqli_query($conn, $querySimpan)){
        echo "<script>alert('Restoran berhasil disimpan!');</script>";
        header("Location: home.php");
    }else{
        echo "Terjadi kesalahan " . $conn->error;
    }
}
?>