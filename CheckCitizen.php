<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า username จากฟอร์ม
    $citizen_id = $_POST['citizen_id'];

    // เตรียมคำสั่ง SQL สำหรับการตรวจสอบชื่อผู้ใช้
    $sql = "SELECT * FROM users WHERE citizen_id = :citizen_id";

    // เตรียมคำสั่ง SQL สำหรับการเตรียมคำสั่ง
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':citizen_id', $citizen_id, PDO::PARAM_STR);
    $stmt->execute();

    // ตรวจสอบว่ามี citizen_id นี้ในฐานข้อมูลหรือไม่
    $count = $stmt->rowCount();

    // ส่งผลลัพธ์กลับไปให้ JavaScript
    echo $count;
}
?>