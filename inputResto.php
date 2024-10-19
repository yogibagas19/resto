<?php 
include 'dbcon.php';
session_start();

if(!isset($_SESSION['username'])){
    header("Location: index.html");
}

$sessionUsername = $_SESSION['username'];
$sessionMitra = $_SESSION['is_mitra'];
$sessionId = $_SESSION['id'];




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Resto</title>
</head>

<body>
    <div class="navlink">
        <div class="link">
            <a href="">Tersimpan</a>
            <a href="home.php">kembali</a>
            <a href="logout.php">logout</a>
        </div>
        <p class="user">Halo, <?php echo $sessionUsername; ?></p>
    </div>
    <p>Ini Header</p>
    </header>

    <main>
        <form method="post" enctype="multipart/form-data">

        </form>
    </main>
</body>

</html>