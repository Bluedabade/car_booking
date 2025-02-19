<?php
include_once "db.php";

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// ดึงข้อมูลทั้งหมดจากตาราง nd_img
$sql = "SELECT * FROM nd_img LIMIT 1";
$result = mysqli_query($conn, $sql);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>หน้าจองรถ</title>

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


  <div class="container">
    <main>
      <div class="py-5 text-center">
        <h2 class="mb-5">ยืนยันการจอง</h2>
        <div class="table-responsive">
          <table class="table table-bordered table-hover mt-4">
            <thead class="table-warning">
              <tr>
                <th>รูปรถ</th>
                <th>ชื่อรถ</th>
                <th>หมายเลขรถ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $image_path = isset($row['n_img']) ? htmlspecialchars($row['n_img']) : 'no_image.jpg';
                  $car_name = isset($row['n_namecar']) ? htmlspecialchars($row['n_namecar']) : 'N/A';
                  $car_id = isset($row['n_idcar']) ? htmlspecialchars($row['n_idcar']) : 'N/A';

                  echo "<tr>
                        <td><img src='upload3/{$image_path}' alt='Car Image' style='width:150px;'></td>
                        <td>{$car_name}</td>
                       <td>{$car_id}</td>
                    </tr>";
                }
              } else {
                echo "<tr><td colspan='3'>ไม่พบข้อมูล</td></tr>";
              }
              mysqli_close($conn);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
  <center>
    <div class="col-md-7 col-lg-8">
      <form action="./buy_db.php" method="POST">
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="firstName" class="form-label">ชื่อจริง</label>
            <input type="text" class="form-control" id="firstName" name="firstname" required>
          </div>
          <div class="col-sm-6">
            <label for="lastName" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" id="lastName" name="lastname" required>
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="col-12">
            <label for="address" class="form-label">ที่อยู่</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <div class="col-12">
            <label for="address" class="form-label">เลขบัตรประชาชน</label>
            <input type="text" class="form-control" id="address2" name="address2" required>
          </div>
          <div class="col-md-6">
            <label for="pickup-location" class="form-label">สถานที่รับรถ</label>
            <select class="form-select" id="pickup-location" name="pickup_location" required>
              <option value="">-</option>
              <option>เซ็นทรัลอยุธยา</option>
              <option>โลตัสอยุธยา</option>
              <option>สถานีรถไฟอยุธยา</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="return-location" class="form-label">สถานที่คืนรถ</label>
            <select class="form-select" id="return-location" name="return_location" required>
              <option value="">-</option>
              <option>เซ็นทรัลอยุธยา</option>
              <option>โลตัสอยุธยา</option>
              <option>สถานีรถไฟอยุธยา</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="pickup-time" class="form-label">เวลารับรถ</label>
            <input type="datetime-local" class="form-control" id="pickup-time" name="pickup_time" min="<?= date('Y-m-d\TH:i') ?>" required>
          </div>

          <div class="col-md-6">
            <label for="return-time" class="form-label">เวลาคืนรถ</label>
            <input type="datetime-local" class="form-control" id="return-time" name="return_time" min="<?= date('Y-m-d\TH:i') ?>" required>
          </div>
        </div>
        <br>
        <button class="w-100 btn btn-lg" style="background-color: #F6416C;" type="submit" name="submit">จองเลย</button>
      </form>
    </div>
    </main>
    </div>
  </center>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>