<?php
session_start();
$username = $_SESSION['username'];
$coursename = $_POST['coursename'];
$db = new SQLite3('../../db/table.db');
if (!$db) {
    echo $db->lastErrorMsg();
    exit();
}

$chapname = $_POST['chapname'];
$linkVideo = $_POST['LinkVideo'];
$description = $_POST['chapDes'];

// Get the contents of the uploaded file
$file_content = file_get_contents($_FILES['fileToUpload']['tmp_name']);

// Insert data into Chapter table
$stmt = $db->prepare("INSERT INTO Chapter (course_id, name, link, description, file_content) VALUES ((SELECT id FROM Course WHERE name = :coursename), :chapname, :linkVideo, :description, :file_content)");
$stmt->bindValue(':coursename', $coursename, SQLITE3_TEXT);
$stmt->bindValue(':chapname', $chapname, SQLITE3_TEXT);
$stmt->bindValue(':linkVideo', $linkVideo, SQLITE3_TEXT);
$stmt->bindValue(':description', $description, SQLITE3_TEXT);
$stmt->bindValue(':file_content', $file_content, SQLITE3_BLOB); // Use SQLITE3_BLOB for binary data
$insertResult = $stmt->execute();

if ($insertResult) {
    echo "Chapter added successfully!";
} else {
    echo "Error adding chapter: " . $db->lastErrorMsg();
}
?>
