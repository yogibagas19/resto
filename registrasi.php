<?php
require 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_BCRYPT));
    $is_mitra = $_POST['is_mitra'];

    $queryRegis = "insert into users (username, password, is_mitra) values ('$username', '$password', '$is_mitra')";
    
    if (mysqli_query($conn, $queryRegis)) {
        echo "<script>
        alert('Registrasi Berhasil! Anda akan diarahkan ke halaman Login.')
        window.location.href ='/login.php';
        </script>";
        // header("Location: login.php");
        exit();
    } else {
        echo "error: " . $queryRegis . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>

<body>
    <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" name="username" id="username" autocomplete="off"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password"><br>

        <label for="is_mitra">Apakah Anda ingin menjadi Mitra?</label><br>
        <input type="radio" id="mitra_yes" name="is_mitra" value="1">
        <label for="mitra_yes">Ya</label><br>
        <input type="radio" id="mitra_no" name="is_mitra" value="0" checked>
        <label for="mitra_no">Tidak</label><br><br>

        <input type="submit" value="Daftar">
    </form>
    <a href="index.html">Kembali</a>
</body>

</html>