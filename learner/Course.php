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

// Fetch approved program details using the program_id
$program_query = $conn->query("SELECT * FROM programs WHERE program_id = '$program_id' AND status = 'approved'");
$program = $program_query->fetch_assoc();

if (!$program) {
    echo "Program not found or not approved.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($program['program_name']); ?> - Learner Interface</title> <!-- Dynamic Title -->
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/Course.css">
</head>

<body class="bg-light-gray">

    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>

    <!-- Title Section -->
    <div class="title-section">
        <h1><?php echo htmlspecialchars($program['program_name']); ?></h1> <!-- Dynamic Program Name in Title Section -->
    </div>

    <!-- Courses Container -->
    <div class="courses-container">
        <!-- Display courses related to the program -->
        <?php
        // Fetch approved courses associated with the program_id
        $query = $conn->query("SELECT * FROM courses WHERE program_id = '$program_id' AND status = 'approved'");

        // Loop through each course and display it
        if ($query->num_rows > 0) {
            while ($course = $query->fetch_assoc()) {
                ?>
                <div class="course-card">
                    <div class="course-image">
                        <img src="../staff/upload/<?php echo htmlspecialchars($course['course_img']); ?>"
                             alt="<?php echo htmlspecialchars($course['course_name']); ?> Image">
                    </div>
                    <div class="course-description">
                        <div class="course-header">
                            <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
                        </div>
                        <p class="course-text"><?php echo htmlspecialchars($course['course_desc']); ?></p>
                        <div class="view-course">
                            <a href="../learner/CourseContent.php?course_id=<?php echo $course['course_id']; ?>"
                               class="button">View
                                Course</a>
                        </div>
                        <p class="course-date"><?php echo htmlspecialchars($course['course_date']); ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No approved courses available for this program.</p>";
        }
        ?>
    </div>
</body>

</html>