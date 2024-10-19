<?php
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
}

$sessionUsername = $_SESSION['username'];
$sessionMitra = $_SESSION['is_mitra'];
$sessionId = $_SESSION['id'];


// set session nama resto dari tabel resto
if ($sessionMitra == 1) {
    $queryResto = "select * from resto where added_by = '$sessionUsername'";

    $hasil = mysqli_query($conn, $queryResto);

    if ($hasil->num_rows > 0) {
        $row = $hasil->fetch_assoc();

        $_SESSION['resto'] = $row['nama'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $queryMitra = "update users set is_mitra = 1 where id = '$sessionId'";

    if (mysqli_query($conn, $queryMitra)) {
        $sessionMitra = 1;
        echo "<script>alert('Anda sekarang menjadi mitra!');</script>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <header>
        <div class="navlink">
            <div class="link">
                <?php if ($sessionMitra == 0): ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Bermitra
                    </a>
                <?php else: ?>
                    <a href="inputResto.php">Daftarkan Resto</a>
                <?php endif; ?>
                <a href="">Tersimpan</a>
                <a href="logout.php">logout</a>
            </div>
            <p class="user">Halo, <?php echo $sessionUsername; ?></p>
        </div>
        <p>Ini Header</p>
    </header>




    <!-- modal bermitra -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="display: grid;
    align-items: center;margin-top: 50%;">
                <div class="modal-header" style="margin: auto;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah anda yakin untuk bermitra?</h1>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-footer" style="display: flex; margin: auto; gap: 15px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form method="post">
                        <input value="Ya" type="submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>