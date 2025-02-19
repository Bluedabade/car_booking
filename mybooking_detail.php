<?php
include_once "db.php";
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน!'); window.location='Login.php';</script>";
    exit();
}

// รับค่า ID การจองจาก URL
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id <= 0) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='my_bookings.php';</script>";
    exit();
}

// ดึงข้อมูลการจองจากฐานข้อมูล
$sql = "SELECT b.*, c.cm_modal, c.cm_img, c.cm_price, u.m_first, u.m_user,u.m_img, u.m_phone, u.m_email, u.m_address 
        FROM tbl_booking b
        JOIN car_modal c ON b.car_id = c.cm_id
        JOIN tbl_test u ON b.user_id = u.m_id
        WHERE b.booking_id = ? AND b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// ถ้าไม่พบข้อมูล
if (!$booking) {
    echo "<script>alert('ไม่พบข้อมูลการจอง!'); window.location='my_bookings.php';</script>";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการจอง</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        @font-face {
            font-family: "Athiti";
            src: url("./font/Athiti-Medium.ttf") format("truetype");
        }

        body {
            font-family: "Athiti";
            background-color: #FFF7D1;
        }

        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .user-info img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #00A8E8;
        }

        .car-img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .badge-status {
            font-size: 1.2rem;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #FFD700;
            color: #000;
        }

        .status-approved {
            background-color: #28A745;
            color: #fff;
        }

        .status-rejected {
            background-color: #DC3545;
            color: #fff;
        }

        .status-slip-uploaded {
            background-color: #17A2B8;
            color: #fff;
        }

        .qr-code {
            max-width: 200px;
            margin: 10px auto;
            display: block;
        }

        .slip-img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container">
        <h2 class="text-center my-3">📌 รายละเอียดการจอง</h2>

        <div class="row">
            <!-- ข้อมูลผู้ใช้ -->
            <div class="col-md-4 text-center">
                <div class="user-info">
                    <img src="./upload/<?php echo htmlspecialchars($booking['m_img']); ?>" class="profile-img" alt="โปรไฟล์">
                    <h4 class="mt-2"><?php echo htmlspecialchars($booking['m_first']); ?></h4>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($booking['m_phone']); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($booking['m_email']); ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($booking['m_address']); ?></p>
                </div>
            </div>

            <!-- ข้อมูลรถที่จอง -->
            <div class="col-md-8">
                <h4>🚗 รถที่จอง: <span class="text-primary"><?php echo htmlspecialchars($booking['cm_modal']); ?></span></h4>
                <img src="./upload/<?php echo htmlspecialchars($booking['cm_img']); ?>" class="car-img mb-3" alt="Car Image">

                <p><i class="fas fa-calendar-alt"></i> <strong>วันที่รับรถ:</strong> <?php echo $booking['pickup_date']; ?></p>
                <p><i class="fas fa-calendar-alt"></i> <strong>วันที่คืนรถ:</strong> <?php echo $booking['return_date']; ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>สถานที่รับรถ:</strong> <?php echo htmlspecialchars($booking['pickup_location']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>สถานที่คืนรถ:</strong> <?php echo htmlspecialchars($booking['return_location']); ?></p>
                <p><i class="fas fa-dollar-sign"></i> <strong>ราคารวม:</strong> ฿<?php echo number_format($booking['total_price'], 2); ?></p>

                <h5 class="mt-3">
                    สถานะ:
                    <span class="badge badge-status 
    <?php
    if ($booking['status'] == 'pending') {
        echo 'status-pending'; // รอการชำระเงิน
    } elseif ($booking['status'] == 'slip_uploaded') {
        echo 'status-slip-uploaded'; // อัปโหลดสลิปแล้ว
    } elseif ($booking['status'] == 'approved') {
        echo 'status-approved'; // อนุมัติแล้ว
    } elseif ($booking['status'] == 'cancelled') {
        echo 'status-cancelled'; // ถูกยกเลิก
    } elseif ($booking['status'] == 'completed') {
        echo 'status-completed'; // เสร็จสมบูรณ์
    } else {
        echo 'status-unknown';
    }
    ?>">
                        <?php
                        if ($booking['status'] == 'pending') {
                            echo 'รอการชำระเงิน';
                        } elseif ($booking['status'] == 'slip_uploaded') {
                            echo 'อัปโหลดสลิปแล้ว รอตรวจสอบ';
                        } elseif ($booking['status'] == 'approved') {
                            echo 'อนุมัติแล้ว';
                        } elseif ($booking['status'] == 'cancelled') {
                            echo 'ถูกยกเลิก';
                        } elseif ($booking['status'] == 'completed') {
                            echo 'การจองเสร็จสมบูรณ์';
                        } else {
                            echo 'สถานะไม่ทราบ';
                        }
                        ?>
                    </span>
                </h5>


                <!-- ตรวจสอบว่ายังไม่มีการอัปโหลดสลิป -->
                <?php if ($booking['status'] == 'pending'): ?>
                    <div class="mt-4 text-center">
                        <h5>📌 กรุณาชำระเงินและอัปโหลดสลิป</h5>
                        <img src="./img/qr_code.png" class="qr-code" alt="QR Code">
                        <form action="upload_slip.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                            <input type="file" name="slip" class="form-control my-2" required>
                            <button type="submit" class="btn btn-primary w-100">📤 อัปโหลดสลิป</button>
                        </form>
                    </div>
                <?php elseif ($booking['status'] == 'slip_uploaded'): ?>
                    <div class="mt-4 text-center">
                        <h5>📌 หลักฐานการโอนเงิน</h5>
                        <img src="./upload/slips/<?php echo htmlspecialchars($booking['payment_slip']); ?>" class="slip-img" alt="Slip Image">
                        <p class="text-warning">⏳ รอการตรวจสอบจากแอดมิน</p>
                    </div>
                <?php endif; ?>


                <a href="my_bookings.php" class="btn btn-secondary mt-3">🔙 กลับไปที่รายการจองของฉัน</a>
            </div>
        </div>
    </div>
</body>

</html>