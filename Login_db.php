<?php
session_start();
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM `tbl_test` WHERE m_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // ตรวจสอบรหัสผ่าน (ถ้ามีการใช้ password_hash())
        if ($pass == $row['m_pass']) {
            // ตั้งค่า SESSION
            $_SESSION['user_id'] = $row['m_id'];
            $_SESSION['user'] = $row['m_user'];
            $_SESSION['role'] = $row['m_permis'];

            // ตรวจสอบสิทธิ์แล้วนำทางไปยังหน้าที่ถูกต้อง
            if ($_SESSION['role'] === "admin") {
                echo "<script>alert('เข้าสู่ระบบสำเร็จ (แอดมิน)'); window.location='member.php';</script>";
            } else {
                echo "<script>alert('เข้าสู่ระบบสำเร็จ (สมาชิก)'); window.location='index.php';</script>";
            }
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('ไม่พบอีเมลนี้ในระบบ'); window.history.back();</script>";
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
