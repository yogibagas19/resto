<?php
require 'dbcon.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = htmlspecialchars($_POST['username']); // Sanitasi input
    $password = htmlspecialchars($_POST['password']);

    $queryLogin = "select * from users where username = '$username'";

    $hasil = mysqli_query($conn, $queryLogin);

    if($hasil->num_rows > 0){
        $row = $hasil->fetch_assoc();

        if(password_verify($password, $row['password'])){
            // set session username, id, dan informasi mitra
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_mitra'] = $row['is_mitra'];
            $_SESSION['id'] = $row['id'];

            header("Location: home.php");
            
        }else{
            echo "Password Salah";
        }
    }else{
        echo "<script>alert('Username Tidak ditemukan');
        window.location.href = 'login.php';
        </script>
        ";
    }

    $conn->close();

//     // Cek apakah pengguna sudah terdaftar
//     $queryLogin = "SELECT * FROM login WHERE username = '$username'";
//     $hasil = mysqli_query($conn, $queryLogin);

//     if ($hasil->num_rows == 1) {
//         // Pengguna sudah terdaftar, buat sesi dan arahkan ke index
//         $_SESSION['username'] = $username;
//         header("Location: home.php");
//         exit();
//     } else {
//         // Pengguna baru, masukkan ke database
//         $queryInsert = "INSERT INTO login (username) VALUES ('$username')";
//         if (mysqli_query($conn, $queryInsert)) {
//             $_SESSION['username'] = $username; // Buat sesi untuk pengguna baru
//             echo "<script>alert('Registrasi berhasil! Login sebagai $username');</script>";
//             header("Location: home.php");
//             exit();
//         } else {
//             echo "<script>alert('Gagal mendaftarkan user baru!');</script>";
//         }
//     }
}

// Jika pengguna sudah memiliki sesi, arahkan ke index
if (isset($_SESSION["username"])) {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <header>
        <p>Ini Header</p>
    </header>

    <div class="wrapper-login">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>