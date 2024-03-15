<?php
include "connect.php";

if(isset($_POST['times_id']) && isset($_POST['price'])) {
    $times_id = $_POST['times_id'];
    $price = $_POST['price'];

    // อัปเดตข้อมูลราคาในตาราง times_of_course
    $stmt = $pdo->prepare("UPDATE times_of_course SET price = ? WHERE times_id = ?");
    $stmt->execute([$price, $times_id]);

    if($stmt->rowCount() > 0) {
        echo "อัปเดตราคาสำเร็จ";
    } else {
        echo "ไม่สามารถอัปเดตราคาได้";
    }
}
?>