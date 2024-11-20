<?php
include '../config.php';
$campaign_id = $_GET['campaign_id'] ?? null;

if (!$campaign_id) {
    echo "Campaign ID is missing.";
    exit;
}

$videosQuery = "SELECT video_path FROM campaign_videos WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$videosStmt = $conn->prepare($videosQuery);
$videosStmt->bind_param("i", $campaign_id);
$videosStmt->execute();
$videosResult = $videosStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Campaign Videos</title>
    <link rel="stylesheet" href="../learner/assets/css/MediaPages.css">
</head>

<body>
    <h1>Videos</h1>
    <div class="media-grid">
        <?php while ($video = $videosResult->fetch_assoc()): ?>
            <video controls>
                <source src="<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        <?php endwhile; ?>
    </div>
    <?php $conn->close(); ?>
</body>

</html>