<?php
session_start();
include_once "db.php";

if (isset($_POST['submit'])) {
    $temp = explode('.', $_FILES['imgcar3']['name']);
    $filename = rand() . '.' . end($temp);
    $filepath = "upload3/" . $filename;
    $namecar = $_POST['namecar3'];
    $idcar = $_POST['idcar3'];

    if (move_uploaded_file($_FILES['imgcar3']['tmp_name'], $filepath)) {

        $sql = "INSERT INTO `nd_img`(`n_img`, `n_namecar`, `n_idcar`) 
            VALUES ('$filename','$namecar','$idcar')";
        $result = mysqli_query($conn, $sql);
    } else {
        
        $sql = "INSERT INTO `nd_img`(`n_img`, `n_namecar`, `n_idcar`) 
            VALUES ('$filename','$namecar','$idcar')";
        $result = mysqli_query($conn, $sql);
    }

    if ($result) {
        echo "<script>alert('สำเร็จ'); window.location='./mg2.php';</script>";
    } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
    }
}
