<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
  <!-- css -->
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <!-- js -->
  <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- icon -->
  <link rel="stylesheet" href="./icon/bootstrap-icons.css">

  <!-- font -->
  <style>
  @font-face {
      font-family: "Athiti";
      src: url("./font/Athiti-Medium.ttf") format("truetype");
    }

    body {
      font-family: "Athiti";
      background-color:#BAD8B6;

    }
  </style>


</head>

<body>
  <div class=" container">
    <div class="row mt-3 justify-content-center">
      <div class="col-md-6">
        <div class="card p-4" style="background-color: #E1EACD;">
          <form action="Register_db.php" method="post" enctype="multipart/form-data">
            <h1 class="text-center">สมัครสมาชิก</h1>

            <label for="firstlast" class="form-label">ชื่อ-สกุล</label>
            <input type="text" class="form-control mb-3" style="background-color: #F9F6E6;" name="firstlast" autofocus required>

            <label for="user" class="form-label">ชื่อผู้ใช้</label>
            <input type="text" class="form-control mb-3" style="background-color: #F9F6E6;" name="user" autofocus required>

            <label for="pass" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control mb-3" style="background-color: #F9F6E6;" name="pass" required>

            <label for="password" class="form-label">ยืนยันรหัสผ่าน</label>
            <input type="password" class="form-control mb-3" style="background-color: #F9F6E6;" name="password" required>

            <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
            <input type="phone" class="form-control mb-3" style="background-color: #F9F6E6;" name="phone" required>

            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control mb-3" style="background-color: #F9F6E6;" name="email" required>

            <label for="address" class="form-label">ที่อยู่</label>
            <input type="text" class="form-control mb-3" style="background-color: #F9F6E6;" name="address" required>

            <label for="idcard" class="form-label">บัตรประชาชน</label>
            <input type="phone" class="form-control mb-3" style="background-color: #F9F6E6;" name="idcard" required max 13>

            
            <label for="img" class="form-label">อัพโหลดใบขับขี่</label>
            <input type="file" class="form-control mb-3" style="background-color: #F9F6E6;" name="img" required>

              <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn text-white w-100"  style="background-color: #8D77AB;">สร้างบัญชีใหม่</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <body>