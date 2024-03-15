<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $citizen_id = $_POST['citizen_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE citizen_id = :citizen_id AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':citizen_id', $citizen_id);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['citizen_id'] = $user['citizen_id'];
        $_SESSION['role'] = $user['role'];

        // ส่งค่ากลับไปยังไฟล์ login.php เพื่อเก็บ Session และเปลี่ยนเส้นทางไปยังหน้า HomePageCustomers.php
        if ($user['role'] == 'user' || $user['role'] == 'admin' || $user['role'] == 'doctor' || $user['role'] == 'manager') {
            echo $user['role'];
        }
    } else {
        // ส่งค่า 'failed' กลับไปให้ไฟล์ login.php เพื่อระบุว่าการเข้าสู่ระบบไม่สำเร็จ
        echo 'failed';
    }
}
?>
