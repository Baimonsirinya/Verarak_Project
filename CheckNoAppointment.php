<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="navbar_admin.css">
    <link rel="stylesheet" href="CheckNoAppointment.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
</head>


<body>
    <header>
        <?php include "Navbar_Customers.php" ?>
    </header>
    <div class="imageposition">
        <img src="images/01.jpg" width="350" height="300" >
    </div>
    <div class="card">
      <div class="card-header">นัดหมายและพบแพทย์</div>
      <br><p>หากเคยมีประวัติการรักษาโปรดกรอกหมายเลขบัตรประชาชนของท่าน</p>
      <form class="container-ID" id="CheckIDCard" method="post">
            <p id="font-ID">หมายเลขบัตรประชาชน :
                <input class="text-box" class="textbox" type="text"  name="id_card" id="id_card" placeholder="หมายเลขบัตรประชาชน" style="width: 300px;"></br>
            </p>
            <button class="button-submit">ยืนยัน</button><br><br>
        </form>
        <p>หากไม่เคยมีประวัติการรักษาโปรดคลิกที่ปุ่มลงทะเบียนเพื่อกรอกข้อมูลในการสร้างประวัติ</p>
        <a href="#" class="button-appointment">ลงทะเบียน</a><br><br>
    </div>

    <script>

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("CheckIDCard").addEventListener("submit", function(event) {
        event.preventDefault();

        var citizen_id = document.getElementById("id_card").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "CheckIDCard.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === "รหัสบัตรประชาชนนี้มีอยู่ในฐานข้อมูล") {
                    // ให้เปลี่ยนเส้นทาง URL ไปยังหน้าอื่นที่คุณต้องการ
                    window.location.href = "RegisterAppointment.php";
                } else {
                    alert("รหัสบัตรประชาชนนี้ไม่มีอยู่ในฐานข้อมูล");
                }
                } else {
                    alert("เกิดข้อผิดพลาดในการส่งข้อมูล");
                }
            }
        };
        xhr.send("id_card=" + encodeURIComponent(citizen_id));
    });
});
    </script>
      

</body>
</html>  