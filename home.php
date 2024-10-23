<?php
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];
$sessionMitra = $_SESSION['is_mitra'];
$sessionId = $_SESSION['id'];


$i = 1;
$queryTampil = "select * from resto";
$baris = mysqli_query($conn, $queryTampil);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <title>Home</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <?php foreach ($baris as $list) : ?>
            <div class="card">
                <a href="pageResto.php?id=<?php echo $list['id']; ?>" class="resto-link">
                    <div class="konteks">
                        <p class="judul"><?php echo $list['nama']; ?></p>
                        <p><?php echo $list['alamat']; ?></p>
                        <p>Start From: <?php echo 'Rp' . number_format($list['min_price'], 0, ',', '.'); ?> - <?php echo 'Rp' . number_format($list['max_price'], 0, ',', '.'); ?></p>
                    </div>
                    <img src="<?php echo $list['foto']; ?>" alt="<?php echo $list['foto']; ?>">
                </a>
                <a class="save-button" href="simpanResto.php?id=<?php echo $list['id']; ?>">Simpan</a>
            </div>
        <?php endforeach; ?>
    </main>

</body>

</html>

<style>
    main {
        background-color: beige;
        width: 95%;
        height: auto;
        margin: 10px auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;

        .card {
            background-color: #F7E6C4;
            display: flex;
            border-radius: 20px;
            margin: 15px auto;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            height: 35vh;

            .konteks {

                .judul {
                    font-size: 25px;
                    font-weight: 700;
                }
            }

            img {
                margin-right: 25px;
                width: 220px;
                height: 220px;
                border-radius: 25px;
                object-fit: cover;
                background-position: center;
                background-size: cover;
            }

            .save-button {
                background-color: #FF6347;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 10px;
                cursor: pointer;
                margin-top: 10px;
                text-decoration: none;
            }

            .save-button:hover {
                opacity: 80%;
            }
        }

        a.resto-link {
            text-decoration: none;
            width: 100%;
            color: inherit;
            display: flex;
            justify-content: space-around;
            align-items: center;

        }
    }
</style>