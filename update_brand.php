<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $cc_id = intval($_POST['cc_id']);
    $cc_cate = trim($_POST['cc_cate']);

    // ดึงข้อมูลปัจจุบันของยี่ห้อรถจากฐานข้อมูล
    $sql = "SELECT cc_img FROM car_cate WHERE cc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = $result->fetch_assoc();
    $cc_img = $brand['cc_img']; // ใช้รูปเดิมเป็นค่าเริ่มต้น

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
    if (!empty($_FILES["cc_img"]["name"])) {
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["cc_img"]["name"]);

        // ลบรูปเก่าถ้ามี
        if (!empty($cc_img) && file_exists($target_dir . $cc_img)) {
            unlink($target_dir . $cc_img);
        }

        // อัปโหลดรูปใหม่
        if (move_uploaded_file($_FILES["cc_img"]["tmp_name"], $target_file)) {
            $cc_img = $_FILES["cc_img"]["name"]; // ใช้รูปใหม่ที่อัปโหลด
        }
    }

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE car_cate SET cc_cate=?, cc_img=? WHERE cc_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $cc_cate, $cc_img, $cc_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตยี่ห้อรถสำเร็จ!'); window.location='brand_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
