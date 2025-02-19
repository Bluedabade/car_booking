<?php
include_once "db.php";

// ตรวจสอบค่าจาก URL
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';

if (!$brand) {
    echo "<script>alert('กรุณาเลือกยี่ห้อรถก่อน!'); window.location='index.php';</script>";
    exit();
}

// ดึงข้อมูลรถที่ตรงกับยี่ห้อที่เลือก
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
    <title>รายการรถยนต์ - <?php echo htmlspecialchars($brand); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            height: 180px;
            object-fit: contain;
            padding: 10px;
        }

        .imgPreview {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php include_once("./component/nav.php"); ?>

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">🚗 รุ่นรถของ <?php echo htmlspecialchars($brand); ?> 🚗</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCarModal">➕ เพิ่มรุ่นรถ</button>
        </div>
        <!-- Modal เพิ่มรถ -->
        <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่มรุ่นรถ</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_car.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="cm_cate" value="<?php echo htmlspecialchars($brand); ?>">

                            <label class="form-label">ชื่อรุ่นรถ</label>
                            <input type="text" class="form-control mb-3" name="cm_modal" required>

                            <label class="form-label">อัปโหลดรูปภาพ</label>
                            <img class="imgPreview" id="imgPreview">

                            <input type="file" class="form-control mb-3" name="cm_img" id="imgInput" required>

                            <label class="form-label">ราคาเช่า (บาท/วัน)</label>
                            <input type="number" class="form-control mb-3" name="cm_price" required>

                            <label class="form-label">จำนวนรถที่มี</label>
                            <input type="number" class="form-control mb-3" name="cm_stock" required>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" name="submit" class="btn btn-success">บันทึกข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- แสดงรายการรถ -->
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card text-center car-card">
                        <a href="car_detail.php?id=<?php echo $row['cm_id']; ?>">
                            <img src="./upload/<?php echo htmlspecialchars($row['cm_img']); ?>" class="card-img-top">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($row['cm_modal']); ?></h4>
                            <p class="text-success fw-bold">💰 <?php echo number_format($row['cm_price'], 2); ?> บาท/วัน</p>
                            <p class="text-muted">มีในสต็อก: <?php echo htmlspecialchars($row['cm_stock']); ?> คัน</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-warning w-50 edit-btn" data-bs-toggle="modal" data-bs-target="#editCarModal"
                                    data-id="<?php echo $row['cm_id']; ?>">✏️ แก้ไข</button>
                                <a href="delete_car.php?id=<?php echo $row['cm_id']; ?>" class="btn btn-danger w-50"
                                    onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบรถรุ่นนี้?');">🗑️ ลบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal แก้ไขรถ -->
    <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">แก้ไขข้อมูลรถ</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editCarForm" action="update_car.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="cm_id" id="edit_cm_id">
                        <input type="hidden" name="cm_cate" value="<?php echo htmlspecialchars($brand); ?>">

                        <label class="form-label">ชื่อรุ่นรถ</label>
                        <input type="text" class="form-control mb-3" name="cm_modal" id="edit_cm_modal" required>

                        <label class="form-label">ราคาเช่า (บาท/วัน)</label>
                        <input type="number" class="form-control mb-3" name="cm_price" id="edit_cm_price" required>

                        <label class="form-label">จำนวนรถที่มี</label>
                        <input type="number" class="form-control mb-3" name="cm_stock" id="edit_cm_stock" required>

                        <label class="form-label">อัปโหลดรูปภาพใหม่ (เว้นว่างไว้ถ้าไม่เปลี่ยน)</label>
                        <input type="file" class="form-control mb-3" name="cm_img">

                        <button type="submit" name="update" class="btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".edit-btn").click(function() {
                var carId = $(this).data("id");

                $.ajax({
                    url: "get_car.php",
                    type: "GET",
                    data: {
                        id: carId
                    },
                    success: function(response) {
                        var car = JSON.parse(response);

                        $("#edit_cm_id").val(car.cm_id);
                        $("#edit_cm_modal").val(car.cm_modal);
                        $("#edit_cm_price").val(car.cm_price);
                        $("#edit_cm_stock").val(car.cm_stock);
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>