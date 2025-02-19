<?php
session_start();
    include_once "db.php";

    if (isset($_POST['submit'])) {
        $temp = explode('.', $_FILES['imgcar4']['name']);
        $filename = rand() . '.' . end($temp);
        $filepath = "upload5/" . $filename;
        $namecar4 = $_POST['namecar4'];
        $idcard4 = $_POST['idcard'];
       
       

        

        if (move_uploaded_file($_FILES['imgcar4']['tmp_name'], $filepath)){

            $sql = "INSERT INTO `is_img`(`s_img`, `s_namecar`, `s_idcard`) 
            VALUES ('$filename','$namecar4','$idcar4')";
            $result = mysqli_query($conn, $sql);

        }else{
            $sql = "INSERT INTO `is_img`(`s_img`, `s_namecar`, `s_idcard`) 
            VALUES ('$filename','$namecar4','$idcar4')";
            $result = mysqli_query($conn, $sql);
        }

        if ($result) {
        echo "<script>alert('สำเร็จ'); window.location='./isuzu2.php';</script>";
        } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
        }   
}
?>