<?php
include_once "db.php"; // เชื่อมต่อกับฐานข้อมูล

// Query ข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM by_test";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่าเชื่อมต่อกับฐานข้อมูลและสามารถดึงข้อมูลได้
if (!$result) {
    die("Error: " . mysqli_error($conn)); // หากเกิดข้อผิดพลาดในการดึงข้อมูลแสดงข้อความแสดงข้อผิดพลาด
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A&F Driver</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="./icon/bootstrap-icons.css">

    <!-- Custom Font -->
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #00FFD1;">
        <div class="container-fluid">
            <a class="navbar-brand fs-1" href="./index.php">A&F Driver</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item fs-2">
                        <a class="nav-link active" href="./Index.php">หน้าหลัก</a>
                    </li>
                    <li class="nav-item fs-2">
                        <a class="nav-link active" href="./member.php">Member</a>
                    </li>
                    <li class="nav-item fs-2">
                        <a class="nav-link active" href="./admin.php">Admin</a>
                    </li>
                    <li class="nav-item fs-2">
                        <a class="nav-link active" href="./buycar.php">buycar</a>
                    </li>
                </ul>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="nav-link active" href="./Register.php">สมัครสมาชิก</a>
                    <a class="nav-link active" href="./Login.php">เข้าสู่ระบบ</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>ตารางข้อมูล</h1>
            </div>

            <!-- Table -->
            <div class="table-responsive table-dark table-hover text-dark">
                <table class="table table-bordered border-dark">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ชื่อ</th>";
                        echo "<th>นามสกุล</th>";
                        echo "<th>อีเมล</th>";
                        echo "<th>ที่อยู่</th>";
                        echo "<th>บัตรประชาชน</th>";
                        echo "<th>สถานที่รับรถ</th>";
                        echo "<th>สถานที่คืนรถ</th>";
                        echo "<th>วันที่และเวลารับรถ</th>";
                        echo "<th>วันที่และเวลาคืนรถ</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // ลูปข้อมูลที่ได้จากฐานข้อมูล
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['y_firstname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['y_lastname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['y_email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['y_address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['y_address2']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pickuplocation']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['returnlocation']) . "</td>";
                            echo "<td>" . (isset($row['y_pickup']) && $row['y_pickup'] != '0000-00-00 00:00:00' && !empty($row['y_pickup']) ? date('d/m/Y H:i', strtotime($row['y_pickup'])) : "ไม่มีข้อมูล") . "</td>";
                            echo "<td>" . (isset($row['y_return']) && $row['y_return'] != '0000-00-00 00:00:00' && !empty($row['y_return']) ? date('d/m/Y H:i', strtotime($row['y_return'])) : "ไม่มีข้อมูล") . "</td>";

                            echo "</tr>";
                        }

                        echo "</tbody>";
                    } else {
                        echo "<tr><td colspan='9'>ไม่พบข้อมูลในตาราง</td></tr>";
                    }

                    // ปิดการเชื่อมต่อฐานข้อมูล
                    mysqli_close($conn);
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>