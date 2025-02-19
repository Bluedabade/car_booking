<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    <!-- css -->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <!-- jss -->
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- style -->
    <style>
        body {
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url(./img/bannerlogin.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-color: #BAD8B6;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .password-container {
            position: relative;
            width: 300px;
        }

        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .eye-icon {
            position: absolute;
            right: 40px;
            top: 59%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

    <!-- font -->
    <style>
      @font-face {
      font-family: "Athiti";
      src: url("./font/Athiti-Medium.ttf") format("truetype");
    }

        body {
            font-family: "Athiti";

        }
    </style>

</head>

<br><br><br>

<body>


    <div class="container" >
        <div class="row mt-5 justify-content-center" >
            <div class="col-md-6" >
                <div class="card p-4 shadow" style="background-color:#E1EACD;">
                    <form action="./Login_db.php" method="POST">
                        <h1 class="text-center">เข้าสู่ระบบ</h1>
                        <div class="col">

                            <div>
                                <input class="form-control mb-3" name="email" type="Email" style="background-color:#F9F6E6;" placeholder="อีเมล" autofocus require>
                            </div>

                            <div>
                                <!-- ฟอร์มรหัสผ่าน -->
                                <input class="form-control" name="pass" id="password" type="password" style="background-color:#F9F6E6;"  placeholder="กรุณากรอกรหัสผ่าน">
                                <!-- ไอคอนรูปตา -->
                                <span id="eye-icon" class="eye-icon">👁️</span>
                            </div>

                            <div class="d-flex gap-3">
                                <button class="btn  mb-1 w-100 mt-4" style="background-color: #8D77AB;" href="./index.php" type="submit" name="submit">เข้าสู่ระบบ</button>
                                <a class="btn w-100 mb-1 mt-4" style="background-color: #E16A54;" href="./Register.php">สร้างบัญชีใหม่</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
        // เลือกอิลิเมนต์ที่เกี่ยวข้อง
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        // ฟังก์ชันเปิด/ปิดการแสดงรหัสผ่าน
        eyeIcon.addEventListener('click', () => {
            if (passwordField.type === "password") {
                passwordField.type = "text"; // เปลี่ยนให้แสดงรหัสผ่าน
                eyeIcon.textContent = "🙈"; // เปลี่ยนไอคอนตาเป็นไอคอนซ่อน
            } else {
                passwordField.type = "password"; // เปลี่ยนให้ซ่อนรหัสผ่าน
                eyeIcon.textContent = "👁️"; // เปลี่ยนไอคอนตาเป็นไอคอนแสดง
            }
        });
    </script>




</body>

</html>