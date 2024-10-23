<?php
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];


$queryTersimpan = "select resto.id, resto.nama, resto.alamat, resto.min_price, resto.max_price, resto.foto 
from simpan_resto
join resto on simpan_resto.resto_id = resto.id 
where simpan_resto.username = '$sessionUsername'";

$hasil = $conn->query($queryTersimpan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <title>Profil: <?php echo $sessionUsername; ?></title>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Resto yang tersimpan</h1>

        <?php if ($hasil->num_rows > 0): ?>
            <div class="container-resto">
                <?php foreach ($hasil as $list) : ?>
                    <div class="card">
                        <a href="pageResto.php?id=<?php echo $list['id']; ?>" class="resto-link">
                            <div class="konteks">
                                <p class="judul"><?php echo $list['nama']; ?></p>
                                <p><?php echo $list['alamat']; ?></p>
                                <p>Start From: <?php echo 'Rp' . number_format($list['min_price'], 0, ',', '.'); ?> - <?php echo 'Rp' . number_format($list['max_price'], 0, ',', '.'); ?></p>
                            </div>
                            <img src="<?php echo $list['foto']; ?>" alt="<?php echo $list['foto']; ?>">
                        </a>
                        <a class="del-button" href="hapusSimpanan.php?delete=<?php echo $list['id']; ?>">Hapus</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>

<style>
    main {
        background-color: beige;
        width: 95%;
        height: auto;
        margin: 10px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .container-resto {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        width: 100%;
    }

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

        .del-button {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
        }

        .del-button:hover {
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
</style>