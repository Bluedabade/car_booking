<?php
session_start();
require_once "db.php"; // ใช้ require_once แทน include_once เพื่อป้องกันการโหลดไฟล์ซ้ำ

// ตรวจสอบว่ามีการส่งค่า id และเป็นตัวเลข
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = intval($_GET['id']); // แปลงเป็นตัวเลขเพื่อป้องกัน SQL Injection

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL สำหรับลบข้อมูล
    $sql = "DELETE FROM tbl_test WHERE m_id = ?";

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['delete'] = "success";
        } else {
            $_SESSION['delete'] = "error";
        }

        $stmt->close();
    } else {
        $_SESSION['delete'] = "error";
    }

    $conn->close();
} 

// Redirect ไปหน้า index.php ทันที
header("Location: member.php");
exit();
