<?php
// Check if staff is logged in
include '../config.php';
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit();
}

$course_id = $_GET['course_id'] ?? null; // Get course ID
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Course Sections</title>
    <link rel="stylesheet" href="../staff/assets/css/add_course_section.css">
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <h1>Manage Course Sections</h1>

    <div class="section-links">
        <a href="add_introduction.php?course_id=<?php echo $course_id; ?>">Add/Edit Introduction</a>
        <a href="add_pre_test.php?course_id=<?php echo $course_id; ?>">Add/Edit Pre-Test</a>
        <a href="add_learning_materials.php?course_id=<?php echo $course_id; ?>">Add/Edit Learning Materials</a>
        <a href="add_videos.php?course_id=<?php echo $course_id; ?>">Add/Edit Videos</a>
        <a href="add_post_test.php?course_id=<?php echo $course_id; ?>">Add/Edit Post-Test</a>
        <a href="add_seminar.php?course_id=<?php echo $course_id; ?>">Add/Edit Seminar</a>
    </div>
</body>

</html>