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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['learning_file'])) {
    $file = $_FILES['learning_file'];
    $target_dir = "../add_learning_materials/";

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

// Fetch existing learning materials
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
    <title>Learning Materials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/add_learning_materials.css">
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
            LEARNING MATERIALS
        </h1>

        <!-- Success/Error Messages -->
        <div style="position: absolute; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1000; text-align: center;">
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

        <div class="container-fluid px-4 py-5" style="margin-top: -10px;">
            <div class="row g-5 align-items-stretch">
                <!-- Upload Learning Material Form -->
                <div class="col-lg-6">
                    <div class="card shadow"> <!-- Fixed height for alignment -->
                        <div class="card-header bg-primary text-white text-center">
                            Upload Learning Material
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="learning_file" class="form-label fw-bold">File:</label>
                                    <input type="file" name="learning_file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Upload Material</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Learning Materials -->
<div class="col-lg-6">
    <div class="card shadow" style="height: 536px;"> <!-- Fixed height for alignment -->
        <div class="card-header bg-success text-white text-center">
            Existing Learning Materials
        </div>
        <div class="card-body" style="height: calc(100% - 58px); overflow-y: auto;">
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th style="width: 80%;">File Name</th>
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <!-- Display the file name as blue text -->
                                <span style="color: #007bff;">
                                    <?php echo basename($row['file_path']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-sm btn-success">View</a>
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
            const toggleButton = document.getElementById("toggle-sidebar");
            const sidebar = document.getElementById("sidebar");

            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("show");
            });
        });
    </script>
</body>

</html>
