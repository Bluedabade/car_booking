<?php
session_start();
    include_once "db.php";

    if (isset($_POST['submit'])) {
        $temp = explode('.', $_FILES['imgcar1']['name']);
        $filename = rand() . '.' . end($temp);
        $filepath = "upload2/" . $filename;
        $namecar1 = $_POST['namecar1'];
        $idcar1 = $_POST['idcar1'];
       
       

        

        if (move_uploaded_file($_FILES['imgcar1']['tmp_name'], $filepath)){

            $sql = "INSERT INTO `vd_img`(`v_img`, `v_namecar`, `v_idcar`) 
            VALUES ('$filename','$namecar1','$idcar1')";
            $result = mysqli_query($conn, $sql);

        }else{
            $sql = "INSERT INTO `vd_img`(`v_img`, `v_namecar`, `v_idcar`) 
            VALUES ('$filename','$namecar1','$idcar1')";
            $result = mysqli_query($conn, $sql);
        }

        if ($result) {
        echo "<script>alert('สำเร็จ'); window.location='./toyota2.php';</script>";
        } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
        }   
}
?>