<?php
include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstlast = $_POST['firstlast'];
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $idcard = $_POST['idcard'];

  // Handle file upload
  $target_dir = "upload/";
  $target_file = $target_dir . basename($_FILES["img"]["name"]);

  if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
    $img = $_FILES["img"]["name"];
  } else {
    $_SESSION['insert'] = false;
    header("Location: index.php");
    exit();
  }

  $sql = "INSERT INTO `tbl_test` (m_first, m_user, m_pass, m_mpass, m_phone, m_email, m_address, m_idcard, m_img) 
            VALUES ('$firstlast', '$user', '$pass', '$password', '$phone', '$email', '$address', '$idcard', '$img')";

  if (mysqli_query($conn, $sql)) {
    $_SESSION['insert'] = true;
  } else {
    $_SESSION['insert'] = false;
  }

  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A&F Driver</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
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
    <div class="row">
      <div class="col-md-12">
        <h1>ตารางข้อมูลผู้ใช้งาน</h1>


        <button type="button" class="btn btn-primary float-end mb-3 mt-1" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-balloon-heart"></i> เพิ่มข้อมูล</button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg"> <!-- ทำให้ Modal กว้างขึ้น -->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลสมาชิก</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="Register_db.php" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="firstlast" class="form-label">ชื่อ-สกุล</label>
                      <input type="text" class="form-control mb-3" name="firstlast" required>
                    </div>
                    <div class="col-md-6">
                      <label for="user" class="form-label">ชื่อผู้ใช้</label>
                      <input type="text" class="form-control mb-3" name="user" required>
                    </div>
                    <div class="col-md-6">
                      <label for="pass" class="form-label">รหัสผ่าน</label>
                      <input type="password" class="form-control mb-3" name="pass" required>
                    </div>
                    <div class="col-md-6">
                      <label for="password" class="form-label">ยืนยันรหัสผ่าน</label>
                      <input type="password" class="form-control mb-3" name="password" required>
                    </div>
                    <div class="col-md-6">
                      <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                      <input type="tel" class="form-control mb-3" name="phone" required>
                    </div>
                    <div class="col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control mb-3" name="email" required>
                    </div>
                    <div class="col-md-6">
                      <label for="address" class="form-label">ที่อยู่</label>
                      <input type="text" class="form-control mb-3" name="address" required>
                    </div>
                    <div class="col-md-6">
                      <label for="idcard" class="form-label">บัตรประชาชน</label>
                      <input type="text" class="form-control mb-3" name="idcard" maxlength="13" required>
                    </div>
                  </div>

                  <!-- ตัวอย่างรูปภาพที่เลือก -->
                  <div class="text-center my-3">
                    <img id="imgPreview" src="https://via.placeholder.com/120"
                      class="border shadow"
                      style="width: 120px; height: 120px; object-fit: cover;"
                      alt="ตัวอย่างใบขับขี่">
                  </div>

                  <label for="img" class="form-label">อัพโหลดใบขับขี่</label>
                  <input type="file" class="form-control mb-3" name="img" id="imgInput" accept="image/*" required>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                <button type="submit" name="submit" class="btn btn-success"><i class="bi bi-save-fill"></i> Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>



      </div>
      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>ชื่อ-สกุล</th>
              <th>ชื่อผู้ใช้</th>
              <th>รหัสผ่าน</th>
              <th>เบอร์โทรศัพท์</th>
              <th>Email</th>
              <th>ที่อยู่</th>
              <th>บัตรประชาชน</th>
              <th>ใบขับขี่</th>
              <th>จัดการ</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include_once "db.php";
            $sql = "SELECT * FROM `tbl_test` WHERE `m_permis` ='user';";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()):
            ?>
              <tr>
                <td><?php echo htmlspecialchars($row['m_first']) ?></td>
                <td><?php echo htmlspecialchars($row['m_user']) ?></td>
                <td><?php echo htmlspecialchars($row['m_pass']) ?></td>
                <td><?php echo htmlspecialchars($row['m_phone']) ?></td>
                <td><?php echo htmlspecialchars($row['m_email']) ?></td>
                <td><?php echo htmlspecialchars($row['m_address']) ?></td>
                <td><?php echo htmlspecialchars($row['m_idcard']) ?></td>
                <td>
                  <img src="./upload/<?php echo htmlspecialchars($row['m_img']) ?>"
                    class="rounded-circle border border-2"
                    style="width: 60px; height: 60px; object-fit: cover;"
                    alt="ใบขับขี่">
                </td>
                <td><a class='btn btn-warning text-white w-100 mb-1' href='Register_edit.php?id=<?php echo $row['m_id']; ?>'>แก้ไข</a>
                  <a onclick="return confirm('ยืนยันการลบ?')" class='btn btn-danger text-white w-100' href="delete.php?id=<?php echo $row['m_id']; ?>" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')">ลบ</a>
                </td>

              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

</body>
<script src="./js/script.js"></script>

</html>