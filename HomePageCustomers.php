<?php include "connect.php" ?>


<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!--font-family-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;subset=devanagari,latin-ext" rel="stylesheet">

    <!-- title of site -->
    <title>HomePageCustomers</title>

    <!--responsive.css-->
    <link rel="stylesheet" href="HomePageCustomers.css">
</head>

<body>
<header>
    <?php include "Navbar_Customers.php" ?>
</header>

<div id="welcome-hero" class="welcome-hero"></div>
<div class="color-service">
    <div id="font-text">บริการของเรา</div>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM course");
    $stmt->execute();
    $counter = 0; // เริ่มต้นนับคอร์ส
    while ($row = $stmt->fetch()) :
        if ($counter < 6) : // แสดงเฉพาะ 2 อันแรก
    ?>
        <div class="container">
            <div class="square">
                <img src="images/<?= $row["image"] ?>" class="mask">
                <div class="h1"><?= $row["course_name"] ?></div>
                <p><?= $row["recommend"] ?></p>
                <div><a href="Course.detail.php?id=<?= $row['course_id'] ?>" class="button">Read More</a></div>
            </div>
        </div>
    <?php
        endif;
        $counter++;
    endwhile;

    // ถ้ายังมีคอร์สอื่นๆ อีก
    if ($counter > 6) :
    ?>
    <div>
        <a href="view_all_courses.php" class="button">ดูคอร์สทั้งหมด</a>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
