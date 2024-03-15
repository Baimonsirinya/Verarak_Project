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
        <title>Register</title>

        <!--responsive.css-->
    <!-- <link rel="stylesheet" href="responsive.css"> -->
	    <link rel="stylesheet" href="Navbar_admin.css">
        <link rel="stylesheet" href="register.css">
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="AddRegister.js"></script> -->

   
    </head>

	<body>
		<header>
        <?php include "Navbar_Customers.php" ?>
		</header>
      <div class="card">
        <div class="card-header">Sign up</div>
        <form class="container-register" id="registrationForm" method="post">
            <p>ชื่อ :</p> 
            <input class="text-box" type="text" id="name" name="name" placeholder="Name"></br></br>
            <p>นามสกุล :</p>
            <input class="text-box" type="text" id="lastname" name="lastname" placeholder="Lastname"></br></br>
            <p>เบอร์โทร :</p>
            <input class="text-box" type="text" id="tel" name="tel" placeholder="Tel"></br></br>
            <p>หมายเลขบัตรประชาชน :</p>
            <input class="text-box" type="text" id="citizen_id" name="citizen_id" placeholder="Username">
            <div id="username-error"></div><br>

            <p>Password :</p>
            <input class="text-box" type="password" id="password" name="password" placeholder="Password"></br></br>
            <p>Confirm Password :</p>
            <input class="text-box" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"></br></br>
            <button class="button-submit">Sign Up</button><br><br>
          </form>
          <p id="text-show">If you have an account, Please <a href="login.php">Login</p>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("citizen_id").addEventListener("input", function() {
        var citizen_id = this.value;

        // เรียกใช้งาน AJAX เพื่อตรวจสอบชื่อผู้ใช้
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "CheckCitizen.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // รับค่าจากไฟล์ PHP
                    var count = xhr.responseText;

                    // ถ้ามีชื่อผู้ใช้ในฐานข้อมูลแล้ว
                    if (count > 0) {
                        document.getElementById("citizen_id").classList.add("duplicate-username");
                        document.getElementById("username-error").innerHTML = "หมายเลขนี้ถูกใช้งานแล้ว";
                    } else {
                        document.getElementById("citizen_id").classList.remove("duplicate-username");
                        document.getElementById("username-error").innerHTML = ""; 
                    }
                } else {
                    console.log("เกิดข้อผิดพลาดในการร้องขอ");
                }
            }
        };
        // ส่งข้อมูล username ไปยังไฟล์ PHP
        xhr.send("citizen_id=" + citizen_id);
    });
    // เพิ่ม event listener สำหรับการ submit แบบฟอร์ม
    document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    // ตรวจสอบว่ารหัสผ่านและยืนยันรหัสผ่านตรงกันหรือไม่
    if (password !== confirm_password) {
        alert("รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน");

        // เพิ่มคลาส error ที่กล่อง input confirm password
        document.getElementById("confirm_password").classList.add("password-mismatch");
        return;
    } else {
        // ถ้ารหัสผ่านตรงกัน ลบคลาส error ที่กล่อง input confirm password ออก
        document.getElementById("confirm_password").classList.remove("password-mismatch");
    }

    // ถ้ารหัสผ่านตรงกัน ให้ทำการส่งข้อมูลไปยังไฟล์ PHP ตรวจสอบและบันทึกข้อมูล
    var formData = new FormData(this); // สร้าง FormData object จากแบบฟอร์ม

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "AddRegister.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert(xhr.responseText); // แสดงข้อความที่ได้รับจากไฟล์ PHP ผ่านการแจ้งเตือน
            } else {
                alert("มีข้อผิดพลาดในการส่งข้อมูล");
            }
        }
    };
    xhr.send(formData); // ส่งข้อมูล FormData ไปยังไฟล์ PHP
 });
});

    </script>
      
</body>
    </html>  