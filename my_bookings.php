<?php
include_once "db.php";
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ!'); window.location='Login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงรายการจองของผู้ใช้
$sql = "SELECT b.booking_id, b.pickup_date, b.return_date, b.total_price, b.status, 
               c.cm_modal, c.cm_img 
        FROM tbl_booking AS b
        JOIN car_modal AS c ON b.car_id = c.cm_id
        WHERE b.user_id = ?
        ORDER BY b.booking_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการจองของฉัน</title>
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

        .booking-card {
            border-radius: 15px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s;
        }

        .booking-card:hover {
            transform: scale(1.02);
        }

        .car-img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .btn-details {
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container mt-4">
        <h2 class="text-center">📋 รายการจองของฉัน</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($booking = $result->fetch_assoc()): ?>
                    <div class="col-md-6">
                        <div class="card booking-card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4 text-center">
                                    <img src="./upload/<?php echo htmlspecialchars($booking['cm_img']); ?>" class="car-img" alt="รถ">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">🚗 <?php echo htmlspecialchars($booking['cm_modal']); ?></h5>
                                        <p class="card-text">📅 รับรถ: <b><?php echo $booking['pickup_date']; ?></b></p>
                                        <p class="card-text">📅 คืนรถ: <b><?php echo $booking['return_date']; ?></b></p>
                                        <p class="card-text">💰 ราคารวม: <span class="text-danger">฿<?php echo number_format($booking['total_price'], 2); ?></span></p>
                                        <p class="card-text">
                                            📌 สถานะ:
                                            <span class="badge bg-<?php echo ($booking['status'] == 'approved') ? 'success' : 'warning'; ?> status-badge">
                                                <?php echo strtoupper($booking['status']); ?>
                                            </span>
                                        </p>
                                        <a href="mybooking_detail.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-primary btn-sm btn-details">
                                            🔍 ดูรายละเอียด
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">❌ คุณยังไม่มีรายการจอง</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>