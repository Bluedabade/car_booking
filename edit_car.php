<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cm_id = intval($_GET['id']);

    // ดึงข้อมูลรถจากฐานข้อมูล
    $sql = "SELECT * FROM car_modal WHERE cm_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
}
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>แก้ไขข้อมูลรถ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center text-primary">แก้ไขข้อมูลรถ</h2>
    <form action="update_car.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cm_id" value="<?php echo $car['cm_id']; ?>">

        <label class="form-label">ชื่อรุ่นรถ</label>
        <input type="text" class="form-control mb-3" name="cm_modal" value="<?php echo $car['cm_modal']; ?>" required>

        <label class="form-label">ราคาเช่า (บาท/วัน)</label>
        <input type="number" class="form-control mb-3" name="cm_price" value="<?php echo $car['cm_price']; ?>" required>

        <label class="form-label">จำนวนรถที่มี</label>
        <input type="number" class="form-control mb-3" name="cm_stock" value="<?php echo $car['cm_stock']; ?>" required>

        <label class="form-label">อัปโหลดรูปภาพใหม่ (เว้นว่างไว้ถ้าไม่เปลี่ยน)</label>
        <input type="file" class="form-control mb-3" name="cm_img">

        <button type="submit" name="update" class="btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
    </form>
</div>

</body>
</html>
