<?php
include "connect.php";

// รับข้อมูลจากฟอร์ม
$course_id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$recommend = $_POST['recommend'];
$course_detail = $_POST['course_detail'];

// Get the uploaded file
$file_name = $_FILES["upload"]["name"];
$file_tmp = $_FILES["upload"]["tmp_name"];
$file_new_name = rand(0, microtime(true)) . "-" . $file_name;
$file_destination = "images/" . $file_new_name;

// Move uploaded file to destination directory
if (move_uploaded_file($file_tmp, $file_destination)) {
    // Insert data into 'course' table
    $sql = "INSERT INTO course (course_id, course_name, recommend, course_detail, image) 
            VALUES (:course_id, :course_name, :recommend, :course_detail, :image)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':recommend', $recommend);
    $stmt->bindParam(':course_detail', $course_detail);
    $stmt->bindParam(':image', $file_new_name);

    $stmt->execute();
} else {
    echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
}
?>




