<?php
session_start();
    include_once "db.php";

    if (isset($_POST['submit'])) {
        $temp = explode('.', $_FILES['imgcar']['name']);
        $filename = rand() . '.' . end($temp);
        $filepath = "upload1/" . $filename;
        $namecar = $_POST['namecar'];
        $idcar = $_POST['idcar'];
       
        if (move_uploaded_file($_FILES['imgcar']['tmp_name'], $filepath)){

            $sql = "INSERT INTO `db_img`(`c_img`, `c_namecar`, `c_idcar`) 
            VALUES ('$filename','$namecar','$idcar')";
            $result = mysqli_query($conn, $sql);

        }else{

            $sql = "INSERT INTO `db_img`(`c_img`, `c_namecar`, `c_idcar`) 
            VALUES ('$namecar','$idcar')";
            $result = mysqli_query($conn, $sql);
        }

        if ($result) {
        echo "<script>alert('สำเร็จ'); window.location='./admin.php';</script>";
        } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
        }   
}
?>