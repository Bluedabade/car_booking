<?php
session_start();  // เรียกใช้ session_start() เพื่อให้สามารถใช้งาน SESSION ได้
include_once "db.php";

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("<script>alert('ไม่สามารถเชื่อมต่อฐานข้อมูล'); window.location='./buy.php';</script>");
}

if (isset($_POST['submit'])) {
    // รับค่าจากฟอร์ม
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $citizen_id = trim($_POST['address2']); // เปลี่ยนชื่อให้เข้าใจง่าย
    $pickup_location = trim($_POST['pickup_location']);  // เปลี่ยนจาก $country
    $return_location = trim($_POST['return_location']);  // เปลี่ยนจาก $state
    $pickup_time = !empty($_POST['pickup_time']) ? date('Y-m-d H:i:s', strtotime($_POST['pickup_time'])) : NULL;
    $return_time = !empty($_POST['return_time']) ? date('Y-m-d H:i:s', strtotime($_POST['return_time'])) : NULL;

    // ตรวจสอบว่าข้อมูลครบถ้วน
    if (empty($firstname) || empty($lastname) || empty($email) || empty($address) || empty($citizen_id) || empty($pickup_location) || empty($return_location) || empty($pickup_time) || empty($return_time)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.location='./buy.php';</script>";
        exit();
    }

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO `by_test` (`y_firstname`, `y_lastname`, `y_email`, `y_address`, `y_address2`, `pickuplocation`, `returnlocation`, `y_pickup`, `y_return`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $email, $address, $citizen_id, $pickup_location, $return_location, $pickup_time, $return_time);

        if (mysqli_stmt_execute($stmt)) {
            // เก็บเฉพาะค่าที่จำเป็นใน SESSION
            $_SESSION['user_data'] = compact('firstname', 'lastname', 'email', 'address', 'citizen_id', 'pickup_location', 'return_location', 'pickup_time', 'return_time');

            // เปลี่ยนเส้นทางไปยังหน้า buycar.php
            header("Location: ./buycar.php");
            exit();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "'); window.location='./buy.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn) . "'); window.location='./buy.php';</script>";
    }

    mysqli_close($conn);
}

// แสดงข้อมูลใน SESSION
if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
?>
    <h1>ข้อมูลผู้ใช้</h1>
    <p>ชื่อ: <?= htmlspecialchars($user_data['firstname']) ?></p>
    <p>นามสกุล: <?= htmlspecialchars($user_data['lastname']) ?></p>
    <p>อีเมล: <?= htmlspecialchars($user_data['email']) ?></p>
    <p>ที่อยู่: <?= htmlspecialchars($user_data['address']) ?></p>
    <p>บัตรประชาชน: <?= htmlspecialchars($user_data['address2']) ?></p>
    <p>สถานที่รับรถ: <?= htmlspecialchars($user_data['pickup_location']) ?></p>
    <p>สถานที่คืนรถ: <?= htmlspecialchars($user_data['return_location']) ?></p>
    <p>วันที่และเวลารับรถ: <?= (!empty($user_data['pickup_time']) ? date('d/m/Y H:i', strtotime($user_data['pickup_time'])) : "ไม่มีข้อมูล") ?></p>
    <p>วันที่และเวลาคืนรถ: <?= (!empty($user_data['return_time']) ? date('d/m/Y H:i', strtotime($user_data['return_time'])) : "ไม่มีข้อมูล") ?></p>
<?php
} else {
    echo "<h1>ไม่มีข้อมูลใน SESSION</h1>";
}
?>
