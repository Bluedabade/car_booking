<?php
include_once "db.php";

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// ดึงข้อมูลยี่ห้อรถจากฐานข้อมูล
$sql = "SELECT * FROM car_cate";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เลือกยี่ห้อที่ต้องการจอง</title>

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

    .brand-card {
      border: none;
      transition: transform 0.2s;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .brand-card:hover {
      transform: scale(1.05);
    }

    .brand-card img {
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
        🏎️ ยี่ห้อของรถยนต์ 🏎️
      </button>
    </div>

    <!-- แสดงยี่ห้อรถ -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4 justify-content-center">
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="col">
            <div class="card text-center brand-card">
              <a href="car_select.php?brand=<?php echo urlencode($row['cc_cate']); ?>">
                <img src="./upload/<?php echo htmlspecialchars($row['cc_img']); ?>" class="card-img-top" 
                     alt="<?php echo htmlspecialchars($row['cc_cate']); ?>">
              </a>
              <div class="card-body">
                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['cc_cate']); ?></h5>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-muted fs-5">❌ ไม่มีข้อมูลยี่ห้อรถในระบบ</p>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
