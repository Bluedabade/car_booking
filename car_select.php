<?php
include_once "db.php";

// ตรวจสอบค่าที่ได้รับจาก URL
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';

if (!$brand) {
    echo "<script>alert('กรุณาเลือกยี่ห้อรถ!'); window.location='brand_select.php';</script>";
    exit();
}

// ดึงข้อมูลรถจากฐานข้อมูลที่ตรงกับยี่ห้อที่ลูกค้าเลือก
$sql = "SELECT * FROM car_modal WHERE cm_cate = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $brand);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เลือกรถยนต์ - <?php echo htmlspecialchars($brand); ?></title>

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

        .car-card {
            border: none;
            transition: transform 0.2s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .car-card:hover {
            transform: scale(1.05);
        }

        .car-card img {
            height: 200px;
            object-fit: contain;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container my-4">
        <div class="text-center">
            <button class="btn btn-warning px-4 py-2 fs-4 fw-bold shadow">
                🚗 เลือกรถยนต์จาก <?php echo htmlspecialchars($brand); ?> 🚗
            </button>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4 justify-content-center">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card text-center car-card">
                            <img src="./upload/<?php echo htmlspecialchars($row['cm_img']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($row['cm_modal']); ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['cm_modal']); ?></h5>
                                <p class="text-muted">ราคา: ฿<?php echo number_format($row['cm_price']); ?> / วัน</p>
                                <p class="text-muted">คงเหลือ: <?php echo htmlspecialchars($row['cm_stock']); ?> คัน</p>
                                <a href="car_book.php?car_id=<?php echo $row['cm_id']; ?>&brand=<?php echo $row['cm_cate']; ?>" class="btn btn-success w-100">จองเลย</a>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-muted fs-5">❌ ไม่มีรถจากยี่ห้อ <?php echo htmlspecialchars($brand); ?> ให้จอง</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>