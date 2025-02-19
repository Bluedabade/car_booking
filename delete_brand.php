<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cc_id = intval($_GET['id']);

    // ดึงชื่อไฟล์รูปภาพเพื่อลบออกจากโฟลเดอร์
    $sql = "SELECT cc_img FROM car_cate WHERE cc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = $result->fetch_assoc();

    // ลบรูปภาพจากเซิร์ฟเวอร์ถ้ามี
    if (!empty($brand['cc_img']) && file_exists("upload/" . $brand['cc_img'])) {
        unlink("upload/" . $brand['cc_img']);
    }

    // ลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM car_cate WHERE cc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cc_id);

    if ($stmt->execute()) {
        echo "<script>alert('ลบยี่ห้อรถสำเร็จ!'); window.location='brand_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
