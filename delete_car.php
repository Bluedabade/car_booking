<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cm_id = intval($_GET['id']);

    // ลบข้อมูลรถ
    $sql = "DELETE FROM car_modal WHERE cm_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cm_id);

    if ($stmt->execute()) {
        echo "<script>alert('ลบรถสำเร็จ'); window.history.back();</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
