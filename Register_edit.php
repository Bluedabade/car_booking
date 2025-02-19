<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD System</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./icon/bootstrap-icons.css">
    <style>
        @font-face {
            font-family: "Prompt";
            src: url(Font/Prompt-Light.ttf) format('truetype');
        }

        body {
            font-family: "Prompt";
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <?php
                    include_once 'db.php';
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM `tbl_test` WHERE `m_id` = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                        <form action="Register_edit_db.php" method="post" enctype="multipart/form-data">
                            <h1 class="text-center">แก้ไขข้อมูลสมาชิก</h1>

                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['m_id']); ?>">

                            <label for="firstlast" class="form-label">ชื่อ-สกุล</label>
                            <input type="text" class="form-control mb-3" name="firstlast" autofocus required value="<?php echo htmlspecialchars($row['m_first']); ?>">

                            <label for="user" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control mb-3" name="user" required value="<?php echo htmlspecialchars($row['m_user']); ?>">

                            <label for="pass" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control mb-3" name="pass" required value="<?php echo htmlspecialchars($row['m_pass']); ?>">

                            <label for="password" class="form-label">ยืนยันรหัสผ่าน</label>
                            <input type="password" class="form-control mb-3" name="password" required value="<?php echo htmlspecialchars($row['m_mpass']); ?>">

                            <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="tel" class="form-control mb-3" name="phone" required value="<?php echo htmlspecialchars($row['m_phone']); ?>">

                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control mb-3" name="email" required value="<?php echo htmlspecialchars($row['m_email']); ?>">

                            <label for="address" class="form-label">ที่อยู่</label>
                            <input type="text" class="form-control mb-3" name="address" required value="<?php echo htmlspecialchars($row['m_address']); ?>">

                            <label for="idcard" class="form-label">บัตรประชาชน</label>
                            <input type="text" class="form-control mb-3" name="idcard" maxlength="13" required value="<?php echo htmlspecialchars($row['m_idcard']); ?>">

                            <label for="img" class="form-label">อัพโหลดใบขับขี่</label>
                            <input type="file" class="form-control mb-3" name="img">

                            <div class="d-flex">
                                <input type="submit" value="ตกลง" name="submit" class="btn btn-success w-100">
                                <a href="member.php" class="btn btn-danger w-100">ย้อนกลับ</a>
                            </div>
                        </form>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>ไม่พบข้อมูล</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
