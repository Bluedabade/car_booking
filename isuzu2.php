<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aum Wongsskorn</title>
  <!-- sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  

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
      background-color: #FFF7D1;
    }
  </style>


</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light fs-4" style="background-color: #4fd1c5;">
    <div class="container-fluid">
      <a class="navbar-brand fs-2" href="./index.php">A&F Driver</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item fs-2">
            <a class="nav-link active fs-2" aria-current="page" href="./index.php">หน้าหลัก</a>
          </li>

          <li class="nav-item fs-2 ">
            <a class="nav-link active" aria-current="page" href="./contact.php">ติดต่อเรา</a>

          </li>

          <li class="nav-item fs-2 ">
            <a class="nav-link active" aria-current="page" href="./member.php">Member</a>
          </li>

          <li class="nav-item fs-2 ">
            <a class="nav-link active" aria-current="page" href="./admin.php">Admin</a>
          </li>

        </ul>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <!-- <a class="btn btn-primary me-md-2 fs-2"type="submit" href="./Register.php">สมัครสมาชิก</a> -->
          <!-- <a class="btn btn-primary fs-2 " type="submit" href="./Login.php">เข้าสู่ระบบ</a> -->
          <a class="nav-link active  justify-items: end nav-item fs-2 text-dark" aria-current="page" href="./Register.php">สมัครสมาชิก</a>
          <a class="nav-link active  justify-items: end nav-item fs-2  text-dark" aria-current="page" href="./Login.php">เข้าสู่ระบบ</a>
        </div>
      </div>
    </div>
  </nav>
  </h1>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>ตารางข้อมูล</h1>
        <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-balloon-heart"></i>
          เพิ่มข้อมูล
        </button>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLable" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลสมาชิก</h4>
                <button type="button" class="btn-close"></button>
              </div>
              <div class="modal-body">
                <form action="isuzu3.php" method="post" enctype="multipart/form-data">
                  <!-- <h1 class="text-center">เพิ่มข้อมูลสมาชิก</h1> -->

                  <label for="imgcar" class="form-label">รูปรถ</label>
                  <input type="file" class="form-control mb-3" name="imgcar4" required>

                  <label for="namecar" class="form-label">ยี่ห้อรถ</label>
                  <input type="text" class="form-control mb-3" name="namecar4" autofocus required>

                  <label for="idcar" class="form-label">ราคา</label>
                  <input type="text" class="form-control mb-3" name="idcar4" required>




              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Close</button>
                <button type="submit" name="submit" class="btn btn-success"><i class="bi bi-save-fill"></i>Save chages</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>



      <div class="table-responsive table-dark table-hover">
        <table class="table table table-bordered border-dark">
          <tr>
            <th>รถที่กำลังเช่า</th>
            <th>ยี่ห้อรถ</th>
            <th>ราคา</th>




          </tr>
          <?php
          include_once "db.php";
          $sql = "SELECT * FROM `is_img`";
          $result = mysqli_query($conn, $sql);
          ?>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>

              <td>
                <img src="upload5/<?php echo $row['s_img']; ?>" class="rounded-circle" style="width: 10vh; height: auto;">
              </td>

              <td><?php echo $row['s_namecar']; ?></td>
              <td><?php echo $row['s_idcard']; ?></td>


              <td>
                <a class="btn btn-warning text-white w-50 mb-2" href="Register_edit.php=<?php echo $row['s_id']; ?>">แก้ไขข้อมูล</a> <br>
                <a class="btn btn-danger text-white w-50" href="delete.php=<?php echo $row['s_id']; ?>">ลบ</a>
              </td>

            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <!-- sweetalert -->
  <!-- insert -->
  <?php if (isset($_SESSION['insert'])) { ?>
    <script>
      Swal.fire({
        title: "บันทึกข้อมูลสำเร็จ",
        text: "เรียบร้อยแล้ว",
        icon: "success"
      });
    </script>
  <?php unset($_SESSION['insert']);
  } ?>


  <body>

</html>