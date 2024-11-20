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
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['learning_file'])) {
    $file = $_FILES['learning_file'];
    $target_dir = "../staff/upload/add_learning_materials/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }


    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $query = "INSERT INTO learning_materials (course_id, file_path) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $course_id, $target_file);

        if ($stmt->execute()) {
            $success_message = "Learning material uploaded successfully!";
        } else {
            $error_message = "Failed to upload learning material.";
        }
    } else {
        $error_message = "Failed to upload file.";
    }
}

$query = "SELECT * FROM learning_materials WHERE course_id = ?";
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
    <title>Upload Learning Materials</title>
    <link rel="stylesheet" href="../staff/assets/css/add_learning_materials.css">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/common/css/sidebar.css"> <!-- Include sidebar CSS -->
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
    <script>
        // Hide the notification after 3 seconds
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                const successMessage = document.querySelector(".learning-materials-success-message");
                const errorMessage = document.querySelector(".learning-materials-error-message");
                if (successMessage) successMessage.style.display = "none";
                if (errorMessage) errorMessage.style.display = "none";
            }, 3000);
        });
    </script>
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <div class="sidebar" id="sidebar">
        <!-- Sidebar content -->
        <button id="toggle-sidebar">Toggle Sidebar</button>
        <!-- Add your sidebar links here -->
    </div>

    <div class="content" id="content">
        <h1 class="learning-materials-title">UPLOAD LEARNING MATERIALS</h1>

        <?php if ($success_message): ?>
            <p class="learning-materials-success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="learning-materials-error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <div class="learning-materials-container">
            <div class="learning-materials-form-container">
                <h2 class="learning-materials-upload-title">UPLOADING MATERIALS</h2>
                <form method="POST" enctype="multipart/form-data" class="learning-materials-form">
                    <input type="file" name="learning_file" class="learning-materials-file-input" required>
                    <button type="submit" class="learning-materials-upload-button">UPLOAD MATERIAL</button>
                </form>
            </div>

            <div class="learning-materials-existing-container">
                <h2 class="learning-materials-existing-title">EXISTING LEARNING MATERIALS</h2>
                <ul class="learning-materials-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="learning-materials-item">
                            <a href="<?php echo $row['file_path']; ?>" target="_blank"
                                class="learning-materials-link"><?php echo basename($row['file_path']); ?></a>
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