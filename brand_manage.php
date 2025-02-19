<?php
include_once "db.php";

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM car_cate";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการยี่ห้อรถ</title>

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

    .brand-card {
      border: none;
      transition: transform 0.2s;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .brand-card:hover {
      transform: scale(1.05);
    }

    .brand-card img {
      height: 150px;
      object-fit: contain;
      padding: 15px;
    }

    #imgPreview,
    #editImgPreview {
      width: 100%;
      height: auto;
      margin-bottom: 10px;
      border-radius: 10px;
      display: none;
    }
  </style>
</head>

<body>
  <?php include_once("./component/nav.php"); ?>

  <div class="container my-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="text-primary">🚗 ยี่ห้อรถ 🚗</h2>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBrandModal">➕ เพิ่มยี่ห้อรถ</button>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4 justify-content-center">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col">
          <div class="card text-center brand-card">
            <a href="car_manage.php?brand=<?php echo $row['cc_cate']; ?>">
              <img src="./upload/<?php echo htmlspecialchars($row['cc_img']); ?>" class="card-img-top">
            </a>
            <div class="card-body">
              <h4 class="card-title"><?php echo htmlspecialchars($row['cc_cate']); ?></h4>
              <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-warning edit-brand-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#editBrandModal"
                  data-id="<?php echo $row['cc_id']; ?>">✏️ แก้ไข</button>
                <a href="delete_brand.php?id=<?php echo $row['cc_id']; ?>"
                  class="btn btn-danger"
                  onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบยี่ห้อรถนี้?');">🗑️ ลบ</a>

              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Modal เพิ่มยี่ห้อรถ -->
  <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">เพิ่มยี่ห้อรถ</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="add_brand.php" method="post" enctype="multipart/form-data">
            <label class="form-label">ชื่อยี่ห้อรถ</label>
            <input type="text" class="form-control mb-3" name="cc_cate" required>

            <label class="form-label">อัปโหลดโลโก้</label>
            <img id="imgPreview">
            <input type="file" class="form-control mb-3" name="cc_img" id="imgInput" required>

            <button type="submit" name="submit" class="btn btn-success w-100">บันทึกข้อมูล</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal แก้ไขยี่ห้อรถ -->
  <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">แก้ไขยี่ห้อรถ</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="editBrandForm" action="update_brand.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cc_id" id="edit_cc_id">

            <label class="form-label">ชื่อยี่ห้อรถ</label>
            <input type="text" class="form-control mb-3" name="cc_cate" id="edit_cc_cate" required>

            <label class="form-label">โลโก้ปัจจุบัน</label>
            <img id="editImgPreview">
            <input type="file" class="form-control mb-3" name="cc_img" id="editImgInput">

            <button type="submit" name="update" class="btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $("#imgInput").change(function() {
      let reader = new FileReader();
      reader.onload = function(e) {
        $("#imgPreview").attr("src", e.target.result).show();
      };
      reader.readAsDataURL(this.files[0]);
    });

    $(".edit-brand-btn").click(function() {
      var brandId = $(this).data("id");

      $.ajax({
        url: "get_brand.php",
        type: "GET",
        data: {
          id: brandId
        },
        success: function(response) {
          var brand = JSON.parse(response);

          $("#edit_cc_id").val(brand.cc_id);
          $("#edit_cc_cate").val(brand.cc_cate);
          $("#editImgPreview").attr("src", "./upload/" + brand.cc_img).show();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>