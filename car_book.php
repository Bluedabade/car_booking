<?php
session_start();
include_once "db.php";

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนทำการจอง!'); window.location='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลผู้ใช้เพื่อใช้เป็นค่าเริ่มต้นของสถานที่รับ-คืนรถ
$sql_user = "SELECT m_address FROM tbl_test WHERE m_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

// รับค่ารถที่ต้องการจอง
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;

if (!$brand || !$car_id) {
    echo "<script>alert('กรุณาเลือกรถที่ต้องการจอง!'); window.location='brand_select.php';</script>";
    exit();
}

// ดึงข้อมูลรถจากฐานข้อมูล
$sql = "SELECT * FROM car_modal WHERE cm_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

// ถ้าไม่มีรถในฐานข้อมูล
if (!$car) {
    echo "<script>alert('ไม่พบข้อมูลรถ!'); window.location='brand_select.php';</script>";
    exit();
}
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จองรถยนต์ - <?php echo htmlspecialchars($car['cm_modal']); ?></title>

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

    <div class="container my-4">
        <h2 class="text-center">🚗 จองรถยนต์: <?php echo htmlspecialchars($car['cm_modal']); ?> 🚗</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="./upload/<?php echo htmlspecialchars($car['cm_img']); ?>" class="img-fluid rounded shadow" alt="รถ">
            </div>
            <div class="col-md-6">
                <form action="process_booking.php" method="post">
                    <input type="hidden" name="car_id" value="<?php echo $car['cm_id']; ?>">
                    <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <div class="mb-3">
                        <label class="form-label">วันที่รับรถ</label>
                        <input type="date" class="form-control" name="pickup_date" id="pickup_date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">วันที่คืนรถ</label>
                        <input type="date" class="form-control" name="return_date" id="return_date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">สถานที่รับรถ</label>
                        <input type="text" class="form-control" name="pickup_location" value="<?php echo htmlspecialchars($user['m_address']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">สถานที่คืนรถ</label>
                        <input type="text" class="form-control" name="return_location" value="<?php echo htmlspecialchars($user['m_address']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ราคาเช่าต่อวัน</label>
                        <input type="text" class="form-control" value="฿<?php echo number_format($car['cm_price']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ราคารวม</label>
                        <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                    </div>

                    <button type="submit" class="btn btn-success w-100">✅ ยืนยันการจอง</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("pickup_date").addEventListener("change", calculateTotal);
        document.getElementById("return_date").addEventListener("change", calculateTotal);

        function calculateTotal() {
            const pickupDate = new Date(document.getElementById("pickup_date").value);
            const returnDate = new Date(document.getElementById("return_date").value);
            let pricePerDay = <?php echo json_encode($car['cm_price']); ?>;

            if (isNaN(pricePerDay) || pricePerDay <= 0) {
                pricePerDay = 1000; // กำหนดค่าตั้งต้นถ้าหากไม่มีราคา
            }

            if (pickupDate && returnDate && returnDate > pickupDate) {
                const days = Math.ceil((returnDate - pickupDate) / (1000 * 60 * 60 * 24));
                document.getElementById("total_price").value = "฿" + (days * pricePerDay).toLocaleString();
            } else {
                document.getElementById("total_price").value = "";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
