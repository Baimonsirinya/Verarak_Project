<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_card = $_POST['id_card'];

    // Prepare a SELECT statement to check if the citizen ID exists
    $sql = "SELECT id_card FROM medical_records WHERE id_card = :id_card";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_card', $id_card, PDO::PARAM_STR); // แก้เป็น $citizen_id จาก $id_card
    $stmt->execute();

    // Fetch all rows matching the citizen ID
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        // Citizen ID exists in the database
        echo "รหัสบัตรประชาชนนี้มีอยู่ในฐานข้อมูล";
    } else {
        // Citizen ID does not exist in the database
        echo "รหัสบัตรประชาชนนี้ไม่มีอยู่ในฐานข้อมูล";
    }
}
?>