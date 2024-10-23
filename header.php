<?php
require 'dbcon.php';
$sessionMitra = $_SESSION['is_mitra'];
$sessionUsername = $_SESSION['username'];
$sessionId = $_SESSION['id'];

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

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<header>
    <div class="navlink">
        <div class="link">
            <?php if ($sessionMitra == 0): ?>
                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Bermitra
                </a>
            <?php else: ?>
                <a href="inputResto.php">Daftarkan Resto</a>
                <a href="profilMitra.php">Profil Mitra</a>
            <?php endif; ?>
            <a href="profilUser.php">Tersimpan</a>
            <a href="home.php">kembali ke home</a>
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

<style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");

    * {
        padding: 0;
        margin: 0;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-style: normal;
    }

    header {
        height: auto;
        padding: 10px 0px;
        background-color: aqua;
        place-content: center;
        position: relative;

        p {
            text-align: center;
            font-size: 24px;
            padding: 15px 0px;
        }

        .navlink {
            position: absolute;
            left: 10px;
            /* display: flex; */
            gap: 30px;

            .link {
                display: flex;
                gap: 10px;
                width: fit-content;
            }
        }
    }
</style>