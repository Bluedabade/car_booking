<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_test";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบค่าที่รับเข้ามา
if (isset($_GET['car_id']) && is_numeric($_GET['car_id']) &&
    isset($_POST['car_image']) && isset($_POST['car_name']) && isset($_POST['car_price']) && isset($_POST['car_status'])) {
    
    // รับค่าและป้องกัน SQL Injection
    $car_id = intval($_GET['car_id']);
    $car_image = mysqli_real_escape_string($conn, $_POST['car_image']);
    $car_name = mysqli_real_escape_string($conn, $_POST['car_name']);

    // ตรวจสอบและแปลง car_price
    $car_price = filter_var($_POST['car_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $car_price = ($car_price !== false) ? floatval($car_price) : 0;

    // ตรวจสอบราคา
    if ($car_price <= 0) {
        echo "<script>alert('ราคาต้องเป็นตัวเลขที่มากกว่า 0'); history.back();</script>";
        exit;
    }

    // รับค่า car_status
    $car_status = mysqli_real_escape_string($conn, $_POST['car_status']);

    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $update_sql = "UPDATE `tb_order` SET `car_image`=?, `car_name`=?, `car_price`=?, `car_status`=? WHERE `car_id`=?";
    $stmt = mysqli_prepare($conn, $update_sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . mysqli_error($conn));
    }

    // ผูกค่าและรันคำสั่ง SQL
    mysqli_stmt_bind_param($stmt, "ssdsi", $car_image, $car_name, $car_price, $car_status, $car_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('จองรถสำเร็จ!'); window.location='carplay.php';</script>";
        header("Location: carplay.php");
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_stmt_error($stmt);
    }

    // ปิด Statement
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('ข้อมูลไม่ถูกต้อง!'); history.back();</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
