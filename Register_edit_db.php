<?php
include_once "db.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $firstlast = $_POST['firstlast'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $idcard = $_POST['idcard'];
    $img = $_FILES['img']['name'];

    // Handle file upload if needed
    // move_uploaded_file($_FILES['img']['tmp_name'], "upload/" . $img);

    $sql = "UPDATE `tbl_test` SET `m_first`='$firstlast', `m_user`='$user', `m_pass`='$pass', `m_phone`='$phone', `m_email`='$email', `m_address`='$address', `m_idcard`='$idcard', `m_img`='$img' WHERE `m_id`='$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['insert'] = "success";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
