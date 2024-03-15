<?php
// ตรวจสอบว่ามีการส่งค่า times_id มาหรือไม่
if(isset($_POST['times_id'])) {
    // เชื่อมต่อกับฐานข้อมูล
    include 'connect.php';

    // รับค่า times_id จากการส่งข้อมูล
    $times_id = $_POST['times_id'];

    // เตรียมคำสั่ง SQL สำหรับลบแถวที่มี times_id ที่ระบุ
    $stmt = $pdo->prepare("DELETE FROM times_of_course WHERE times_id = ?");
    $stmt->execute([$times_id]);

    // ตรวจสอบว่าลบข้อมูลสำเร็จหรือไม่
    if($stmt->rowCount() > 0) {
        // ส่งข้อความกลับไปยัง JavaScript เพื่อแสดงผลใน console
        echo "ลบข้อมูลสำเร็จ";
    } else {
        // ส่งข้อความกลับไปยัง JavaScript เพื่อแสดงผลใน console
        echo "ไม่สามารถลบข้อมูลได้";
    }
} else {
    // หากไม่มีการส่งค่า times_id มา
    echo "ไม่พบข้อมูลที่ต้องการลบ";
}
?>
