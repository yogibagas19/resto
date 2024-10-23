<?php
require 'dbcon.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sessionUsername = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data resto berdasarkan ID
    $tampilResto = "SELECT * FROM resto WHERE id = '$id'";
    $hasil = $conn->query($tampilResto);

    if ($hasil->num_rows > 0) {
        $resto = $hasil->fetch_assoc();
        $tampilMenu = "SELECT * FROM menu WHERE resto_id = '$id'";
        $hasilMenu = $conn->query($tampilMenu);
        $menus = $hasilMenu->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "<script>alert('Restoran tidak ditemukan');</script>";
        echo "<script>window.location.href = 'home.php';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restoNama = $_POST['resto'];
    $alamat = $_POST['alamat'];
    $minPrice = $_POST['min-price'];
    $maxPrice = $_POST['max-price'];

    // Cek apakah foto resto diubah
    if ($_FILES['foto']['name']) {
        $fotoResto = $_FILES['foto']['name'];
        $fotoRestoTmp = $_FILES['foto']['tmp_name'];
        $fotoRestoPath = "image/" . $fotoResto;
        move_uploaded_file($fotoRestoTmp, $fotoRestoPath);

        // Update data resto dengan foto baru
        $updateResto = "UPDATE resto SET nama='$restoNama', alamat='$alamat', min_price='$minPrice', max_price='$maxPrice', foto='$fotoRestoPath' WHERE id='$id'";
    } else {
        // Update data resto tanpa mengubah foto
        $updateResto = "UPDATE resto SET nama='$restoNama', alamat='$alamat', min_price='$minPrice', max_price='$maxPrice' WHERE id='$id'";
    }
    $conn->query($updateResto);

    // Proses update menu
    if (isset($_POST['menu'])) {
        foreach ($_POST['menu'] as $menuId => $menuData) {
            $menuNama = $menuData['nama'];
            $menuHarga = $menuData['harga'];

            // Cek apakah foto menu diubah
            if ($_FILES['menu']['name'][$menuId]['foto']) {
                $fotoMenu = $_FILES['menu']['name'][$menuId]['foto'];
                $fotoMenuTmp = $_FILES['menu']['tmp_name'][$menuId]['foto'];
                $fotoMenuPath = "menuImg/" . $fotoMenu;
                move_uploaded_file($fotoMenuTmp, $fotoMenuPath);

                // Update menu dengan foto baru
                $updateMenu = "UPDATE menu SET nama='$menuNama', harga='$menuHarga', foto='$fotoMenuPath' WHERE id='$menuId'";
            } else {
                // Update menu tanpa mengubah foto
                $updateMenu = "UPDATE menu SET nama='$menuNama', harga='$menuHarga' WHERE id='$menuId'";
            }
            $conn->query($updateMenu);
        }
    }

    // Proses menambah menu baru
    if (isset($_POST['new_menu'])) {
        foreach ($_POST['new_menu'] as $newMenuData) {
            $newMenuNama = $newMenuData['nama'];
            $newMenuHarga = $newMenuData['harga'];

            if (isset($_FILES['new_menu']['name']) && !empty($_FILES['new_menu']['name'])) {
                $newFotoMenu = $_FILES['new_menu']['name']['foto'];
                $newFotoMenuTmp = $_FILES['new_menu']['tmp_name']['foto'];
                $newFotoMenuPath = "menuImg/" . $newFotoMenu;
                move_uploaded_file($newFotoMenuTmp, $newFotoMenuPath);

                // Insert menu baru dengan foto
                $insertMenu = "INSERT INTO menu (resto_id, nama, harga, foto) VALUES ('$id', '$newMenuNama', '$newMenuHarga', '$newFotoMenuPath')";
            } else {
                // Insert menu baru tanpa foto
                $insertMenu = "INSERT INTO menu (resto_id, nama, harga) VALUES ('$id', '$newMenuNama', '$newMenuHarga')";
            }
            $conn->query($insertMenu);
        }
    }

    echo "<script>alert('Data restoran berhasil diperbarui');</script>";
    echo "<script>window.location.href = 'home.php';</script>";
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Resto</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1>Update Resto</h1>

    <form method="post" enctype="multipart/form-data" autocomplete="off">
        <h3>Data Restoran</h3>
        <label for="resto">Nama Restoran:</label>
        <input type="text" name="resto" value="<?php echo $resto['nama']; ?>" required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" required><?php echo $resto['alamat']; ?></textarea><br>

        <label for="min-price">Harga Terendah</label>
        <input type="number" name="min-price" id="min-price" value="<?php echo $resto['min_price']; ?>"><br>

        <label for="max-price">Harga Tertinggi</label>
        <input type="number" name="max-price" id="max-price" value="<?php echo $resto['max_price']; ?>"><br>

        <label for="foto">Foto Resto</label>
        <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png">

        <h3>Data Menu</h3>
        <div id="menu-container">
            <?php if (!empty($menus)): ?>
                <?php foreach ($hasilMenu as $menu): ?>
                    <div class="menu-item">
                        <label for="menu-<?php echo $menu['id']; ?>">Nama Menu:</label>
                        <input type="text" name="menu[<?php echo $menu['id']; ?>][nama]" value="<?php echo $menu['nama']; ?>" required>

                        <label for="price-<?php echo $menu['id']; ?>">Harga Menu:</label>
                        <input type="number" name="menu[<?php echo $menu['id']; ?>][harga]" value="<?php echo $menu['harga']; ?>" required>

                        <label for="foto-<?php echo $menu['id']; ?>">Ganti Foto Menu:</label>
                        <input type="file" name="menu[<?php echo $menu['id']; ?>][foto]" accept=".jpg, .jpeg, .png"><br>

                        <button type="button" class="delete-menu" data-id="<?php echo $menu['id']; ?>">Hapus Menu</button><br>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada menu di resto ini</p>
            <?php endif; ?>
        </div>

        <button type="button" id="add-menu-button">Tambah Menu (Max 7)</button><br>
        <!-- <button type="button" id="del-menu-button">Batalkan Menu</button><br> -->
        <input type="submit" value="Submit">
    </form>
</body>

</html>

<script>
    let menuCount = 0;

    // Fungsi untuk menambah menu baru
    document.getElementById('add-menu-button').addEventListener('click', function() {
        if (menuCount < 7) {
            menuCount++;
            const menuDiv = document.createElement('div');
            menuDiv.setAttribute('id', `menu-${menuCount}`);
            menuDiv.classList.add('menu-item');
            menuDiv.innerHTML = `
                <h4>Menu ${menuCount}</h4>
                <label for="menu_name_${menuCount}">Nama Menu:</label>
                <input type="text" name="new_menu[${menuCount}][nama]" required><br>
                <label for="price_${menuCount}">Harga:</label>
                <input type="number" name="new_menu[${menuCount}][harga]" step="0.01" required><br>
                <label for="photo_${menuCount}">Foto Menu:</label>
                <input type="file" name="new_menu[${menuCount}][foto]" accept=".jpg, .jpeg, .png" required><br>
                <button type="button" class="delete-menu">Hapus Menu</button><br>
            `;
            document.getElementById('menu-container').appendChild(menuDiv);
        } else {
            alert("Maksimal 7 menu dapat ditambahkan.");
        }
    });

    // Fungsi untuk menghapus menu yang sudah ditambahkan
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-menu')) {
            const menuItem = event.target.closest('.menu-item');
            menuItem.remove();
            menuCount--; // Mengurangi jumlah menu yang ditambahkan
        }
    });

    // Fungsi untuk menghapus menu terakhir yang ditambahkan
    document.getElementById('del-menu-button').addEventListener('click', function() {
        if (menuCount > 0) {
            const lastMenu = document.getElementById(`menu-${menuCount}`);
            document.getElementById('menu-container').removeChild(lastMenu);
            menuCount -= 1;
        } else {
            alert('Anda belum menambahkan Menu!');
        }
    });
</script>