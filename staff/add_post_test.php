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
    $question_text = $_POST['post_question_text'];
    $option_a = $_POST['post_option_a'];
    $option_b = $_POST['post_option_b'];
    $option_c = $_POST['post_option_c'];
    $correct_option = $_POST['post_correct_option'];

    $query = "INSERT INTO post_test_questions (course_id, question_text, option_a, option_b, option_c, correct_option) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssss", $course_id, $question_text, $option_a, $option_b, $option_c, $correct_option);

    if ($stmt->execute()) {
        $success_message = "Post-Test question added successfully!";
    } else {
        $error_message = "Failed to add Post-Test question.";
    }
}

// Fetch existing questions
$query = "SELECT * FROM post_test_questions WHERE course_id = ?";
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
    <title>Post-Test Questions</title>
    <link rel="stylesheet" href="../staff/assets/css/add_post_test.css">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const successMessage = document.querySelector(".post-message.success");
            const errorMessage = document.querySelector(".post-message.error");

            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 3000);
            }

            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = "none";
                }, 3000);
            }
        });
    </script>
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <div class="sidebar" id="sidebar">
        <button id="toggle-sidebar">Toggle Sidebar</button>
    </div>

    <div class="content" id="content">
        <h1 class="post-page-title">POST-TEST QUESTIONS</h1>

        <?php if ($success_message): ?>
            <p class="post-message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="post-message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="post-question-container">
            <div class="post-question-form">
                <h2 class="post-section-title">ADD POST-TEST QUESTION</h2>
                <form method="POST">
                    <label for="post_question_text">Question:</label>
                    <input type="text" name="post_question_text" class="post-input-field" required>

                    <label for="post_option_a">Option A:</label>
                    <input type="text" name="post_option_a" class="post-input-field" required>

                    <label for="post_option_b">Option B:</label>
                    <input type="text" name="post_option_b" class="post-input-field" required>

                    <label for="post_option_c">Option C:</label>
                    <input type="text" name="post_option_c" class="post-input-field" required>

                    <label for="post_correct_option">Correct Option (a/b/c):</label>
                    <input type="text" name="post_correct_option" class="post-input-field" maxlength="1" required>

                    <div class="post-button-container">
                        <button type="submit" class="post-submit-button">Add Question</button>
                    </div>
                </form>
            </div>

            <div class="post-existing-questions">
                <h2 class="post-section-title">EXISTING POST-TEST QUESTIONS</h2>
                <ul class="post-question-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="post-question-item">
                            <span class="post-question-text"><?php echo htmlspecialchars($row['question_text']); ?></span>
                            <span class="post-correct-answer">Correct Answer: <?php echo strtoupper(htmlspecialchars($row['correct_option'])); ?></span>
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
