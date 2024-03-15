<?php include "connect.php"; ?>

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
    <title>AddCourse</title>

    <!--responsive.css-->
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="ManageCourse.css">
    <!-- <link rel="stylesheet" href="HomePageCustomers.css"> -->
   
</head>
<header>
    <?php include "Navbar_Managers.php"; ?>
</header>
<body>
    <a href="AddCourse.php" class="button-add">เพิ่มคอร์การรักษา +</a>

    <?php
        $stmt = $pdo->prepare("SELECT * FROM course");
        $stmt->execute();
        while($row = $stmt->fetch()) :
    ?>
	<div class="container">
        <img src="images/<?= $row['image']; ?>" alt="<?= $row['course_name']; ?>">
        <div class="position">
            <h1><?= $row['course_name']; ?></h1>
            <p><?= $row["recommend"] ?></p> 
            <a href="FormEdit.php?id=<?= $row['course_id'] ?>" class="button-edit">แก้ไข</a>
            <a href="CourseDelete.php?id=<?= $row['course_id'] ?>" class="button-delete">ลบ</a>   
        </div>
    </div>
      
	  <?php endwhile; ?>
  
</body>
</html>