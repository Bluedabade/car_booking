<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $cm_id = intval($_POST['cm_id']);
    $cm_modal = trim($_POST['cm_modal']);
    $cm_price = trim($_POST['cm_price']);
    $cm_stock = trim($_POST['cm_stock']);
    $cm_cate = trim($_POST['cm_cate']);
    
    // ดึงชื่อไฟล์รูปภาพปัจจุบันจากฐานข้อมูล
    $sql = "SELECT cm_img FROM car_modal WHERE cm_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    $cm_img = $car['cm_img']; // ใช้รูปเดิมเป็นค่าเริ่มต้น
    
    // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
    if (!empty($_FILES["cm_img"]["name"])) {
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["cm_img"]["name"]);
        if (move_uploaded_file($_FILES["cm_img"]["tmp_name"], $target_file)) {
            $cm_img = $_FILES["cm_img"]["name"]; // ใช้รูปใหม่ที่อัปโหลด
        }
    }

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE car_modal SET cm_modal=?, cm_price=?, cm_stock=?, cm_img=? WHERE cm_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $cm_modal, $cm_price, $cm_stock, $cm_img, $cm_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตรถสำเร็จ'); window.location='car_manage.php?brand=$cm_cate';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
