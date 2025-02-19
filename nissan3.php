<?php
session_start();
include_once "db.php";

if (isset($_POST['submit'])) {
    $temp = explode('.', $_FILES['imgcar2']['name']);
    $filename = rand() . '.' . end($temp);
    $filepath = "upload4/" . $filename;
    $namecar2 = $_POST['namecar2'];
    $idcar2 = $_POST['idcar2'];

    if (move_uploaded_file($_FILES['imgcar2']['tmp_name'], $filepath)) {

        $sql = "INSERT INTO `bd_img`(`b_img`, `b_carname`, `b_idcar`) 
            VALUES ('$filename','$namecar2','$idcar2')";
        $result = mysqli_query($conn, $sql);
    } else {

        $sql = "INSERT INTO `bd_img`(`b_img`, `b_carname`, `b_idcar`) 
            VALUES ('$filename','$namecar2','$idcar2')";
        $result = mysqli_query($conn, $sql);
    }

    if ($result) {
        echo "<script>alert('สำเร็จ'); window.location='./nissan2.php';</script>";
    } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
    }
}
