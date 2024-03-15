<?php
// เชื่อมต่อกับฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีข้อมูลที่ส่งมาจากแบบฟอร์มหรือไม่
if(isset($_POST['course_id']) && isset($_POST['course_name']) && isset($_POST['number_of_times']) && isset($_POST['price'])) {
    // รับค่าจากแบบฟอร์ม
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $number_of_times = $_POST['number_of_times'];
    $price = $_POST['price'];

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO times_of_course (course_id, course_name, number_of_times, price) VALUES (:course_id, :course_name, :number_of_times, :price)";

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในฐานข้อมูล
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':number_of_times', $number_of_times);
    $stmt->bindParam(':price', $price);

    // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
    if ($stmt->execute()) {
        echo "บันทึกข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->errorInfo()[2];
    }

} else {
    // ถ้าไม่มีข้อมูลที่ส่งมาจากแบบฟอร์ม
    echo "ไม่สามารถเข้าถึงข้อมูลได้";
}
?>
