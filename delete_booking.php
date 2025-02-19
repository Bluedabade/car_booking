<?php
include_once "db.php";
session_start();

// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้!'); window.location='index.php';</script>";
    exit();
}

// รับค่า booking_id จาก URL
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id <= 0) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='booking_manage.php';</script>";
    exit();
}

// ลบข้อมูลการจองจากฐานข้อมูล
$sql = "DELETE FROM tbl_booking WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    echo "<script>alert('ลบข้อมูลการจองสำเร็จ!'); window.location='booking_manage.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล!'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
