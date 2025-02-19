<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_test"; // ตรวจสอบว่าใช้ db_test ตามที่ต้องการ

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลรถยนต์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">ข้อมูลรถยนต์</h2>
        <table class="table table-bordered text-center">
            <thead class="table-warning">
                <tr>
                    <th>ชื่อรถ</th>
                    <th>ราคา</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // ดึงข้อมูลรถที่ถูกจองแล้วเท่านั้น
                $sql = "SELECT * FROM tb_order WHERE car_status = 'booked'"; 
                $result = mysqli_query($conn, $sql);

                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $car_name = isset($row['car_name']) ? htmlspecialchars($row['car_name']) : 'N/A';
                        $car_price = isset($row['car_price']) ? number_format($row['car_price']) : 'N/A';

                        // แสดงเฉพาะรถที่ถูกจองแล้ว
                        echo "<tr>
                                <td>$car_name</td>
                                <td>$car_price บาท</td>
                                <td>❌ จองแล้ว</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center text-danger'>ไม่มีข้อมูลรถยนต์ที่ถูกจอง</td></tr>";
                }

                // ปิดการเชื่อมต่อฐานข้อมูล
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
