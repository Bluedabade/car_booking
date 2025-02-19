<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PromptPay QR Code</title>

  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/new-age.min.css">
  <link rel="stylesheet" type="text/css" href="css/custom.min.css">
</head>
<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">PromptPay QR Code Generator</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#generate">สร้าง QR Code รับเงิน</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="text-center" id="generate">
    <div class="generate-section">
      <div class="container generate-content">
        <div class="row generate-form">
          <div class="col-md-8 mx-auto" style="margin-top:90px;">
            <form method="POST">
              <div class="form-group error">
                <label>จำนวนเงิน</label>
                <input type="number" inputmode="decimal" step="0.01" class="form-control" name="amount" placeholder="1000.00 (Optional)" required>
              </div>
              <button type="submit" class="btn btn-primary btn-lg">สร้าง QR Code รับเงิน</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $amount = floatval($_POST['amount']);
      $ppID = "0971053310"; // กำหนดเบอร์มือถือให้เป็นค่าคงที่

      if ($amount > 0) {
        $payload = generatePayload($ppID, $amount);
        echo "<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' style='display:block;'>
                <div class='modal-dialog' role='document'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                      <h4 class='modal-title' id='myModalLabel'>QR Code รับเงิน</h4>
                    </div>
                    <div class='modal-body' style='margin: auto;'>
                      <img src='img/PromptPay-logo.jpg' alt='พร้อมเพย์' style='max-width: 250px;margin-bottom: 10px;'>
                      <div id='qrcode' style='width:250px; height:250px;'></div>
                      <div style='text-align: center; margin-top: 10px;'>จำนวนเงินทั้งหมด</div>
                      <div id='amount-show' style='text-align: center;'>{$amount} บาท</div>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-default close-button' data-dismiss='modal'>Close</button>
                    </div>
                  </div>
                </div>
              </div>";
      }
    }

    function generatePayload($ppID, $amount) {
      // ฟังก์ชันสำหรับสร้างข้อมูล QR Code ของ PromptPay
      // คุณจะต้องเพิ่มโค้ดที่จำเป็นสำหรับการสร้างข้อมูลตามรูปแบบของ PromptPay
    }
  ?>

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/qrcode.min.js"></script>
  <script src="vendor/popper/popper.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/new-age.min.js"></script>

  <script type="text/javascript">
    var qrcode = new QRCode(document.getElementById("qrcode"), {
      width: 250,
      height: 250,
      correctLevel: QRCode.CorrectLevel.L
    });

    $(document).ready(function () {
      var payload = "<?php echo isset($payload) ? $payload : ''; ?>";
      if (payload) {
        qrcode.makeCode(payload);
        $("#myModal").modal();
      }
    });
  </script>
</body>
</html>