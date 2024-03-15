<?php
include "connect.php";

// รับข้อมูลจาก AJAX
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$tel = $_POST['tel'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// ตรวจสอบว่า Username ซ้ำหรือไม่


$sql_check = "SELECT * FROM users WHERE username = :username";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindParam(':username', $username);
$stmt_check->execute();

if ($stmt_check->rowCount() > 0) {
    echo "ขออภัย ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว";
    exit();
}

// ถ้า Username ไม่ซ้ำกัน ก็ทำการบันทึกข้อมูล
$sql_insert = "INSERT INTO users (username, name, lastname, tel, password, role) VALUES (:username, :name, :lastname, :tel, :password, :role)";

$stmt_insert = $pdo->prepare($sql_insert);
$stmt_insert->bindParam(':username', $username);
$stmt_insert->bindParam(':name', $name);
$stmt_insert->bindParam(':lastname', $lastname);
$stmt_insert->bindParam(':tel', $tel);
$stmt_insert->bindParam(':password', $password);
$stmt_insert->bindParam(':role', $role);

if ($stmt_insert->execute()) {
    echo "บันทึกข้อมูลเรียบร้อยแล้ว";
} else {
    echo "มีบางอย่างผิดพลาดในการบันทึกข้อมูล";
}
?>