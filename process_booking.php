<?php
include_once "db.php";
session_start();

$car_id = intval($_POST['car_id']);
$brand = trim($_POST['brand']);
$user_id = intval($_POST['user_id']);
$pickup_date = trim($_POST['pickup_date']);
$return_date = trim($_POST['return_date']);
$pickup_location = trim($_POST['pickup_location']);
$return_location = trim($_POST['return_location']);
$total_price = isset($_POST['total_price']) ? floatval(str_replace(['฿', ','], '', $_POST['total_price'])) : 0;

// ตรวจสอบว่ายังมีสต๊อกรถอยู่หรือไม่
$sql_check_stock = "SELECT cm_stock FROM car_modal WHERE cm_id = ?";
$stmt_check_stock = $conn->prepare($sql_check_stock);
$stmt_check_stock->bind_param("i", $car_id);
$stmt_check_stock->execute();
$result_check_stock = $stmt_check_stock->get_result();
$row = $result_check_stock->fetch_assoc();

if ($row['cm_stock'] <= 0) {
    echo "<script>alert('รถรุ่นนี้หมดสต๊อกแล้ว!'); window.history.back();</script>";
    exit();
}

// บันทึกข้อมูลการจอง
$sql = "INSERT INTO tbl_booking (user_id, car_id, brand, pickup_date, return_date, pickup_location, return_location, total_price, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssssd", $user_id, $car_id, $brand, $pickup_date, $return_date, $pickup_location, $return_location, $total_price);
$stmt->execute();

// ตัดสต๊อกรถ (ลดลง 1 คัน)
$sql_update_stock = "UPDATE car_modal SET cm_stock = cm_stock - 1 WHERE cm_id = ?";
$stmt_update_stock = $conn->prepare($sql_update_stock);
$stmt_update_stock->bind_param("i", $car_id);
$stmt_update_stock->execute();

echo "<script>alert('จองรถสำเร็จ'); window.location='index.php';</script>";

$stmt->close();
$stmt_update_stock->close();
$conn->close();
?>
