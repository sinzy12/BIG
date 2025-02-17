<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองที่นั่งเมล์</title>
    <link href="styles.css" rel="stylesheet">
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0056b3;
        }
        .navbar a {
            color: #fff !important;
        }
        .booking-form {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .booking-form h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .btn {
            width: 100%;
            padding: 10px;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .price-info {
            margin-top: 15px;
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">แบรนด์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="howw.html">วิธีการจองและการชำระเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">ผู้จัดทำ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin/login.php">สำหรับแอดมิน</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="booking-form container">
        <h2>จองที่นั่ง</h2>
        <form id="bookingForm" method="POST">
            <div class="mb-3">
                <label for="route" class="form-label">รถเมล์สาขาพิชัย:</label>
                <select id="route" name="route" class="form-control" required>
                    <option value="">เลือกเส้นทาง</option>
                    <option value="รอบแรก">พิชัย - อุตรดิตถ์</option>
                    <option value="รอบสอง">อุตรดิตถ์ - พิชัย</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="user_n" class="form-label">ชื่อ:</label>
                <input type="text" id="user_n" name="user_n" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">เวลา:</label>
                <select id="time" name="time" class="form-control" required>
                    <option value="">เลือกเวลา</option>
                    <optgroup label="พิชัย - อุตรดิตถ์">
                        <option value="06:00-07:00">06:00 - 07:00</option>
                        <option value="09:00-10:00">09:00 - 10:00</option>
                        <option value="16:00-17:00">16:00 - 17:00</option>
                    </optgroup>
                    <optgroup label="อุตรดิตถ์ - พิชัย">
                        <option value="07:30-08:30">07:30 - 08:30</option>
                        <option value="11:00-12:00">11:00 - 12:00</option>
                        <option value="18:00-19:00">18:00 - 19:00</option>
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">วันที่:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3" >
                <label for="seats" class="form-label">เลือกที่นั่ง (ที่นั่งมีจำนวน 15 ที่ ):</label>
                <input type="number" id="seats" name="seats" class="form-control" min="1" max="15" required>
            </div>
            <div class="price-info">
                เลขที่บัญชี: 187-3-72937-3 <br>
                ราคาค่าบริการ: 30 บาท
            </div>
            <div class="mb-3">
                <input type="file" id="Slip" name="Slip" style="display: none;">
                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('Slip').click()">สลิปการโอนเงิน</button>
            </div>

           

            <div class="d-flex justify-content-between">
                <button id="submitBtn" type="submit" class="btn btn-success btn-lg w-50">จองที่นั่ง</button>
                <button type="button" id="cancelBooking" class="btn btn-danger btn-lg w-50">ยกเลิกการจอง</button>
            </div>
        </form>
        <div id="confirmationMessage"></div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        let isSubmitting = false;

        $('#submitBtn').click(function(e) {
            e.preventDefault();
            if (isSubmitting) {
                return false;
            }
            isSubmitting = true;

            const route = $('#route').val();
            const user_n = $('#user_n').val();
            const time = $('#time').val();
            const date = $('#date').val();
            const seats = $('#seats').val();
            const Slip = $('#Slip')[0].files[0];

            if (route && user_n && time && date && seats && Slip) {
                $('#submitBtn').prop('disabled', true).text('กำลังส่งข้อมูล...');

                const formData = new FormData();
                formData.append('route', route);
                formData.append('user_n', user_n);
                formData.append('time', time);
                formData.append('date', date);
                formData.append('seats', seats);
                formData.append('Slip', Slip);

                $.ajax({
    url: 'backend.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.includes("คุณได้จองที่นั่งนี้ไว้แล้ว")) {
            Swal.fire({
                title: 'คุณได้จองที่นั่งนี้ไว้แล้ว',
                text: response,
                icon: 'info',
                confirmButtonText: 'ตกลง'
            });
        } else if (response.includes("ที่นั่งนี้มีคนจองแล้ว")) {
            Swal.fire({
                title: 'ที่นั่งนี้มีคนจองแล้ว',
                text: response,
                icon: 'warning',
                confirmButtonText: 'ตกลง'
            });
        } else {
            Swal.fire({
                title: 'สำเร็จ!',
                text: 'สลิปถูกส่งเรียบร้อยแล้ว',
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                Swal.fire({
                    title: 'จองสำเร็จ',
                    text: 'ขอบคุณที่ใช้บริการ',
                    icon: 'success',
                    confirmButtonText: 'ตกลง'
                });
            });
        }
    },
    error: function() {
        Swal.fire({
            title: 'ข้อผิดพลาด!',
            text: 'เกิดข้อผิดพลาดในการติดต่อกับเซิร์ฟเวอร์',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
    },
    complete: function() {
        $('#submitBtn').prop('disabled', false).text('จองที่นั่ง');
        isSubmitting = false;
    }
});

            } else {
                Swal.fire({
                    title: 'ข้อผิดพลาด!',
                    text: 'กรุณากรอกข้อมูลทั้งหมด',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
            }
        });
    </script>
</body>
</html>
