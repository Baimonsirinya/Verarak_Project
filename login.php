<?php include "connect.php" ?>

<html lang="en">
    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;subset=devanagari,latin-ext" rel="stylesheet">
        
        <!-- title of site -->
        <title>Login</title>

        <!--responsive.css-->
    <!-- <link rel="stylesheet" href="responsive.css"> -->
	  <link rel="stylesheet" href="Navbar_admin.css">
    <link rel="stylesheet" href="login.css">
   
    </head>
	<body>
		<header>
            <?php include "Navbar_Customers.php" ?>
        </header>

        <form id ="container-login" action="CheckLogin.php" method="post">
      
            <div id="icon"><img src="images/person-icon.png" width="100"></div>
            <p>เลขบัตรประจำตัวประชาชน: </p>
            <input id="text-box" type="text" name="citizen_id" placeholder="เลขบัตรประจำตัวประชาชน"><br><br>
            <p>Password : </p>
            <input id="text-box" type="password" name="password" placeholder="Password"><br><br>
            <div id="message"></div>
            <button class="button-submit">Login</button><br><br>
      </form>

    
<script>

    document.getElementById('container-login').addEventListener('submit', function(event) {
    event.preventDefault(); // หยุดการส่งข้อมูลแบบฟอร์มเพื่อใช้ AJAX แทน

    var form = this;
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'CheckLogin.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'user') {
                    // กรณีเข้าสู่ระบบสำเร็จ
                    window.location.href = 'HomePageCustomers.php';
                } else if  (response === 'admin') {
                    window.location.href = 'FormAddCourse.php';
                } else if  (response === 'doctor') {
                    window.location.href = 'doctor.php';
                } else if (response === 'manager') {
                    window.location.href = 'ManageCourse.php';
                } else {
                    var element = document.getElementById("message");
                    // เปลี่ยนเนื้อหาของอิลิเมนต์
                    element.innerHTML = "เลขบัตรประจำตัวประชาชน หรือ Password ไม่ถูกต้อง";
                    element.className = "message";
                }
            } else {
                // กรณีมีข้อผิดพลาดในการร้องขอ
                alert('เกิดข้อผิดพลาดในการร้องขอ');
            }
        }
    };
    xhr.send(formData);
});

</script>

   
      
      </body>
    </html>  