<?php
session_start();
include_once "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $name = trim($_POST['firstlast']);
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);
    $mpassword = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $idcard = trim($_POST['idcard']);

    $filename = null;

    if (!empty($_FILES['img']['name'])) {
        $temp = explode('.', $_FILES['img']['name']);
        $filename = rand() . '.' . end($temp);
        $filepath = "upload/" . $filename;

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $filepath)) {
            $filename = null;
        }
    }

    $sql = "INSERT INTO `tbl_test` (`m_first`, `m_user`, `m_pass`, `m_mpass`, `m_phone`, `m_email`, `m_address`, `m_idcard`, `m_img`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $username, $password, $mpassword, $phone, $email, $address, $idcard, $filename);

    if ($stmt->execute()) {
        echo "<script>alert('สำเร็จ'); window.location='./member.php';</script>";
    } else {
        echo "<script>alert('ไม่สำเร็จ'); window.location='./index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
