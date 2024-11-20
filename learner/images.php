<?php
include '../config.php';
$campaign_id = $_GET['campaign_id'] ?? null;

if (!$campaign_id) {
    echo "Campaign ID is missing.";
    exit;
}

// Fetch images specific to this campaign
$imagesQuery = "SELECT image_path FROM campaign_images WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$imagesStmt = $conn->prepare($imagesQuery);
$imagesStmt->bind_param("i", $campaign_id);
$imagesStmt->execute();
$imagesResult = $imagesStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Campaign Images</title>
    <link rel="stylesheet" href="../learner/assets/css/MediaPages.css">
</head>

<body>
    <h1>Images</h1>
    <div class="media-grid">
        <?php while ($image = $imagesResult->fetch_assoc()): ?>
            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Campaign Image">
        <?php endwhile; ?>
    </div>
    <?php $conn->close(); ?>
</body>

</html>