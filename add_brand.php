<?php
include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $cc_cate = trim($_POST['cc_cate']);

    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["cc_img"]["name"]);
    $cc_img = null;

    if (move_uploaded_file($_FILES["cc_img"]["tmp_name"], $target_file)) {
        $cc_img = $_FILES["cc_img"]["name"];
    }

    $sql = "INSERT INTO car_cate (cc_cate, cc_img) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cc_cate, $cc_img);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มยี่ห้อรถสำเร็จ'); window.location='brand_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
