<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['camp_acts_id'])) {
    // Get the activity ID from POST request
    $camp_acts_id = $_POST['camp_acts_id'];

    // Fetch the existing activity data
    $query = "SELECT activity, campaign_id FROM campaign_activities WHERE camp_acts_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $camp_acts_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $activity = $result->fetch_assoc();

    if (!$activity) {
        echo "Activity not found.";
        exit;
    }

    $campaign_id = $activity['campaign_id']; // Retrieve campaign_id from database
} else {
    echo "No activity ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity</title>
    <link rel="stylesheet" href="../staff/assets/css/manage_campaign_content.css">
</head>
<body>
    <div class="main-container">
        <h2>Edit Activity</h2>
        <form method="POST" action="update_activity.php">
            <input type="hidden" name="camp_acts_id" value="<?php echo htmlspecialchars($camp_acts_id); ?>">
            <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
            <textarea name="activity" required><?php echo htmlspecialchars($activity['activity']); ?></textarea>
            <button type="submit" class="submit-btn">Update Activity</button>
        </form>
    </div>
</body>
</html>
