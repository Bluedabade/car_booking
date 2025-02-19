<?php
include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $cm_modal = trim($_POST['cm_modal']);
    $cm_cate = trim($_POST['cm_cate']);
    $cm_price = trim($_POST['cm_price']);
    $cm_stock = trim($_POST['cm_stock']);

    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["cm_img"]["name"]);
    $cm_img = null;

    if (move_uploaded_file($_FILES["cm_img"]["tmp_name"], $target_file)) {
        $cm_img = $_FILES["cm_img"]["name"];
    }

    $sql = "INSERT INTO car_modal (cm_modal, cm_cate, cm_img, cm_price, cm_stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $cm_modal, $cm_cate, $cm_img, $cm_price, $cm_stock);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มรุ่นรถสำเร็จ'); window.location='car_manage.php?brand=$cm_cate';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
