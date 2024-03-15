<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../navbar_Customers.css">
    <link rel="stylesheet" href="RegisterAppointment.css">


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
      <form class="container-ID" action="ConnectDB/AddAppointment.php" method="post" onsubmit="return validateForm();">
            <p id="font-ID">วันที่ทำการนัดหมาย :
                <input type="date" name="date" id="dateforBook" class="text-box" style="width: 100px;"></br>
            </p>
            <p id="font-ID">เวลานัดหมาย :
            <select id="time" name="time" class="text-box">
                <option value="">--ระบุเวลา--</option>
                <option value="09.00 น.">09.00 น.</option>
                <option value="10.00 น.">10.00 น.</option>
                <option value="11.00 น.">11.00 น.</option>
                <option value="12.00 น.">12.00 น.</option>
                <option value="13.00 น.">13.00 น.</option>
                <option value="14.00 น.">14.00 น.</option>
                <option value="15.00 น.">15.00 น.</option>
                <option value="16.00 น.">16.00 น.</option>
                <option value="17.00 น.">17.00 น.</option>
                <option value="18.00 น.">18.00 น.</option>
                <option value="19.00 น.">19.00 น.</option>
                <option value="20.00 น.">20.00 น.</option>
            </select>
            </p>
            <p id="font-ID">ชื่อ-สกุล :
                <input type="text" id="patientName" name="patient_name" class="text-box" placeholder="กรุณากรอกข้อมูล" style="width: 300px;" 
                pattern="[ก-๙ะ-์A-Za-z\s]+" title="กรุณากรอกเป็นตัวอักษรเท่านั้น">
            </p>
            <p id="font-ID">เบอร์โทร :
                <input type="tel" id="phoneNumber" name="tel" class="text-box" placeholder="กรุณากรอกเบอร์โทรศัพท์" style="width: 150px;" 
                pattern="[0-9]{10}" title="กรุณากรอกเบอร์โทรศัพท์ 10 หลัก">
            </p>
            <button class="button-submit">นัดหมาย</button><br><br>
        </form>
    </div>

</body>

<script>

function validateForm() {
        // ดึงค่าที่กรอกในแต่ละช่อง
        var selectedDate = document.getElementById('dateforBook').value;
        var selectedTime = document.getElementById('time').value;
        var patientName = document.getElementById('patientName').value;
        var phoneNumber = document.getElementById('phoneNumber').value;

        // ตรวจสอบว่าทุกช่องมีข้อมูลหรือไม่
        if (selectedDate === '' || selectedTime === '' || patientName === '' || phoneNumber === '') {
            alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
            return false; // ไม่ submit ถ้าข้อมูลไม่ครบ
        }

        // ตรวจสอบว่าเวลาเริ่มต้นไม่ใช่ "--ระบุเวลา--"
        if (selectedTime === '--ระบุเวลา--') {
            alert('กรุณาเลือกเวลานัดหมาย');
            return false; // ไม่ submit ถ้าเวลาเริ่มต้นเป็น "--ระบุเวลา--"
        }

        // ตรวจสอบความถูกต้องของหมายเลขโทรศัพท์
        var phonePattern = /^[0-9]{10}$/; // ใช้ regex เพื่อตรวจสอบ
        if (!phonePattern.test(phoneNumber)) {
            alert('กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง (10 หลัก)');
            return false; // ไม่ submit ถ้าหมายเลขโทรศัพท์ไม่ถูกต้อง
        }

        // ถ้าผ่านการตรวจสอบทั้งหมด ให้ทำการ submit แบบฟอร์ม
        return true;
    }


    document.getElementById('dateforBook').addEventListener('change', function() {
        // ดึงค่าวันที่ที่ผู้ใช้เลือก
        var selectedDate = new Date(this.value);

        // ตรวจสอบว่าวันที่มีการเปลี่ยนแปลงจริงหรือไม่
        if (this.value !== '') {
            // ตรวจสอบว่าเป็นวันพุธหรือไม่
            if (selectedDate.getDay() === 3) { // 3 คือวันพุธ
                alert('ไม่สามารถเลือกวันพุธได้เนื่องจากเป็นวันหยุดประจำสัปดาห์ ขออภัยในความไม่สะดวก');
                this.value = ''; // ลบค่าวันที่ออก
            } 
        }
    });

    document.getElementById('dateforBook').addEventListener('change', function() {
        var selectedDate = this.value;

        // ทำการส่งค่าวันที่ไปยังไฟล์ PHP เพื่อค้นหาเวลาที่ถูกเลือกไปแล้ว
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "ConnectDB/CheckDate.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectedTimes = this.responseText;
                console.log(selectedTimes); // พิมพ์ข้อมูลเวลาที่ได้รับจาก PHP ในรูปแบบข้อความ
                removeSelectedTimes(selectedTimes);
                // สร้างอาร์เรย์และแสดงค่าในคอนโซล
                var selectedTimesArray = selectedTimes.split(',');
                console.log(selectedTimesArray);
            } else {
                console.error("เกิดข้อผิดพลาดในการส่งข้อมูล");
            }
        };

        xhr.send("selectedDate=" + selectedDate);
    });

    function removeSelectedTimes(selectedTimes) {
        // แสดงค่าที่ได้จากไฟล์ PHP ใน console
        var timeDropdown = document.getElementById('time');
        var options = timeDropdown.options;
        for (var i = options.length - 1; i >= 0; i--) {
            if (selectedTimes.includes(options[i].value)) {
                console.log("ค่าใน dropdown ที่จะถูกลบ: ", options[i].value); // แสดงค่าใน dropdown ที่จะถูกลบใน console
                timeDropdown.remove(i);
            }
        }
    }
</script>


</html>
