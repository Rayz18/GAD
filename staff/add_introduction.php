<?php
include '../config.php';
session_start();

// Check if staff is logged in
if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit();  
}

$course_id = $_GET['course_id'] ?? null;
$referrer = $_GET['ref'] ?? 'manage_programs.php'; // Default to manage_programs.php if ref is not set

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $section_content = $_POST['section_content'];

    // Check if introduction already exists
    $query = "SELECT course_id FROM course_sections WHERE course_id = ? AND section_name = 'Introduction'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update introduction
        $update_query = "UPDATE course_sections SET section_content = ? WHERE course_id = ? AND section_name = 'Introduction'";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $section_content, $course_id);
    } else {
        // Insert new introduction
        $insert_query = "INSERT INTO course_sections (course_id, section_name, section_content) VALUES (?, 'Introduction', ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("is", $course_id, $section_content);
    }

    if ($stmt->execute()) {
        $success_message = "Introduction updated successfully!";
    } else {
        $error_message = "Failed to update the introduction.";
    }
} elseif (isset($_POST['back'])) {
    // Redirect to the referrer page
    header("Location: $referrer");
    exit();
}

// Fetch the current introduction content
$intro_query = "SELECT section_content FROM course_sections WHERE course_id = ? AND section_name = 'Introduction'";
$stmt = $conn->prepare($intro_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$current_intro = $result->fetch_assoc()['section_content'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Introduction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../staff/assets/css/add_course_section.css?v=1.0">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/common/css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
</head>

<body class="bg-light">
    <div class="sidebar">
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>
</div>

<div class="content">
    <div class="col-lg-9 col-md-8 position-relative">
        <h1>EDIT COURSE INTRODUCTION</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white shadow-sm rounded p-4">
            <div class="mb-3">
                <textarea name="section_content" id="section_content" class="form-control border-3 shadow-none" rows="12"><?php echo htmlspecialchars($current_intro); ?></textarea>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" name="save" class="btn btn-primary">Save Introduction</button>
                <button type="submit" name="back" class="btn btn-secondary">Back</button>
            </div>
            <input type="hidden" name="referrer" value="<?php echo htmlspecialchars($referrer); ?>">
        </form>
    </div>
</div>

    </div>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    // Select the toggle button and relevant elements
    const toggleButton = document.querySelector("#toggle-sidebar");
    const sidebar = document.querySelector(".sidebar");
    const content = document.querySelector(".content");

    // Add click event listener to the toggle button
    toggleButton.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed"); // Add/remove 'collapsed' class
        content.classList.toggle("content-collapsed"); // Adjust content layout
    });
});

        setTimeout(function() {
            const successMessage = document.querySelector(".alert-success");
            const errorMessage = document.querySelector(".alert-danger");

            if (successMessage) {
                successMessage.style.opacity = "0"; // Start fade-out
                setTimeout(() => successMessage.style.display = "none", 300); // Hide after fade-out
            }
            if (errorMessage) {
                errorMessage.style.opacity = "0"; // Start fade-out
                setTimeout(() => errorMessage.style.display = "none", 300); // Hide after fade-out
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
</body>
</html>

