<?php
// เชื่อมต่อกับฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่ารหัสคอร์สและราคามาหรือไม่
if(isset($_POST['course_id']) && isset($_POST['times_id']) && isset($_POST['price'])) {
    // รับค่ารหัสคอร์สและราคาที่ส่งมาจากฟอร์ม
    $course_id = $_POST['course_id'];
    $times_id = $_POST['times_id'];
    $price = $_POST['price'];

    // เตรียมคำสั่ง SQL สำหรับอัปเดตราคาของคอร์ส
    $sql = "UPDATE times_of_course SET price = :price WHERE course_id = :course_id AND times_id = :times_id";

    // เตรียมคำสั่ง SQL
    $stmt = $pdo->prepare($sql);
    
    // ทำการผูกค่า parameter และ execute คำสั่ง SQL
    $stmt->execute([
        'price' => $price,
        'course_id' => $course_id,
        'times_id' => $times_id
    ]);

    // ตรวจสอบว่าคำสั่ง SQL ทำงานสำเร็จหรือไม่
    if ($stmt->rowCount() > 0) {
        echo "อัปเดตราคาคอร์สเรียบร้อยแล้ว";
    } else {
        echo "ไม่สามารถอัปเดตราคาคอร์สได้";
    }
} else {
    echo "ไม่ได้รับข้อมูลที่จำเป็น";
}
?>
