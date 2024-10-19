<?php
include 'dbcon.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
}

$sessionUsername = $_SESSION['username'];
$sessionMitra = $_SESSION['is_mitra'];
$sessionId = $_SESSION['id'];

$resto = htmlspecialchars($_POST['nama']);
$alamat = htmlspecialchars($_POST['alamat']);
$minPrice = htmlspecialchars($_POST['min-price']);
$maxPrice = htmlspecialchars($_POST['max-price']);

// validasi harga
if ($minPrice > $maxPrice) {
    echo "
    <script>
    alert('Harga terendah tidak boleh melebihi harga tertinggi, silahkan ulangi proses');
    window.location.href = 'inputResto.php';
    </script>
    ";
    exit;
}

$target_dir = "image/"; // folder tempat menyimpan gambar
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Validasi apakah file yang diupload adalah gambar
$check = getimagesize($_FILES["foto"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "<script>alert('File bukan gambar!');</script>";
    $uploadOk = 0;
}

// Cek jika file sudah ada
if (file_exists($target_file)) {
    echo "<script>alert('File sudah ada.');</script>";
    $uploadOk = 0;
}

// Batasi ukuran file (misalnya maksimal 10MB)
if ($_FILES["foto"]["size"] > 10000000) {
    echo "<script>alert('Ukuran file terlalu besar!');</script>";
    $uploadOk = 0;
}

// Batasi tipe file yang bisa diupload
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan!');</script>";
    $uploadOk = 0;
}

// Cek apakah uploadOk 0 karena ada error
if ($uploadOk == 0) {
    echo "<script>alert('File tidak bisa diupload!');</script>";
} else {
    // Jika semua validasi ok, pindahkan file ke folder tujuan
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        // Insert data restoran ke database
        $query = "INSERT INTO resto (nama, alamat, min_price, max_price, foto) 
                      VALUES ('$nama', '$alamat', '$min_price', '$max_price', '$target_file')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Restoran berhasil ditambahkan!');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat upload gambar.');</script>";
    }
}

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
            <h3>Data Restoran</h3>
            <label for="resto">Nama Restoran:</label>
            <input type="text" name="resto" required><br>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" required></textarea><br>

            <label for="min-price">Harga Terendah</label>
            <input type="number" name="min-price" id="min-price">

            <label for="max-price">Harga Tertinggi</label>
            <input type="number" name="max-price" id="max-price">

            <label for="foto">Foto Resto</label>
            <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png">

            <h3>Data Menu</h3>
            <div id="menu-container">
                <!-- Tempat input menu akan di sini -->
            </div>

            <button type="button" id="add-menu-button">Tambah Menu (Max 7)</button><br>
            <input type="submit" value="Submit">
        </form>
    </main>
</body>

</html>

<script>
    let menuCount = 0;
    document.getElementById('add-menu-button').addEventListener('click', function() {
        if (menuCount < 7) {
            menuCount++;
            const menuDiv = document.createElement('div');
            menuDiv.innerHTML = `
                    <h4>Menu ${menuCount}</h4>
                    <label for="menu_name_${menuCount}">Nama Menu:</label>
                    <input type="text" name="menu_name[]" required><br>
                    <label for="price_${menuCount}">Harga:</label>
                    <input type="number" name="price[]" step="0.01" required><br>
                    <label for="photo_${menuCount}">Foto Menu:</label>
                    <input type="file" name="photo[]" accept="image/*" required><br>
                `;
            document.getElementById('menu-container').appendChild(menuDiv);
        } else {
            alert("Maksimal 7 menu dapat ditambahkan.");
        }
    });
</script>