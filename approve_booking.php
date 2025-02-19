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

// ดึงข้อมูลการจองเพื่อตรวจสอบรายละเอียด
$sql = "SELECT b.booking_id, b.car_id, c.cm_stock
        FROM tbl_booking AS b
        JOIN car_modal AS c ON b.car_id = c.cm_id
        WHERE b.booking_id = ? AND (b.status = 'pending' OR b.status = 'slip_uploaded')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "<script>alert('ไม่สามารถอนุมัติการจองนี้ได้!'); window.location='booking_manage.php';</script>";
    exit();
}

$car_id = $booking['car_id'];
$current_stock = $booking['cm_stock'];

// ตรวจสอบว่ารถยังมีสต็อกหรือไม่


// อัปเดตสถานะการจองเป็น "approved"
$sql_update = "UPDATE tbl_booking SET status = 'approved' WHERE booking_id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("i", $booking_id);
$stmt_update->execute();
$stmt_update->close();


echo "<script>
    alert('✅ อนุมัติการจองสำเร็จ!');
    window.location='booking_manage.php';
</script>";

$conn->close();
?>
