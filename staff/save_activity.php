<?php
require_once '../config.php';

$campaign_id = $_POST['campaign_id'];
$activity = $_POST['activity'];

// Ensure campaign ID and activity are valid
if ($campaign_id && $activity) {
    $stmt = $conn->prepare("INSERT INTO campaign_activities (campaign_id, activity, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $campaign_id, $activity);
    $stmt->execute();
}

// Redirect back to the campaign management page, showing the activities tab
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=activities");
exit;
?>
