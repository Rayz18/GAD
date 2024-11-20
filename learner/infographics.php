<?php
include '../config.php';
$campaign_id = $_GET['campaign_id'] ?? null;

if (!$campaign_id) {
    echo "Campaign ID is missing.";
    exit;
}

$infographicsQuery = "SELECT infographic_path FROM campaign_infographics WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$infographicsStmt = $conn->prepare($infographicsQuery);
$infographicsStmt->bind_param("i", $campaign_id);
$infographicsStmt->execute();
$infographicsResult = $infographicsStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Campaign Infographics</title>
    <link rel="stylesheet" href="../learner/assets/css/MediaPages.css">
</head>

<body>
    <h1>Infographics</h1>
    <div class="media-grid">
        <?php while ($infographic = $infographicsResult->fetch_assoc()): ?>
            <img src="<?php echo htmlspecialchars($infographic['infographic_path']); ?>" alt="Infographic">
        <?php endwhile; ?>
    </div>
    <?php $conn->close(); ?>
</body>

</html>