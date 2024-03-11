<?php
session_start();

// เชื่อมต่อ SQLite3 database
$db = new SQLite3('../../db/table.db');

if (!$db) {
    echo $db->lastErrorMsg();
    exit();
}
$username = $_SESSION['username'];
$sql = "SELECT * FROM Users WHERE username = '$username';";
$result = $db->query($sql);
$row = $result->fetchArray(SQLITE3_ASSOC);
$user_id = $row['user_id'];

// รับข้อมูลจากฟอร์ม
$course_name = $_POST['course-name'];
$description = $_POST['description'];
$price = $_POST['price'];
$creator_id = $user_id;

// ตรวจสอบว่ามีการเลือกภาพหรือไม่
if(isset($_FILES['course-image'])) {
    $course_image = $_FILES['course-image'];

    // ตรวจสอบว่ามีการเลือกภาพหรือไม่
    if ($course_image['error'] === UPLOAD_ERR_OK) {
        // สร้างตำแหน่งที่จะบันทึกไฟล์ภาพ
        $upload_dir = 'courseImage/';
        $file_name = uniqid() . '_' . $course_image['name'];
        $destination = $upload_dir . $file_name;

        // ย้ายไฟล์ภาพไปยังตำแหน่งที่ต้องการ
        if (move_uploaded_file($course_image['tmp_name'], $destination)) {
            // บันทึกข้อมูลลงในฐานข้อมูล
            $query = "INSERT INTO Course (courseimage, name, description, creator_id, price, date_created) 
                VALUES (:courseimage, :name, :description, :creator_id, :price, datetime('now'))";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':courseimage', $destination); // บันทึกที่อยู่ของไฟล์ภาพ
            $stmt->bindParam(':name', $course_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':creator_id', $creator_id);
            $stmt->bindParam(':price', $price);
            
            if ($stmt->execute()) {
                echo "บันทึกข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
            }
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดภาพ";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการรับข้อมูลภาพ";
    }
} else {
    echo "ไม่ได้เลือกภาพ";
}
$next_page = "dashboard.php";
header("Location: $next_page");
exit();