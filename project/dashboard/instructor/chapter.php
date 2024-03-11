<?php
session_start();
$username = $_SESSION['username'];
$coursename = $_GET['course'];
$db = new SQLite3('../../db/table.db');
if (!$db) {
    echo $db->lastErrorMsg();
    exit();
}
include("../../class/instructor.php");
$password = $_SESSION['password'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$contact = $_SESSION['contact'] ; 

$current_user = new Instructor($username, $email, $password, $role, $contact);

$sql = "SELECT Chapter.* FROM Chapter JOIN Course ON Chapter.course_id = Course.id WHERE Course.name = '$coursename' ORDER BY Chapter.ChapterNo";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ผู้สอน</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- font awesome cdn link  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    />
    <!-- <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
      rel="stylesheet"
    /> -->

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../../css/styles.css" />
  </head>
  <body>
    <!-- Header Start -->
    <header class="header">
      <section class="flex">
        <a href="dashboard.php" class="logo"
          ><i class="fa-solid fa-book-open"></i> EdVenture</a
        >

        <div class="icons">
          <div id="menu-btn" class="fas fa-bars" onclick="MenuClick()"></div>
          <div id="user-btn" class="fas fa-user" onclick="ProfileClick()"></div>
        </div>

        <div class="profile">
          <h3 class="name"><?php echo $username; ?></h3>
          <p class="role">ผู้สอน</p>
          <div class="flex-btn">
          <a href="signoutHandle.php" class="option-btn">ออกจากระบบ</a>
          </div>
        </div>
      </section>
    </header>
    <!-- Header End -->

    <!-- Sidebar Start -->
    <div class="side-bar">
      <div class="profile">
        <img src="../../images/user.png" class="image" alt="" />
        <a href="profile.html"><h3 class="name"><?php echo $current_user->getUsername();?></h3></a>
        <p class="role">ผู้สอน</p>
      </div>

      <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i><span>หน้าหลัก</span></a>
        <a href="t_courses.html"
          ><i class="fas fa-graduation-cap"></i><span>คอร์สของฉัน</span></a
        >
        <a href="t_video.html"><i class="fa-solid fa-film"></i><span>Video</span></a>
        <a href="t_question.html"
          ><i class="fa-solid fa-question"></i><span>Q&A</span></a
        >
      </nav>
    </div>
    <!-- Sidebar End -->

  <!-- Section Course Start -->
  <section class="courses">
      <div class="btnbox">
        <h1 class="heading"><?php echo $coursename;?></h1>
        <!-- <a href="t_EditChapter.html" class="inline-btn">แก้ไขบทเรียน</a> -->
        <a href="#popup1" class="inline-btn">เพิ่มบทเรียน</a>
      </div>
      <br />
      <br />
      <br />

      <div class="box-container">
        <div class="box">
          <a href="video.php"><h3 class="title">- บทเรียนที่ 1</h3></a>
          <a class="close" href="">&times;</a>
          <a href="#popup2" class="edit-btn">แก้ไข</a>
        </div>

        <div class="box">
          <a href="t_video.html"><h3 class="title">- บทเรียนที่ 2</h3></a>
          <a class="close" href="">&times;</a>
          <a href="#popup2" class="edit-btn">แก้ไข</a>
        </div>

        <div class="box">
          <a href="t_video.html"><h3 class="title">- บทเรียนที่ 3</h3></a>
          <a class="close" href="">&times;</a>
          <a href="#popup2" class="edit-btn">แก้ไข</a>
        </div>
      </div>



    <!--  pop up 1 -->
      <div id="popup1" class="overlay">
        <div class="popup">
          <h3>เพิ่มบทเรียน</h3>
          <a class="close" href="">&times;</a>
          <div class="content">
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <p>ชื่อบทเรียน</p>
                    <input type="text" name="Chapname" placeholder="" class="box" />
            
                    <p>ลิงก์วิดีโอ</p>
                    <input type="text" name="LinkVideo" placeholder="" class="box" />
                    <p>คำบรรยาย</p>
                    <textarea name="" class="box" cols="5" rows="5"></textarea>
            
                    <p>ไฟล์</p>
                    <input type="file" accept="image/*" class="box" />
                    <a href="t_courses.html" class="inline-btn">ย้อนกลับ</a>
                    <input
                      type="submit"
                      value="เพิ่มบทเรียน"
                      name="submit"
                      class="ans-btn"
                    />
                  </form>
            </div>
          </div>
        </div>
      </div>
    <!--  pop up 2-->
      <div id="popup2" class="overlay">
        <div class="popup">
          <h3>แก้ไขบทเรียน</h3>
          <a class="close" href="">&times;</a>
          <div class="content">
            <div class="form-container">
              <form action="" method="post" enctype="multipart/form-data">
                <p>ชื่อบทเรียน</p>
                <input
                  type="text"
                  name="Chapname"
                  placeholder="old chapter name"
                  class="box"
                />
        
                <p>ลิงก์วิดีโอ</p>
                <input
                  type="text"
                  name="LinkVideo"
                  placeholder="old Link Video"
                  class="box"
                />
                <p>คำบรรยาย</p>
                <textarea
                  name=""
                  class="box"
                  placeholder="old description"
                  cols="5"
                  rows="5"
                ></textarea>
        
                <p>File</p>
                <input type="file" accept="image/*" class="box" />
                <a href="t_courses.html" class="inline-btn">ย้อนกลับ</a>
                <input
                  type="submit"
                  value="แก้ไขบทเรียน"
                  name="submit"
                  class="ans-btn"
                />
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section Course End -->


    <!-- custom js file link  -->
    <script src="../../js/scripts.js"></script>
  </body>
</html>
