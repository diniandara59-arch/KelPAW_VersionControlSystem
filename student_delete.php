<?php
  session_start();
  if (!isset($_SESSION["username"])) {
     header("Location: login.php");
     exit();
  }

  include("connection.php");

  if (isset($_GET["nim"])) {
    $nim = htmlentities(strip_tags(trim($_GET["nim"])));
    $nim = mysqli_real_escape_string($connection, $nim);

    // Ambil nama mahasiswa untuk pesan notifikasi
    $query_get = "SELECT name FROM student WHERE nim = '$nim'";
    $result_get = mysqli_query($connection, $query_get);
    $data = mysqli_fetch_assoc($result_get);
    $name = $data["name"] ?? '';

    // Query hapus data
    $query = "DELETE FROM student WHERE nim = '$nim'";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $message = "Mahasiswa dengan nama = \"<b>$name</b>\" berhasil dihapus";
      $message = urlencode($message);
      header("Location: student_view.php?message={$message}");
    } else {
      die("Query gagal dijalankan: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
    }
  } else {
    header("Location: student_view.php");
  }

  mysqli_close($connection);
?>