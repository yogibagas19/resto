<?php
require 'dbcon.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];
$sessionMitra = $_SESSION['is_mitra'];

if (isset($_GET['id'])) {
    $resto_id = $_GET['id'];

    $queryResto = "select * from resto where id = '$resto_id'";

    $hasil = $conn->query($queryResto);

    if ($hasil->num_rows > 0) {
        $resto = $hasil->fetch_assoc();

        $queryMenu = "select * from menu where resto_id = '$resto_id'";
        $menus = $conn->query($queryMenu);
    } else {
        echo "<script>alert('Restoran tidak ditemukan.');</script>";
        echo "<script>window.location.href='home.php';</script>";
    }
} else {
    echo "<script>alert('ID Restoran tidak valid.');</script>";
    echo "<script>window.location.href='home.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <title><?php echo $resto['nama']; ?></title>
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="wrapper">
            <div class="resto">
                <div class="info">
                    <p class="judul"><?php echo $resto['nama']; ?></p>
                    <p class="alamat"><?php echo $resto['alamat']; ?></p>
                    <p class="harga">Start From: <?php echo 'Rp' . number_format($resto['min_price'], 0, ',', '.'); ?> - <?php echo 'Rp' . number_format($resto['max_price'], 0, ',', '.'); ?></p>
                </div>
                <img src="<?php echo $resto['foto']; ?>" alt="<?php echo $resto['nama']; ?>">
            </div>
            <div class="garis"></div>
            <?php if ($menus && $menus->num_rows > 0): ?>
                <div class="wrapper-menu">
                    <?php foreach ($menus as $menu): ?>
                        <div class="card">
                            <img src="<?php echo $menu['foto']; ?>" alt="<?php echo $resto['nama']; ?>">
                            <p class="menu"><?php echo $menu['nama']; ?></p>
                            <p class="harga">Harga: <?php echo 'Rp' . number_format($menu['harga'], 0, ',', '.'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Tidak ada menu di resto ini</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>

<style>
    main {
        width: 100%;
        margin: 10px auto;
        background-color: #AAB396;

        .wrapper {
            width: 80%;
            margin: 20px auto;

            .resto{
                display: flex;
                width: 100%;
                height: 500px;
                background-color: #d9d9d9;
                justify-content: space-evenly;
                align-items: center;

                .info{
                    width: 600px;
                    /* background-color: aqua; */
                    word-wrap: break-word;

                    .judul{
                        font-size: 32px;
                        font-weight: 700;
                        margin: 10px 0px;
                    }
                    .alamat{
                        font-size: 32px;
                        margin: 10px 0px;
                    }
                    .harga{
                        font-size: 24px;
                    }
                }

                img{
                    width: 400px;
                    height: 400px;
                    background-position: center;
                    background-size: cover;
                }

            }
            .garis{
                height: 5px;
                width: 100%;
                background-color: #d9d9d9;
                margin: 50px 0px;
            }

            .wrapper-menu{
                width: 100%;
                display: grid;
                margin: 0px auto;
                grid-template-columns: repeat(7, 1fr);
                gap: 20px;

                .card{
                    text-align: center;
                    background-color: #d9d9d9;
                    padding: 20px;
                    border-radius: 10px;

                    img{
                        width: 200px;
                        height: 200px;
                        object-fit: cover;
                        background-position: center;
                        background-size: cover;
                    }
                    .menu{
                        font-size: 24px;
                        font-weight: 600;
                    }
                    .harga{
                        font-size: 20px;
                        font-weight: 500;
                    }
                }
            }

        }


    }
</style>