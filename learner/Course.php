<?php
session_start(); // Start session before any output
require_once "../config.php";

// Check if learner is logged in
if (!isset($_SESSION['learner_id'])) {
    header('Location: login.php');
    exit;
}

// Get program_id from URL parameters
$program_id = $_GET['program_id'];
$learner_id = $_SESSION['learner_id'];

// Fetch program details using the program_id
$program_query = $conn->query("SELECT * FROM programs WHERE program_id='$program_id'");
$program = $program_query->fetch_assoc();

// Handle enrollment/unenrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $course_id = $_POST['course_id'];

    if ($_POST['action'] === 'enroll') {
        // Enroll learner in the course
        $conn->query("INSERT INTO enrollments (learner_id, course_id) VALUES ('$learner_id', '$course_id')");
    } elseif ($_POST['action'] === 'unenroll') {
        // Unenroll learner from the course
        $conn->query("DELETE FROM enrollments WHERE learner_id='$learner_id' AND course_id='$course_id'");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $program['program_name']; ?> - Learner Interface</title>
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/Course.css">
</head>

<body class="bg-light-gray">
    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>

    <div class="title-section">
        <h1><?php echo $program['program_name']; ?></h1>
    </div>

    <div class="courses-container">
        <?php
        $query = $conn->query("SELECT * FROM courses WHERE program_id='$program_id'");

        while ($course = $query->fetch_array()) {
            // Check if the learner is enrolled in the course
            $enrollment_query = $conn->query("SELECT * FROM enrollments WHERE learner_id='$learner_id' AND course_id='{$course['course_id']}'");
            $is_enrolled = $enrollment_query->num_rows > 0;
            ?>
            <div class="course-card">
                <div class="course-header">
                    <p class="course-date"><?php echo $course['course_date']; ?></p>
                    <?php if ($is_enrolled): ?>
                        <form method="POST" class="enroll-form">
                            <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                            <button type="submit" name="action" value="unenroll" class="unenroll-button">Unenroll</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" class="enroll-form">
                            <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                            <button type="submit" name="action" value="enroll" class="enroll-button">Enroll</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="course-image">
                    <img src="../staff/upload/<?php echo $course['course_img']; ?>"
                        alt="<?php echo $course['course_name']; ?> Image">
                </div>
                <div class="course-description">
                    <h2><?php echo $course['course_name']; ?></h2>
                    <p class="course-text"><?php echo $course['course_desc']; ?></p>
                    <?php if ($is_enrolled): ?>
                        <div class="view-course">
                            <a href="../learner/CourseContent.php?course_id=<?php echo $course['course_id']; ?>"
                                class="button">View Course</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>