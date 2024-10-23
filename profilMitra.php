<?php
require 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];

$queryMitra = "select * from resto where added_by = '$sessionUsername'";

$hasil = $conn->query($queryMitra);
$i = 1;


// fungsi hapus resto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $queryDelete = "delete from resto where id = '$id'";

    if ($conn->query($queryDelete)) {
        echo "<script>alert('Resto berhasil dihapus dari database!');
        window.location.href = '/profilMitra.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Mitra</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <h1>List Restoran</h1>
    <div class="wrapper">

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Restoran</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasil as $baris): ?>
                    <tr>
                        <th scope="row"><?php echo $i++; ?></th>
                        <td><img src="<?php echo $baris['foto']; ?>" alt="<?php echo $baris['nama']; ?>"></td>
                        <td><?php echo $baris['nama']; ?></td>
                        <td><?php echo $baris['alamat']; ?></td>
                        <td class="menu">
                            <a href="updateResto.php?id=<?php echo $baris['id']; ?>">Update</a>
                            <a href="profilMitra.php?delete=<?php echo $baris['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<style>
    .wrapper {
        width: 90%;
        margin: 10px auto;

        a {
            padding: 5px 10px;
            text-decoration: none;
            color: inherit;
            background-color: #d9d9d9;
            border-radius: 6px;
        }

        td,
        th {
            vertical-align: middle;
            height: 100%;
            text-align: center;
        }

        img {
            width: 220px;
            height: 220px;
            border-radius: 25px;
            object-fit: cover;
            background-position: center;
            background-size: cover;
        }
    }
</style>