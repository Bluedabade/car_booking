<?php
include_once "db.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้!'); window.location='index.php';</script>";
    exit();
}

$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id <= 0) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='booking_manage.php';</script>";
    exit();
}

$sql = "SELECT car_id FROM tbl_booking WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='booking_manage.php';</script>";
    exit();
}

$car_id = $booking['car_id'];

$sql = "UPDATE tbl_booking SET status = 'returned' WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$stmt->close();

$sql = "UPDATE car_modal SET cm_stock = cm_stock + 1 WHERE cm_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo "<script>alert('คืนรถสำเร็จและเพิ่มสต๊อกเรียบร้อย!'); window.location='booking_manage.php';</script>";
?>
