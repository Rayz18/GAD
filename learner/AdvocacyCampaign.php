<?php
require_once '../config.php';

// Fetch all campaigns
$campaigns = $conn->query("SELECT * FROM advocacy_campaigns");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advocacy Campaign</title>
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/AdvocacyCampaign.css">
</head>

<body>
    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>

    <!-- Advocacy Campaign Section -->
    <div class="advocacy-campaign-container">
        <div class="content">
            <div class="title-search">
                <h1>ADVOCACY CAMPAIGN</h1>
                <div class="search-bar">
                    <input type="text" placeholder="Search" id="searchTerm">
                    <button onclick="search()">🔍</button>
                </div>
            </div>

            <!-- Image Gallery Section -->
            <div class="image-gallery">
                <?php
                // Check if campaigns exist
                if ($campaigns->num_rows > 0) {
                    while ($campaign = $campaigns->fetch_assoc()) {
                        ?>
                        <div class="image-card">
                            <a href="AdvocacyCampaignRedirection.php?id=<?php echo $campaign['campaign_id']; ?>">
                                <img src="<?php echo htmlspecialchars($campaign['campaign_img']); ?>"
                                    alt="<?php echo htmlspecialchars($campaign['campaign_name']); ?>">
                            </a>
                            <a class="image-title"><?php echo htmlspecialchars($campaign['campaign_name']); ?></a>
                        </div>
                        <?php
                    }
                } else {
                    // Display message if no campaigns are available
                    echo "<p class='no-campaigns'>No advocacy campaigns available at the moment.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>