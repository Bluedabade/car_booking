<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin isuzu</title>
    <!-- <link rel="stylesheet" href="./CSS/honda.css"> -->


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
    <?php
    include_once "db.php";
    $sql = "SELECT * FROM `is_img`";
    $result = mysqli_query($conn, $sql);
    ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

<div class="container">
    <div class="row">
        <?php include("./component/card5.php"); ?>
    </div>
</div>
  
        <?php } ?>

      

       
</body>

</html>