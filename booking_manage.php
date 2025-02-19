<?php
include_once "db.php";
session_start();

// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้!'); window.location='index.php';</script>";
    exit();
}

// ดึงข้อมูลการจองทั้งหมด
$sql = "SELECT b.booking_id, b.user_id, u.m_first, u.m_phone, b.car_id, c.cm_modal, b.pickup_date, 
               b.return_date, b.pickup_location, b.return_location, b.total_price, b.status
        FROM tbl_booking AS b
        JOIN tbl_test AS u ON b.user_id = u.m_id
        JOIN car_modal AS c ON b.car_id = c.cm_id
        ORDER BY b.booking_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการการจอง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: "Athiti";
            src: url("./font/Athiti-Medium.ttf") format("truetype");
        }

        body {
            font-family: "Athiti";
            background-color: #FFF7D1;
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container mt-4">
        <h2 class="text-center">📋 รายการการจองทั้งหมด</h2>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ลูกค้า</th>
                    <th>เบอร์โทร</th>
                    <th>รถ</th>
                    <th>วันที่รับ</th>
                    <th>วันที่คืน</th>
                    <th>สถานที่รับ</th>
                    <th>สถานที่คืน</th>
                    <th>ราคารวม</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['m_first']); ?></td>
                        <td><?php echo htmlspecialchars($row['m_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['cm_modal']); ?></td>
                        <td><?php echo $row['pickup_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                        <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['return_location']); ?></td>
                        <td>฿<?php echo number_format($row['total_price'], 2); ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($row['status'] == 'approved') ? 'success' : 'warning'; ?>">
                                <?php echo strtoupper($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="booking_detail.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-info">ดูรายละเอียด</a>
                            <a href="delete_booking.php?id=<?php echo $row['booking_id']; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('ยืนยันการลบการจองนี้หรือไม่?');">
                                ❌ ลบ
                            </a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>