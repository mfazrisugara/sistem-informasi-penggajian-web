<?php
session_start();

include "config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");

$data = mysqli_fetch_assoc($query);

if ($data) {

    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {

        header("Location: admin/dashboard.php");

    } else {

        header("Location: pimpinan/dashboard.php");

    }

} else {

    echo "
    <script>
        alert('Username atau Password Salah');
        window.location='login.php';
    </script>
    ";

}
?>