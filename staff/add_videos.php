<?php
include '../config.php';
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit();
}

$course_id = $_GET['course_id'] ?? null;
$video_success_message = '';
$video_error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video_file'])) {
    $file = $_FILES['video_file'];
    $target_dir = "../staff/upload/videos/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $query = "INSERT INTO course_videos (course_id, video_path) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $course_id, $target_file);

        if ($stmt->execute()) {
            $video_success_message = "Video uploaded successfully!";
        } else {
            $video_error_message = "Failed to upload video.";
        }
    } else {
        $video_error_message = "Failed to upload file.";
    }
}

$query = "SELECT * FROM course_videos WHERE course_id = ?";
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
    <title>Upload Videos</title>
    <link rel="stylesheet" href="../staff/assets/css/add_videos.css">
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/common/css/sidebar.css">
    <script src="../staff/assets/common/js/sidebarToggle.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                const successMessage = document.querySelector(".video-success-message");
                const errorMessage = document.querySelector(".video-error-message");
                if (successMessage) successMessage.style.display = "none";
                if (errorMessage) errorMessage.style.display = "none";
            }, 3000);
        });
    </script>
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>

    <div class="sidebar" id="sidebar">
        <button id="toggle-sidebar" class="sidebar-toggle-button">Toggle Sidebar</button>
        <ul class="sidebar-menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Manage Videos</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        <h1 class="video-title">UPLOAD COURSE VIDEOS</h1>

        <?php if ($video_success_message): ?>
            <p class="video-success-message"><?php echo $video_success_message; ?></p>
        <?php endif; ?>
        <?php if ($video_error_message): ?>
            <p class="video-error-message"><?php echo $video_error_message; ?></p>
        <?php endif; ?>

        <div class="video-container">
            <div class="video-form-container">
                <h2 class="video-upload-title">UPLOADING VIDEOS</h2>
                <form method="POST" enctype="multipart/form-data" class="video-form">
                    <input type="file" name="video_file" class="video-file-input" accept="video/*" required>
                    <button type="submit" class="video-upload-button">UPLOAD VIDEO</button>
                </form>
            </div>

            <div class="video-existing-container">
                <h2 class="video-existing-title">EXISTING UPLOADED VIDEOS</h2>
                <div class="video-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="video-card">
                            <video controls class="video-preview">
                                <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <p class="video-name"><?php echo basename($row['video_path']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
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
