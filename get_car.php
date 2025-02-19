<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cm_id = intval($_GET['id']);

    $sql = "SELECT * FROM car_modal WHERE cm_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    echo json_encode($car);
}
?>
