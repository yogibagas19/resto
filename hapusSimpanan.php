<?php 
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $queryHapusSimpanan = "delete from simpan_resto where resto_id = '$id'";

    if($conn->query($queryHapusSimpanan)){
        echo "
        <script>
        alert('Resto berhasil dihapus dari daftar tersimpan');
        window.location.href='/profilUser.php';
        </script>";
    }
}
?>