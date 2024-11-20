<?php
include '../learner/assets/common/LearnerNavBar.php';
include '../config.php';

$campaign_id = $_GET['id'] ?? null;
if (!$campaign_id) {
    echo "Campaign ID is missing.";
    exit;
}

// Fetch campaign title and banner image
$campaignQuery = "SELECT campaign_name, campaign_img FROM advocacy_campaigns WHERE campaign_id = ?";
$campaignStmt = $conn->prepare($campaignQuery);
$campaignStmt->bind_param("i", $campaign_id);
$campaignStmt->execute();
$campaignResult = $campaignStmt->get_result();
$campaignData = $campaignResult->fetch_assoc();

if (!$campaignData) {
    echo "Campaign not found.";
    exit;
}

$campaignTitle = $campaignData['campaign_name'] ?? 'Campaign';
$campaignBanner = $campaignData['campaign_img'] ?? '../learner/assets/images/default_banner.png'; // Use a default image if not available

// Fetch description
$descriptionQuery = "SELECT description FROM campaign_descriptions WHERE campaign_id = ? ORDER BY created_at DESC LIMIT 1";
$descriptionStmt = $conn->prepare($descriptionQuery);
$descriptionStmt->bind_param("i", $campaign_id);
$descriptionStmt->execute();
$descriptionResult = $descriptionStmt->get_result();
$description = $descriptionResult->fetch_assoc()['description'] ?? 'No description available.';

// Fetch activities in ascending order
$activitiesQuery = "SELECT activity FROM campaign_activities WHERE campaign_id = ? ORDER BY created_at ASC";
$activitiesStmt = $conn->prepare($activitiesQuery);
$activitiesStmt->bind_param("i", $campaign_id);
$activitiesStmt->execute();
$activitiesResult = $activitiesStmt->get_result();

// Fetch images
$imagesQuery = "SELECT image_path FROM campaign_images WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$imagesStmt = $conn->prepare($imagesQuery);
$imagesStmt->bind_param("i", $campaign_id);
$imagesStmt->execute();
$imagesResult = $imagesStmt->get_result();

// Fetch videos
$videosQuery = "SELECT video_path FROM campaign_videos WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$videosStmt = $conn->prepare($videosQuery);
$videosStmt->bind_param("i", $campaign_id);
$videosStmt->execute();
$videosResult = $videosStmt->get_result();

// Fetch infographics
$infographicsQuery = "SELECT infographic_path FROM campaign_infographics WHERE campaign_id = ? ORDER BY uploaded_at DESC";
$infographicsStmt = $conn->prepare($infographicsQuery);
$infographicsStmt->bind_param("i", $campaign_id);
$infographicsStmt->execute();
$infographicsResult = $infographicsStmt->get_result();

// Fetch materials
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
    <title><?php echo htmlspecialchars($campaignTitle); ?> - Details</title>
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/AdvocacyCampaignRedirection.css">
</head>

<body>
    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>
    <div class="banner">
        <img src="<?php echo htmlspecialchars($campaignBanner); ?>" alt="Campaign Banner">
    </div>

    <div class="campaign-details">
        <h1><?php echo htmlspecialchars($campaignTitle); ?></h1>
        <div class="button-grid">
            <a href="images.php?campaign_id=<?php echo $campaign_id; ?>" class="button">
                <img src="../learner/assets/images/images.png" alt="Images">
                <span>IMAGES</span>
            </a>
            <a href="infographics.php?campaign_id=<?php echo $campaign_id; ?>" class="button">
                <img src="../learner/assets/images/infographics.png" alt="Infographics">
                <span>INFOGRAPHICS</span>
            </a>
            <a href="videos.php?campaign_id=<?php echo $campaign_id; ?>" class="button">
                <img src="../learner/assets/images/videos.png" alt="Videos">
                <span>VIDEOS</span>
            </a>
            <a href="materials.php?campaign_id=<?php echo $campaign_id; ?>" class="button">
                <img src="../learner/assets/images/materials.png" alt="Materials">
                <span>MATERIALS</span>
            </a>
        </div>

        <div class="activities">
            <h2>ACTIVITIES UNDER THIS CAMPAIGN:</h2>
            <ul class="activity-list">
                <?php while ($activity = $activitiesResult->fetch_assoc()): ?>
                    <li class="activity-item"><?php echo htmlspecialchars($activity['activity']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="content-description">
            <p><?php echo htmlspecialchars($description); ?></p>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>