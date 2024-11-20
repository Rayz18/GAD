<?php
include '../config.php';
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit();
}

$course_id = $_GET['course_id'] ?? null;
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $correct_option = $_POST['correct_option'];

    $query = "INSERT INTO pre_test_questions (course_id, question_text, option_a, option_b, option_c, correct_option) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssss", $course_id, $question_text, $option_a, $option_b, $option_c, $correct_option);

    if ($stmt->execute()) {
        $success_message = "Pre-Test question added successfully!";
    } else {
        $error_message = "Failed to add Pre-Test question.";
    }
}

// Fetch existing questions
$query = "SELECT * FROM pre_test_questions WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Test Questions</title>
    <link rel="stylesheet" href="../staff/assets/css/add_pre_test.css">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
    <script>
        // JavaScript to hide the success message after 3 seconds
        document.addEventListener("DOMContentLoaded", function() {
            const successMessage = document.querySelector(".message.success");
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 3000);
            }
        });
    </script>
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <div class="sidebar" id="sidebar">
        <button id="toggle-sidebar">Toggle Sidebar</button>
        <!-- Add your sidebar links here -->
    </div>

    <div class="content" id="content">
        <h1 class="page-title">PRE-TEST QUESTIONS</h1>

        <?php if ($success_message): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="question-container">
            <div class="question-form">
                <h2 class="section-title">ADD PRE-TEST QUESTION</h2>
                <form method="POST">
                    <label for="question_text">Question:</label>
                    <input type="text" name="question_text" class="input-field" required>

                    <label for="option_a">Option A:</label>
                    <input type="text" name="option_a" class="input-field" required>

                    <label for="option_b">Option B:</label>
                    <input type="text" name="option_b" class="input-field" required>

                    <label for="option_c">Option C:</label>
                    <input type="text" name="option_c" class="input-field" required>

                    <label for="correct_option">Correct Option (a/b/c):</label>
                    <input type="text" name="correct_option" class="input-field" maxlength="1" required>

                    <div class="button-container">
                        <button type="submit" class="submit-button">Add Question</button>
                    </div>
                </form>
            </div>

            <div class="existing-questions">
                <h2 class="section-title">EXISTING PRE-TEST QUESTIONS</h2>
                <ul class="question-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="question-item">
                            <span class="question-text"><?php echo htmlspecialchars($row['question_text']); ?></span>
                            <span class="correct-answer">Correct Answer: <?php echo strtoupper(htmlspecialchars($row['correct_option'])); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById("toggle-sidebar");
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");

            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("collapsed");
                content.classList.toggle("collapsed");
            });
        });
    </script>
</body>

</html>
