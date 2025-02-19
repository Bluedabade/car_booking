<?php
include_once "db.php";
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน!'); window.location='Login.php';</script>";
    exit();
}

// ตรวจสอบว่ามีการส่งค่ามาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);

    // ตรวจสอบว่ามีไฟล์อัปโหลดหรือไม่
    if (isset($_FILES['slip']) && $_FILES['slip']['error'] == 0) {
        $target_dir = "upload/slips/"; // โฟลเดอร์เก็บสลิป
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
        }

        // กำหนดชื่อไฟล์ใหม่เพื่อป้องกันซ้ำ
        $file_extension = pathinfo($_FILES['slip']['name'], PATHINFO_EXTENSION);
        $new_filename = "slip_" . time() . "_" . $booking_id . "." . $file_extension;
        $target_file = $target_dir . $new_filename;

        // ตรวจสอบประเภทไฟล์ (อนุญาตเฉพาะ JPG, PNG, และ PDF)
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            echo "<script>alert('อัปโหลดได้เฉพาะไฟล์ JPG, PNG หรือ PDF เท่านั้น!'); window.history.back();</script>";
            exit();
        }

        // อัปโหลดไฟล์
        if (move_uploaded_file($_FILES['slip']['tmp_name'], $target_file)) {
            // อัปเดตข้อมูลลงฐานข้อมูล
            $sql = "UPDATE tbl_booking SET payment_slip = ?, status = 'slip_uploaded' WHERE booking_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $new_filename, $booking_id, $_SESSION['user_id']);

            if ($stmt->execute()) {
                echo "<script>alert('อัปโหลดสลิปสำเร็จ! รอการตรวจสอบจากแอดมิน'); window.location='mybooking_detail.php?id=$booking_id';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล!'); window.history.back();</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('กรุณาเลือกไฟล์ที่ต้องการอัปโหลด!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('คำขอไม่ถูกต้อง!'); window.history.back();</script>";
}

$conn->close();
?>
