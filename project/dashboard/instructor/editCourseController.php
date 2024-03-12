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
$course_name = $_GET['course'];
$description = $_POST['description'];
$price = $_POST['price'];
$creator_id = $user_id;

// ตรวจสอบว่ามีการเลือกไฟล์
if(isset($_FILES['course-image'])) {
    $course_image = $_FILES['course-image'];

    // ตรวจสอบว่ามีการเลือกไฟล์หรือไม่
    if ($course_image['error'] === UPLOAD_ERR_OK) {
        $file_data = file_get_contents($course_image['tmp_name']);

        // อัปเดตข้อมูลในฐานข้อมูล
        $query = "UPDATE Course SET courseimage = :courseimage, name = :name, description = :description, price = :price WHERE course_id = :course_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':courseimage', $file_data, SQLITE3_BLOB); // บันทึกข้อมูลภาพในรูปแบบ BLOB
        $stmt->bindParam(':name', $course_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':course_id', $course_id); // ใช้ course_id ที่ได้รับมาจากฟอร์ม
       
        if ($stmt->execute()) {
            echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
    }
} else {
    // กรณีไม่มีการอัปเดตภาพ
    $query = "UPDATE Course SET name = :name, description = :description, price = :price WHERE course_id = :course_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $course_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':course_id', $course_id); // ใช้ course_id ที่ได้รับมาจากฟอร์ม
    
    if ($stmt->execute()) {
        echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }
}

$next_page = "dashboard.php";
header("Location: $next_page");
exit();
?>
