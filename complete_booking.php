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

// ตรวจสอบว่าวันนี้เป็นวันรับรถหรือไม่
$sql = "SELECT pickup_date FROM tbl_booking WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

$today = date("Y-m-d");
if ($booking['pickup_date'] !== $today) {
    echo "<script>alert('ไม่สามารถเปลี่ยนสถานะเป็นเสร็จสิ้นได้ เนื่องจากยังไม่ถึงวันรับรถ'); window.location='booking_detail.php?id=$booking_id';</script>";
    exit();
}

// อัปเดตสถานะการจองเป็น "completed"
$sql = "UPDATE tbl_booking SET status = 'completed' WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    echo "<script>alert('การจองถูกทำเครื่องหมายว่าเสร็จสิ้นแล้ว!'); window.location='booking_manage.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
