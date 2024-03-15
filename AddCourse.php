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
        <title>AddCourse</title>

        <!--responsive.css-->
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="FormEdit.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "run_course_id.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("course_id_input").value = xhr.responseText;
                } else {
                    console.error("เกิดข้อผิดพลาดในการรับข้อมูล course_id");
                }
            }
        };
        xhr.send();
    });
    </script>
   
    </head>
    <header>
        <?php include "Navbar_Managers.php" ?>
	</header>
	<body>
    <div class="font-text">เพิ่มคอร์สการรักษา</div>
      <form class="container-ID" id="myForm" method="post"  enctype="multipart/form-data">
	  		<p id="font-ID">รหัสคอร์ส :
              <input type="text" class="text-box" id="course_id_input" name="course_id" tyle="width: 200px;" readonly><br>
            </p>
            <img id="course_image">
            <p id="font-ID">โปรดเลือกรูปภาพ:
            <label for="file-upload" class="custom-file-upload">
                Choose file
            </label>
            <input id="file-upload" type="file" name="upload">
            </p>
            <p id="font-ID">ชื่อคอร์สการรักษา :
                <input  class="text-box" type="text" id="course_name" name="course_name" placeholder="" style="width: 200px;"><br>
            </p>
            <table id="resultTable" class="TableResult">
            <thead>
                <tr>
                    <th>จำนวนครั้ง</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
                <!-- ค่าจะถูกเพิ่มที่นี่โดยใช้ JavaScript -->
            </tbody>
            </table>
                    
                <div id="formContainer" style="display: none;">
                        <!-- Form ที่เด้งขึ้นมาตอนหลัง -->
                        <div id="display"></div>
                        <p id="font-ID">จำนวนครั้ง :
                            <input type="number" class="text-box" name="number_of_times" id="number_of_times" style="width: 50px;">
                            <input type="number" class="text-box" name="price" id="price" style="width: 100px;">
                        </p>
                        <button id="submitButton" name ="submit">Submit</button>
                </div>

            <button type="button" id="showFormButton" class = "ShowBotton">เพิ่มจำนวนครั้ง +</button>

            <p id="font-ID">รายละเอียดแนะนำ :
                <textarea class="text-box" type="text" id="recommend" name="recommend" placeholder="#" style="width: 300px;"></textarea><br>
            </p>
            </p>
            <p id="font-ID">รายละเอียดเพิ่มเติม :
                <textarea class="text-box" type="text" id="course_detail" name="course_detail" placeholder="#" style="width: 400px;"></textarea><br>
            </p>
            <button type="button" class="button-submit" name="botton" id="submitButtonOuter">บันทึก</button><br><br>
        </form>

    

	
    <script>
		// เพิ่ม event listener สำหรับปุ่ม Show Form
		document.getElementById('showFormButton').addEventListener('click', function() {
		document.getElementById('formContainer').style.display = 'block';
		});

        document.addEventListener("DOMContentLoaded", function() {
    // เมื่อมีการเลือกไฟล์ภาพ
        document.querySelector('input[type="file"]').addEventListener('change', function() {
        // ตรวจสอบว่ามีการเลือกไฟล์ภาพหรือไม่
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            // เมื่ออ่านไฟล์เสร็จสิ้น
            reader.onload = function(e) {
                // รับ URL ของรูปภาพ
                var imageURL = e.target.result;

                // แสดงรูปภาพในอิลิเมนต์ <img>
                document.getElementById('course_image').setAttribute('src', imageURL);
            }

            // อ่านไฟล์ภาพ
            reader.readAsDataURL(this.files[0]);
        }
        });
    });


        document.addEventListener("DOMContentLoaded", function() {
        // การเชื่อมโยงกับปุ่ม Submit ภายในฟอร์ม
        document.getElementById('submitButton').addEventListener('click', function() {
        event.preventDefault();
        // เก็บค่าจากฟอร์ม
        var course_id = document.getElementById('course_id_input').value;
        var course_name = document.getElementById('course_name').value;
        var number_of_times = document.getElementById('number_of_times').value;
        var price = document.getElementById('price').value;

        // สร้างข้อมูลที่จะส่งไปยังไฟล์ AddnumofCourse
        var data = new FormData();
        data.append('course_id', course_id);
        data.append('course_name', course_name);
        data.append('number_of_times', number_of_times);
        data.append('price', price);

        // เรียกใช้งาน XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'AddnumofCourse.php', true);

        // ส่งข้อมูลไปยังไฟล์ AddnumofCourse
        xhr.onload = function() {
            if (xhr.status === 200) {
                // การดำเนินการหลังจากทำการส่งข้อมูลสำเร็จ
                alert('การส่งข้อมูลไปยัง AddnumofCourse.php เสร็จสิ้น');

                // สร้างแถวในตาราง
                var table = document.getElementById('resultTable').getElementsByTagName('tbody')[0];
                var newRow = table.insertRow(table.rows.length);

                // เพิ่มเซลล์ในแถวใหม่
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);

                // กำหนดค่าในเซลล์
                cell1.innerHTML = number_of_times;
                cell2.innerHTML = price;
                
            } else {
                // การดำเนินการหลังจากที่เกิดข้อผิดพลาดในการส่งข้อมูล
                alert('เกิดข้อผิดพลาดในการส่งข้อมูลไปยัง AddnumofCourse.php');
            }
        };

        // ส่งข้อมูล
        xhr.send(data);
    });

    // การเชื่อมโยงกับปุ่ม Submit ภายนอกฟอร์ม
        document.getElementById('submitButtonOuter').addEventListener('click', function() {
        event.preventDefault();

        // เก็บค่าจากฟอร์ม
        var course_id = document.getElementById('course_id_input').value;
        var course_name = document.getElementById('course_name').value;
        var recommend = document.getElementById('recommend').value;
        var course_detail = document.getElementById('course_detail').value;
        var upload = document.querySelector('input[type=file]').files[0];

        // สร้างข้อมูลที่จะส่งไปยังไฟล์ upload.php
        var data = new FormData();
        data.append('course_id', course_id);
        data.append('course_name', course_name);
        data.append('recommend', recommend);
        data.append('course_detail', course_detail);
        data.append('upload', upload);

        // เรียกใช้งาน XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php', true);

        // ส่งข้อมูลไปยังไฟล์ upload.php
        xhr.onload = function() {
            if (xhr.status === 200) {
                // การดำเนินการหลังจากทำการส่งข้อมูลสำเร็จ
                alert('การส่งข้อมูลไปยัง upload.php เสร็จสิ้น');
            } else {
                // การดำเนินการหลังจากที่เกิดข้อผิดพลาดในการส่งข้อมูล
                alert('เกิดข้อผิดพลาดในการส่งข้อมูลไปยัง upload.php');
            }
        };

        // ส่งข้อมูล
        xhr.send(data);
    });
});
    </script>
    
	</body>
	
</html>
		
