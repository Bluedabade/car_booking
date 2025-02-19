<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <!-- css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="./CSS/index.css">
  <style>
    @font-face {
      font-family: "Athiti";
      src: url("./font/Athiti-Medium.ttf") format("truetype");
    }

    body {
      font-family: "Athiti";
      background-color: #FFF7D1;

    }

    .image-row {
      display: flex;
      justify-content: center;
      /* จัดกึ่งกลางรูปภาพ */
      gap: 20px;
      /* ระยะห่างระหว่างรูปภาพ */
    }

    .image-row img {
      width: 45%;
      /* กำหนดให้แต่ละรูปใช้พื้นที่ 45% ของคอนเทนเนอร์ */
      height: auto;
    }
  </style>

</head>

<body style="background:#FFF7D1;">
  <!-- แน้บบลา -->
  <?php include_once("./component/nav.php"); ?>

  <!-- Banner -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="margin-top: -5px;">
    <!-- Indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Carousel Content -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./img/2.jpg" class="d-block w-100" alt="First Slide">
      </div>
      <div class="carousel-item">
        <img src="./img/banner11.jpg" class="d-block w-100" alt="Second Slide">
      </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>





  <div class="container overflow-hidden">
    <div class="row gy-5">
      <section class="dishes">

        <div class="heading">
          <section class="hero">

            <div class="search-form" style="background-color: #FFDE7D;">
              <div class="tab-buttons">
                <button class="fs-2 active" style="background-color: #FFDE7D; color: black; ">เช่ารถขับเอง</button>

                <form ;>
                  <select class="form-select form-select-lg mb-3" style="background-color: #FFF7D1;" aria-label="Large select example">
                    <option selected>เลือกสถานที่รับรถ</option>
                    <option value="1">โลตัสอยุธยา</option>
                    <option value="2">เซ็นทรันอยุธยา</option>
                    <option value="3">วัดใหญ่ชัยมงคล</option>
                  </select>





                  <a class="fs-4 text" style="color: black;">ยี่ห้อรถยนต์</a>
                  <select class="form-select form-select-lg mb-3" style="background-color: #FFF7D1;" aria-label="Large select example" id="carSelect">
                    <option selected>เลือกยี่ห้อรถ</option>
                    <option value="1">Honda</option>
                    <option value="2">Toyota</option>
                    <option value="3">Nissan</option>
                    <option value="4">MG</option>
                    <option value="5">Isuzu</option>
                  </select>


                  <a class="fs-4 text" style="color: black;">ประเภทรถ</a>
                  <select class="form-select form-select-lg mb-3" style="background-color: #FFF7D1;" aria-label="Large select example" id="carSelect">
                    <option selected>เลือกประเภทรถ</option>
                    <option value="1">รถยนต์ขนาดเล็ก</option>
                    <option value="2">รถยนต์ขนาดกลาง</option>
                    <option value="3">รถยนต์ขนาดใหญ๋</option>

                  </select>


                  <button class="fs-2" style="background-color: #F6416C; color:black;" type="submit">ค้นหารถเช่า</button>
                </form>
              </div>
            </div>
          </section>

          <hr class="my-4">
          <button class="text-1 b" style="background-color: #FFDE7D ; color: black;">🏎️ยี่ห้อของรถยนต์🏎️</button>
          <div class="box-container" style="display: flex; justify-content:center;">


            <div class="box">
              <a href="./honda1.php"> <img src="./img/hon.png" style="width:300px; height:250px;"></a>
              <h4 class="text-center">Honda</h4>
            </div>


            <div class="box">
              <a href="./toyota1.php"> <img src="./img/toyo.png" style="width:300px; height:250px;"></a>
              <h4 class="text-center">Toyota</h4>
            </div>


            <div class="box">
              <a href="./nissan1.php"> <img src="./img/nis.png" style="width:300px; height:250px;"></a>
              <h4 class="text-center">Nissan</h4>
            </div>
      </section>
      <div class="container overflow-hidden">
        <div class="row gy-5 ">
          <section class="dishes">
            <div class="box-container" style="display: flex; justify-content:center;">
              <div class="box">
                <a href="./mg1.php"> <img src="./img/mg2.png" style="width:300px; height:250px;"></a>
                <h4 class="text-center">MG</h4>
              </div>

              <div class="box">
                <a href="./isuzu1.php"> <img src="./img/isu.png" style="width:300px; height:250px;"></a>
                <h4 class="text-center">Isuzu</h4>
              </div>
            </div>
          </section>
        </div>
        <hr class="my-4">
      </div>
      <div class="mx-auto p-2 fs-1" style="width: 200px;">
        รถเช่ายอดนิยม
      </div>
      <hr class="my-4">
      <div class="mx-auto p-2 fs-1" style="width: 200px;">
        โปรโมชั่นแนะนำ
      </div>

      <video width="max" height="max" autoplay loop muted>
        <source src="./img/A&F.mp4" type="video/mp4">
        เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
      </video>
      <div class="image-row">
        <img src="./img/promo1.jpg" alt="">
        <img src="./img/promo3.png" alt="">

      </div>


      <h3>
        <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy;A&F Driver</p>
          <h3>ติดต่อเรา 012-3456-789</h3>
          <ul class="list-inline">
            <li class="list-inline-item"> <a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="https://www.facebook.com/share/1D9Ddd4fkr/?mibextid=wwXIfr">Support</a></li>
          </ul>
        </footer>
      </h3>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</html>