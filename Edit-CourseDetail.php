<?php
include "connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $recommend = $_POST['recommend'];
    $course_detail = $_POST['course_detail'];

    $stmt_image = null; // กำหนดให้เป็น null เริ่มต้น

    // ตรวจสอบว่าไฟล์รูปภาพถูกส่งมาหรือไม่
    if(isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
        // กำหนดตัวแปรเก็บข้อมูลเกี่ยวกับไฟล์รูปภาพ
        $file_name = $_FILES['upload']['name'];
        $file_tmp = $_FILES['upload']['tmp_name'];
    
        // ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ที่ต้องการเก็บ
        move_uploaded_file($file_tmp, "images/" . $file_name);
    
        // อัปเดตข้อมูลรูปภาพในฐานข้อมูล
        $stmt_image = $pdo->prepare("UPDATE course SET image = ? WHERE course_id = ?");
        $stmt_image->execute([$file_name, $course_id]);
    }
    
    // อัปเดตข้อมูลทั่วไปในฐานข้อมูล
    $stmt = $pdo->prepare("UPDATE course SET course_name = ?, recommend = ?, course_detail = ? WHERE course_id = ?");
    $stmt->execute([$course_name, $recommend, $course_detail, $course_id]);

    // ตรวจสอบว่ามีข้อมูลที่ถูกอัปเดตหรือไม่
    if($stmt->rowCount() > 0 || ($stmt_image && $stmt_image->rowCount() > 0)) {
        echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "ไม่สามารถอัปเดตข้อมูลได้";
    }
}
?>
