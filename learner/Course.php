<?php
session_start(); // Start session before any output
require_once "../config.php";

// Check if learner is logged in
if (!isset($_SESSION['learner_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Get program_id from URL parameters
$program_id = $_GET['program_id'];

// Fetch program details using the program_id
$program_query = $conn->query("SELECT * FROM `programs` WHERE `program_id`='$program_id'");
$program = $program_query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $program['program_name']; ?> - Learner Interface</title> <!-- Dynamic Title -->
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/Course.css">
    <style>
        /* CSS to ensure course description breaks into multiple lines */
        .course-text {
            white-space: pre-wrap;
            /* Preserve spaces and break lines */
            word-wrap: break-word;
            /* Break words if necessary */
            word-break: break-word;
            /* Force break long words */
            overflow-wrap: break-word;
            /* Break words for wide text */
        }
    </style>
</head>

<body class="bg-light-gray">

    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>

    <!-- Title Section -->
    <div class="title-section">
        <h1><?php echo $program['program_name']; ?></h1> <!-- Dynamic Program Name in Title Section -->
    </div>

    <!-- Courses Container -->
    <div class="courses-container">
        <!-- Display courses related to the program -->
        <?php
        // Fetch courses associated with the program_id
        $query = $conn->query("SELECT * FROM `courses` WHERE `program_id`='$program_id'");

        // Loop through each course and display it
        while ($course = $query->fetch_array()) {
            ?>
            <div class="course-card">
                <div class="course-image">
                    <img src="../staff/upload/<?php echo $course['course_img']; ?>"
                        alt="<?php echo $course['course_name']; ?> Image">
                </div>
                <div class="course-description">
                    <div class="course-header">
                        <h2><?php echo $course['course_name']; ?></h2>
                    </div>
                    <p class="course-text"><?php echo $course['course_desc']; ?></p>
                    <div class="view-course">
                        <a href="../learner/CourseContent.php?course_id=<?php echo $course['course_id']; ?>"
                            class="button">View
                            Course</a>
                    </div>
                    <p class="course-date"><?php echo $course['course_date']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>