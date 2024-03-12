<?php
session_start();
$username = $_SESSION['username'];
$coursename = $_GET['course'];
$db = new SQLite3('../../db/table.db');
if (!$db) {
    echo $db->lastErrorMsg();
    exit();
}

$chapnum = $_POST['chapNo'];
$chapname = $_POST['chapname'];
$linkVideo = $_POST['LinkVideo'];
$description = $_POST['chapDes'];



// Handle file upload
$upload_dir = 'courseFile/';
$file_name = uniqid() . '_' . $_FILES['fileToUpload']['name'];
$destination = $upload_dir . $file_name;
move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destination);

// Insert data into Chapter table
$stmt = $db->prepare("INSERT INTO Chapter (course_id, chapterNo, name, link, description, file_path) VALUES ((SELECT id FROM Course WHERE name = :coursename), :chapnum, :chapname, :linkVideo, :description, :destination)");
$stmt->bindValue(':coursename', $coursename, SQLITE3_TEXT);
$stmt->bindValue(':chapnum', $chapnum, SQLITE3_INTEGER);
$stmt->bindValue(':chapname', $chapname, SQLITE3_TEXT);
$stmt->bindValue(':linkVideo', $linkVideo, SQLITE3_TEXT);
$stmt->bindValue(':description', $description, SQLITE3_TEXT);
$stmt->bindValue(':destination', $destination, SQLITE3_TEXT);
$insertResult = $stmt->execute();

if ($insertResult) {
    echo "Chapter added successfully!";
} else {
    echo "Error adding chapter: " . $db->lastErrorMsg();
}