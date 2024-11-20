<?php
include '../config.php';
$campaign_id = $_GET['campaign_id'] ?? null;

if (!$campaign_id) {
    echo "Campaign ID is missing.";
    exit;
}

$materialsQuery = "SELECT material_path FROM campaign_materials WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$materialsStmt = $conn->prepare($materialsQuery);
$materialsStmt->bind_param("i", $campaign_id);
$materialsStmt->execute();
$materialsResult = $materialsStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Campaign Materials</title>
    <link rel="stylesheet" href="../learner/assets/css/MediaPages.css">
</head>

<body>
    <h1>Materials</h1>
    <ul>
        <?php while ($material = $materialsResult->fetch_assoc()): ?>
            <li>
                <a href="<?php echo htmlspecialchars($material['material_path']); ?>" target="_blank">
                    <?php echo basename($material['material_path']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
    <?php $conn->close(); ?>
</body>

</html>