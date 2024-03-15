<?php
// เชื่อมต่อกับฐานข้อมูล
include "connect.php";

// ตรวจสอบว่ามีการส่งค่า id ของคอร์สมาหรือไม่
if(isset($_GET['id'])) {
    // ดึงค่า id ของคอร์สจาก URL
    $course_id = $_GET['id'];

    // เตรียมคำสั่ง SQL เพื่อดึงข้อมูลของคอร์ส
    $stmt = $pdo->prepare("SELECT c.*, t.number_of_times, t.price FROM course c 
                           LEFT JOIN times_of_course t ON c.course_id = t.course_id WHERE c.course_id = ?");
    $stmt->execute([$course_id]);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Detail</title>
    
    <link rel="stylesheet" href="Course_detail.css">
</head>
<header>
    <?php include "Navbar_Customers.php" ?>
</header>
<body>
    <div class="container">
        <?php if(isset($courses) && count($courses) > 0): ?>
            <?php foreach($courses as $key => $course): ?>
                    <?php if($key === 0): ?>
                        <img src="images/<?= $course['image']; ?>" alt="<?= $course['course_name']; ?>">
                        <div>
                            <h1><?= $course['course_name']; ?></h1>
                            <?php endif; ?>
                                <br><a href="#" class="botton-sale"><p><?= $course['number_of_times']; ?> ครั้ง ราคา <?= $course['price']; ?> บาท</p></a>
                            <?php endforeach; ?>
                         </div>
    </div>
    <div class = "card-detail">
        <h3>รายละเอียด</h3>
        <p class = "text-detail"><?= $course['course_detail']; ?></p>
    </div>
    <?php else: ?>
        <p>Course not found.</p>
    <?php endif; ?>
</body>
</html>