<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cc_id = intval($_GET['id']);

    $sql = "SELECT * FROM car_cate WHERE cc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = $result->fetch_assoc();

    echo json_encode($brand);
}
?>
