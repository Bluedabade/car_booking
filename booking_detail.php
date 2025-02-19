<?php
include_once "db.php";
session_start();

// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้!'); window.location='index.php';</script>";
    exit();
}

// รับค่า booking_id
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($booking_id <= 0) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='booking_manage.php';</script>";
    exit();
}

// ดึงข้อมูลการจอง
$sql = "SELECT b.*, c.cm_modal, c.cm_img, u.m_first, u.m_user, u.m_phone, u.m_email, u.m_address, u.m_idcard, u.m_img
        FROM tbl_booking AS b
        JOIN tbl_test AS u ON b.user_id = u.m_id
        JOIN car_modal AS c ON b.car_id = c.cm_id
        WHERE b.booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='booking_manage.php';</script>";
    exit();
}

$today = date("Y-m-d");
$is_pickup_day = ($today >= $booking['pickup_date']); // อยู่ในวันที่รับรถหรือหลังจากนั้น
$is_return_day = ($today >= $booking['return_date']); // อยู่ในวันที่คืนรถหรือหลังจากนั้น
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายละเอียดการจอง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @font-face {
            font-family: "Athiti";
            src: url("./font/Athiti-Medium.ttf") format("truetype");
        }

        body {
            font-family: "Athiti";
            background-color: #FFF7D1;
        }

        .card {
            border-radius: 15px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #00FFD1;
            margin-bottom: 10px;
        }

        .car-img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            display: block;
            margin: auto;
        }

        .status-badge {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }

        .info-box {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .info-title {
            font-weight: bold;
            color: #333;
        }

        .user-info {
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* สีของสถานะ */
        .status-pending { background-color: #FFD700; color: #000; }
        .status-slip_uploaded { background-color: #17A2B8; color: #fff; }
        .status-approved { background-color: #28A745; color: #fff; }
        .status-completed { background-color: #007BFF; color: #fff; }
        .status-cancelled { background-color: #DC3545; color: #fff; }

        /* เพิ่มการซูมภาพ */
        .slip-preview {
            width: 150px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .slip-preview:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container mt-4 text-center">
        <h2 class="mb-4">📋 รายละเอียดการจอง #<?php echo $booking['booking_id']; ?></h2>

        <div class="card">
            <div class="row">
                <!-- 🔵 ข้อมูลลูกค้า -->
                <div class="col-md-5 text-center">
                    <img src="./upload/<?php echo htmlspecialchars($booking['m_img']); ?>" class="profile-img" alt="โปรไฟล์">
                    <h4 class="fw-bold text-primary"><?php echo htmlspecialchars($booking['m_first']); ?></h4>
                    <p class="user-info">👤 <b>ชื่อผู้ใช้:</b> <?php echo htmlspecialchars($booking['m_user']); ?></p>
                    <p class="user-info">📞 <b>เบอร์โทร:</b> <?php echo htmlspecialchars($booking['m_phone']); ?></p>
                    <p class="user-info">📧 <b>อีเมล:</b> <?php echo htmlspecialchars($booking['m_email']); ?></p>
                </div>

                <!-- 🔴 ข้อมูลรถที่จอง -->
                <div class="col-md-7">
                    <h5>🚗 รถที่จอง: <span class="text-primary"><?php echo htmlspecialchars($booking['cm_modal']); ?></span></h5>
                    <img src="./upload/<?php echo htmlspecialchars($booking['cm_img']); ?>" class="car-img mb-3" alt="รถ">
                    <hr>

                    <div class="info-box">
                        <p>📅 <span class="info-title">วันที่รับรถ:</span> <?php echo $booking['pickup_date']; ?></p>
                        <p>📅 <span class="info-title">วันที่คืนรถ:</span> <?php echo $booking['return_date']; ?></p>

                        <p>
                            📌 <span class="info-title">สถานะ:</span>
                            <span class="badge <?php echo 'status-' . strtolower($booking['status']); ?> status-badge">
                                <?php echo strtoupper($booking['status']); ?>
                            </span>
                        </p>

                        <!-- ✅ ดูหลักฐานการโอน -->
                        <?php if (!empty($booking['payment_slip'])): ?>
                            <p>📄 <b>หลักฐานการโอนเงิน (คลิกเพื่อดูเต็มจอ)</b></p>
                            <img src="./upload/slips/<?php echo htmlspecialchars($booking['payment_slip']); ?>" class="slip-preview img-thumbnail" onclick="showSlip('<?php echo htmlspecialchars($booking['payment_slip']); ?>')">
                        <?php endif; ?>

                        <!-- ✅ ปุ่มอนุมัติ / ปฏิเสธ -->
                        <div class="d-flex justify-content-between">
                            <?php if ($booking['status'] == 'slip_uploaded'): ?>
                                <a href="approve_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-success flex-fill me-2">✅ อนุมัติ</a>
                                <a href="reject_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-danger flex-fill">❌ ไม่อนุมัติ</a>
                            <?php endif; ?>

                            <?php if ($booking['status'] == 'approved' && $is_pickup_day): ?>
                                <a href="complete_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-primary flex-fill">🚗 ส่งรถถึงที่หมายแล้ว</a>
                            <?php endif; ?>

                            <?php if ($booking['status'] == 'completed'): ?>
                                <a href="return_booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-dark flex-fill mt-2">🔄 รับรถคืนแล้ว</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <a href="booking_manage.php" class="btn btn-secondary mt-3 w-100">🔙 กลับ</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function showSlip(slipImage) {
        Swal.fire({
            title: '📄 หลักฐานการโอนเงิน',
            imageUrl: './upload/slips/' + slipImage,
            imageWidth: 400,
            imageAlt: 'สลิปการโอนเงิน',
            confirmButtonText: 'ปิด',
        });
    }
</script>
</html>
