<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin </title>
  <!-- sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <h1>
    <nav class="navbar navbar-expand-lg navbar-light " style=" background-color: #00FFD1;">
      <div class="container-fluid">
        <a class="navbar-brand fs-1" href="./index.php" img="">A&F Driver</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item fs-2">
              <a class="nav-link active" style="color:dark;" aria-current="page" href="./Index.php">หน้าหลัก</a>
            </li>



            <li class="nav-item fs-2 ">
              <a class="nav-link active" style="color:dark;" aria-current="page" href="./member.php">Member</a>
            </li>

            <li class="nav-item fs-2 ">
              <a class="nav-link active" style="color:dark;" aria-current="page" href="./admin.php">Admin</a>
            </li>

            <li class="nav-item fs-2 ">
              <a class="nav-link active" style="color:dark;" aria-current="page" href="./buycar.php">buycar</a>
            </li>

          </ul>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">

            <a class="nav-link active  justify-items: end nav-item fs-2" style="color: black;" aria-current="page" href="./Register.php">สมัครสมาชิก</a>
            <a class="nav-link active  justify-items: end nav-item fs-2" style="color: black;" aria-current="page" href="./Login.php">เข้าสู่ระบบ</a>
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
                <form action="admin_db.php" method="post" enctype="multipart/form-data">
                  <!-- <h1 class="text-center">เพิ่มข้อมูลสมาชิก</h1> -->

                  <label for="imgcar" class="form-label">รูปรถ</label>
                  <input type="file" class="form-control mb-3" name="imgcar" required>

                  <label for="namecar" class="form-label">ยี่ห้อรถ</label>
                  <input type="text" class="form-control mb-3" name="namecar" autofocus required>

                  <label for="idcar" class="form-label">ราคา</label>
                  <input type="text" class="form-control mb-3" name="idcar" required>




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
          $sql = "SELECT * FROM `db_img`";
          $result = mysqli_query($conn, $sql);
          ?>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>

              <td>
                <img src="upload1/<?php echo $row['c_img']; ?>" class="rounded-circle" style="width: 10vh; height: auto;">
              </td>

              <td><?php echo $row['c_namecar']; ?></td>
              <td><?php echo $row['c_idcar']; ?></td>


              <td>
                <a class="btn btn-warning text-white w-50 mb-2" href="Register_edit.php=<?php echo $row['c_id']; ?>">แก้ไขข้อมูล</a> <br>
                <a class="btn btn-danger text-white w-50" href="member_del_.php?id<?php echo $row['c_id']; ?>">ลบ</a>
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