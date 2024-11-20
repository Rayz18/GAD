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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/add_pre_test.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <!-- Sidebar -->
    <div class="sidebar collapsed">
        <!-- Sidebar content here -->
    </div>

    <!-- Sidebar Toggle Button -->
    <div id="toggle-sidebar" class="toggle-sidebar"></div>

    <!-- Main Content -->
    <div id="content" class="container-fluid px-4 py-5" style="margin-top: -30px;">
        <h1 style="color: #007bff; font-size: 3rem; font-weight: bold; text-align: center; margin: 0 auto; padding: 20px;">
            PRE-TEST QUESTIONS
        </h1>

        <!-- Success/Error Messages -->
        <div style="position: absolute; top: 105px; left: 50%; transform: translateX(-50%); z-index: 1000; text-align: center;">
            <?php if ($success_message): ?>
                <div id="successMessage" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; display: inline-block;">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div id="errorMessage" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; display: inline-block;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            // Hide the success message after 3 seconds
            setTimeout(() => {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) successMessage.style.display = 'none';

                const errorMessage = document.getElementById('errorMessage');
                if (errorMessage) errorMessage.style.display = 'none';
            }, 3000); // 3 seconds
        </script>

        <div id="content" class="container-fluid px-4 py-5" style="margin-top: -30px;">
            <h1 class="text-center mb-4 fw-bold text-uppercase text-primary"></h1>
            <div class="row g-5">
                <!-- Add Question Form -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center">
                            Add Pre-Test Question
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="question_text" class="form-label fw-bold">Question:</label>
                                    <input type="text" name="question_text" class="form-control" placeholder="Enter the question" required>
                                </div>
                                <div class="mb-3">
                                    <label for="option_a" class="form-label fw-bold">Option A:</label>
                                    <input type="text" name="option_a" class="form-control" placeholder="Enter option A" required>
                                </div>
                                <div class="mb-3">
                                    <label for="option_b" class="form-label fw-bold">Option B:</label>
                                    <input type="text" name="option_b" class="form-control" placeholder="Enter option B" required>
                                </div>
                                <div class="mb-3">
                                    <label for="option_c" class="form-label fw-bold">Option C:</label>
                                    <input type="text" name="option_c" class="form-control" placeholder="Enter option C" required>
                                </div>
                                <div class="mb-3">
                                    <label for="correct_option" class="form-label fw-bold">Correct Option (a/b/c):</label>
                                    <input type="text" name="correct_option" class="form-control" maxlength="1" placeholder="Enter the correct option (a/b/c)" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Add Question</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Questions -->
                <div class="col-lg-6">
                    <div class="card shadow" style="height: 535px;">
                        <div class="card-header bg-success text-white text-center">
                            Existing Pre-Test Questions
                        </div>
                        <div class="card-body" style="height: calc(100% - 58px); overflow-y: auto;">
                            <table class="table table-striped table-bordered">
                                <thead class="table-success">
                                    <tr>
                                        <th style="width: 80%;">Question</th>
                                        <th style="width: 20%;">Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['question_text']); ?></td>
                                            <td class="text-center">
                                                <span style="display: inline-block; background-color: #28a745; color: white; font-weight: bold; padding: 5px 10px; border-radius: 5px; text-transform: uppercase; font-size: 0.9rem; min-width: 30px; text-align: center;">
                                                    <?php echo strtoupper(htmlspecialchars($row['correct_option'])); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');

            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("show");
            });
        });
    </script>
</body>

</html>
