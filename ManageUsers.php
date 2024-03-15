<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="ManageUsers.css">
    <link rel="stylesheet" href="ForManageUsers/Table.css">
    <link rel="stylesheet" href="Popup.css">
</head>

<header>
    <?php include "Navbar_Managers.php"; ?>
</header>
<body>

<div class="container-add">
    <button class="button-add">เพิ่มบัญชีผู้ใช้งาน +</button>
</div>

<div id="popupContainer" class="popup-container">
    <div class="popup-content">
        <!-- เพิ่มฟอร์มสำหรับกรอกข้อมูล -->
        <form id="registrationForm" method="post">
            <p>Name :</p> 
            <input class="text-box" type="text" id="name" name="name" placeholder="Name"></br></br>
            <p>Lastname :</p>
            <input class="text-box" type="text" id="lastname" name="lastname" placeholder="Lastname"></br></br>
            <p>Tel :</p>
            <input class="text-box" type="text" id="tel" name="tel" placeholder="Tel"></br></br>
            <p>หมายเลขบัตรประชาชน :</p>
            <input class="text-box" type="text" id="citizen_id" name="citizen_id" placeholder="หมายเลขบัตรประชาชน">

            <div id="citizen-error"></div><br>

            <p>Password :</p>
            <input class="text-box" type="password" id="password" name="password" placeholder="Password"></br></br>
            <p>Confirm Password :</p>
            <input class="text-box" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"></br></br>
            <p>Role :</p>
            <select id="role" name="role">
                <option value="user">Customer</option>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
                <option value="manager">Manager</option>
            </select><br>
            <button class="button-submit">Sign Up</button><br><br>
        </form>
        <!-- ปุ่มปิดหน้า pop-up -->
        <img id="closePopup" src="images/close_icon.png" alt="ปิด" onclick="closePopup()">
    </div>
</div>

<div class="container">
    <div class="menu">
        <button id="customersBtn">ลูกค้า</button>
        <button id="employeesBtn">พนักงาน</button>
        <button id="doctorsBtn">หมอ</button>
        <button id="managersBtn">ผู้จัดการ</button>
    </div>
</div>


<div class="format-table">
<div id="customerSearchContainer" style="display: none;">
        <div class="Search">
            <input type="text" id="customerSearchInput" placeholder="ค้นหาลูกค้า...">
            <div class="text-role">บัญชีผู้ใช้ของลูกค้า</div>
        </div>
</div>
<div id="userDataContainer"></div>
</div>


<div id="adminSearchContainer" style="display: none;">
        <div class="Search">
            <input type="text" id="adminSearchInput" placeholder="ค้นหาพนักงาน...">
            <div class="text-role">บัญชีผู้ใช้ของพนักงาน</div>
        </div>
</div>
<div id="adminDataContainer"></div>

<div id="doctorSearchContainer" style="display: none;">
        <div class="Search">
            <input type="text" id="doctorSearchInput" placeholder="ค้นหาหมอ...">
            <div class="text-role">บัญชีผู้ใช้ของหมอ</div>
        </div>
</div>
<div id="doctorDataContainer"></div>

<div id="managerSearchContainer" style="display: none;">
        <div class="Search">
            <input type="text" id="managerSearchInput" placeholder="ค้นหาผู้จัดการ...">
            <div class="text-role">บัญชีผู้ใช้ของผู้จัดการ</div>
        </div>
</div>
<div id="managerDataContainer"></div>


<script>

    // เลือกปุ่ม "เพิ่มบัญชีผู้ใช้งาน +"
    var addButton = document.querySelector('.button-add');

    // เลือก pop-up container
    var popupContainer = document.getElementById('popupContainer');

    // เลือกปุ่ม "ปิด"
    var closeButton = document.getElementById('closePopup');

    // เมื่อคลิกที่ปุ่ม "เพิ่มบัญชีผู้ใช้งาน +"
    addButton.addEventListener('click', function() {
        popupContainer.classList.add('active');
    });

    // เมื่อคลิกที่ปุ่ม "ปิด"
    closeButton.addEventListener('click', function() {
        popupContainer.classList.remove('active');
    });

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
                        document.getElementById("citizen_id").classList.add("duplicate-citizen");
                        document.getElementById("citizen-error").innerHTML = "ชื่อผู้ใช้นี้ถูกใช้งานแล้ว";
                    } else {
                        document.getElementById("citizen_id").classList.remove("duplicate-citizen");
                        document.getElementById("citizen-error").innerHTML = ""; 
                    }
                } else {
                    console.log("เกิดข้อผิดพลาดในการร้องขอ");
                }
            }
        };
        // ส่งข้อมูล citizen_id ไปยังไฟล์ PHP
        xhr.send("citizen_id=" + citizen_id);
    });
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
    xhr.open("POST", "AddRegister-Manager.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                closePopup();
                alert(xhr.responseText); // แสดงข้อความที่ได้รับจากไฟล์ PHP ผ่านการแจ้งเตือน
            } else {
                alert("มีข้อผิดพลาดในการส่งข้อมูล");
            }
        }
    };
    xhr.send(formData); // ส่งข้อมูล FormData ไปยังไฟล์ PHP
    });
    });
    // ฟังก์ชันสำหรับปิด popup
    function closePopup() {
        var popupContainer = document.getElementById('popupContainer');
        popupContainer.classList.remove('active');
    }


    document.getElementById("customersBtn").addEventListener("click", function() {
        document.getElementById("adminSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาพนักงาน
        document.getElementById("adminSearchInput").value = ''; // ล้างค่าในช่องค้นหาพนักงาน (หากมีการพิมพ์อยู่)
        document.getElementById("adminDataContainer").innerHTML = ''; // ล้างข้อมูลพนักงาน (หากมีการแสดงผลอยู่)
        document.getElementById("doctorSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาหมอ
        document.getElementById("doctorSearchInput").value = ''; // ล้างค่าในช่องค้นหาหมอ(หากมีการพิมพ์อยู่)
        document.getElementById("doctorDataContainer").innerHTML = ''; // ล้างข้อมูลหมอ (หากมีการแสดงผลอยู่)
        document.getElementById("managerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาmanager
        document.getElementById("managerSearchInput").value = ''; // ล้างค่าในช่องค้นหาmanager(หากมีการพิมพ์อยู่)
        document.getElementById("managerDataContainer").innerHTML = ''; // ล้างข้อมูลmanager (หากมีการแสดงผลอยู่)
        
        var customerSearchContainer = document.getElementById("customerSearchContainer");
        if (customerSearchContainer.style.display === "none") {
            customerSearchContainer.style.display = "block"; // แสดงช่องค้นหาลูกค้า
        }
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "ForManageUsers/users.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("userDataContainer").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
    });

            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("customerSearchInput").addEventListener("keyup", function() {
                    var searchText = this.value; // รับค่าที่ระบุในช่องค้นหา

                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "ForManageUsers/search_users.php?search=" + searchText, true); // ส่งคำขอ GET พร้อมกับข้อมูลคำค้นหาไปยังไฟล์ PHP
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("userDataContainer").innerHTML = xhr.responseText; // แสดงผลลัพธ์การค้นหาในตัวแปร userDataContainer
                        }
                    };
                    xhr.send();
                });
            });

        document.getElementById("employeesBtn").addEventListener("click", function() {
            document.getElementById("customerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาลูกค้า
            document.getElementById("customerSearchInput").value = ''; // ล้างค่าในช่องค้นหาลูกค้า (หากมีการพิมพ์อยู่)
            document.getElementById("userDataContainer").innerHTML = ''; // ล้างข้อมูลลูกค้า (หากมีการแสดงผลอยู่)
            document.getElementById("doctorSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาหมอ
            document.getElementById("doctorSearchInput").value = ''; // ล้างค่าในช่องค้นหาหมอ(หากมีการพิมพ์อยู่)
            document.getElementById("doctorDataContainer").innerHTML = ''; // ล้างข้อมูลหมอ (หากมีการแสดงผลอยู่)
            document.getElementById("managerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาmanager
            document.getElementById("managerSearchInput").value = ''; // ล้างค่าในช่องค้นหาmanager(หากมีการพิมพ์อยู่)
            document.getElementById("managerDataContainer").innerHTML = ''; // ล้างข้อมูลmanager (หากมีการแสดงผลอยู่)
                
            var adminSearchContainer = document.getElementById("adminSearchContainer");
            if (adminSearchContainer.style.display === "none") {
                adminSearchContainer.style.display = "block"; // แสดงช่องค้นหาพนักงาน
            }
            var xhr = new XMLHttpRequest();
                xhr.open("GET", "ForManageUsers/admin.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("adminDataContainer").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            });

            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("adminSearchInput").addEventListener("keyup", function() {
                    var searchText = this.value; // รับค่าที่ระบุในช่องค้นหา

                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "ForManageUsers/search_admin.php?search=" + searchText, true); // ส่งคำขอ GET พร้อมกับข้อมูลคำค้นหาไปยังไฟล์ PHP
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("adminDataContainer").innerHTML = xhr.responseText; // แสดงผลลัพธ์การค้นหาในตัวแปร userDataContainer
                        }
                    };
                    xhr.send();
                });
            });
            


        document.getElementById("doctorsBtn").addEventListener("click", function() {
            document.getElementById("adminSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาพนักงาน
            document.getElementById("adminSearchInput").value = ''; // ล้างค่าในช่องค้นหาพนักงาน (หากมีการพิมพ์อยู่)
            document.getElementById("adminDataContainer").innerHTML = ''; // ล้างข้อมูลพนักงาน (หากมีการแสดงผลอยู่)
            document.getElementById("customerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาลูกค้า
            document.getElementById("customerSearchInput").value = ''; // ล้างค่าในช่องค้นหาลูกค้า (หากมีการพิมพ์อยู่)
            document.getElementById("userDataContainer").innerHTML = ''; // ล้างข้อมูลลูกค้า (หากมีการแสดงผลอยู่)
            document.getElementById("managerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาmanager
            document.getElementById("managerSearchInput").value = ''; // ล้างค่าในช่องค้นหาmanager(หากมีการพิมพ์อยู่)
            document.getElementById("managerDataContainer").innerHTML = ''; // ล้างข้อมูลmanager (หากมีการแสดงผลอยู่)

            var doctorSearchContainer = document.getElementById("doctorSearchContainer");
            if (doctorSearchContainer.style.display === "none") {
                doctorSearchContainer.style.display = "block"; // แสดงช่องค้นหาหมอ
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "ForManageUsers/doctor.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("doctorDataContainer").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("doctorSearchInput").addEventListener("keyup", function() {
                var searchText = this.value; // รับค่าที่ระบุในช่องค้นหา

                var xhr = new XMLHttpRequest();
                xhr.open("GET", "ForManageUsers/search_doctor.php?search=" + searchText, true); // ส่งคำขอ GET พร้อมกับข้อมูลคำค้นหาไปยังไฟล์ PHP
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("doctorDataContainer").innerHTML = xhr.responseText; // แสดงผลลัพธ์การค้นหาในตัวแปร userDataContainer
                    }
                };
                xhr.send();
            });
        });


        document.getElementById("managersBtn").addEventListener("click", function() {
            document.getElementById("customerSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาลูกค้า
            document.getElementById("customerSearchInput").value = ''; // ล้างค่าในช่องค้นหาลูกค้า (หากมีการพิมพ์อยู่)
            document.getElementById("userDataContainer").innerHTML = ''; // ล้างข้อมูลลูกค้า (หากมีการแสดงผลอยู่)
            document.getElementById("doctorSearchContainer").style.display = "none"; // ซ่อนช่องค้นหาหมอ
            document.getElementById("doctorSearchInput").value = ''; // ล้างค่าในช่องค้นหาหมอ(หากมีการพิมพ์อยู่)
            document.getElementById("doctorDataContainer").innerHTML = ''; // ล้างข้อมูลหมอ (หากมีการแสดงผลอยู่)
            
            var managerSearchContainer = document.getElementById("managerSearchContainer");
            if (managerSearchContainer.style.display === "none") {
                managerSearchContainer.style.display = "block"; // แสดงช่องค้นหาพนักงาน
            }
            var xhr = new XMLHttpRequest();
                xhr.open("GET", "ForManageUsers/manager.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("managerDataContainer").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            });

            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("managerSearchInput").addEventListener("keyup", function() {
                    var searchText = this.value; // รับค่าที่ระบุในช่องค้นหา

                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "ForManageUsers/search_manager.php?search=" + searchText, true); // ส่งคำขอ GET พร้อมกับข้อมูลคำค้นหาไปยังไฟล์ PHP
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("managerDataContainer").innerHTML = xhr.responseText; // แสดงผลลัพธ์การค้นหาในตัวแปร userDataContainer
                        }
                    };
                    xhr.send();
                });
            });
            
            function deleteUser(citizen_id) {
                if (confirm('คุณแน่ใจหรือไม่ที่จะลบ ' + citizen_id + ' ออกจากระบบ?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'ForManageUsers/DeleteUsers.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert('ลบผู้ใช้งาน ' + citizen_id + ' ออกจากระบบเรียบร้อยแล้ว');
                            // สามารถเรียกฟังก์ชันหรือปรับปรุง UI ตามที่ต้องการได้
                            // ลบข้อมูลที่เกี่ยวข้องใน UI โดยตรงโดยไม่ต้องรีเฟรชหน้า
                            var element = document.getElementById(citizen_id); // ตัวอย่างการเข้าถึง element ที่ต้องการลบ
                            if (element) {
                                element.parentNode.removeChild(element); // ลบ element ออกจาก DOM
                            }
                        } else {
                            alert('เกิดข้อผิดพลาดในการลบผู้ใช้งาน');
                        }
                    };
                    xhr.send('citizen_id=' + citizen_id);
                }
            }
</script>

</body>
</html>


