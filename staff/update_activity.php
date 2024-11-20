<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_acts_id = $_POST['camp_acts_id'];
    $activity = $_POST['activity'];
    $campaign_id = $_POST['campaign_id']; // Ensure campaign_id is retrieved from POST

    $query = "UPDATE campaign_activities SET activity = ? WHERE camp_acts_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $activity, $camp_acts_id);

    if ($stmt->execute()) {
        // Redirect back to manage_campaign_content.php, showing 'activities' section
        header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=activities");
        exit();
    } else {
        echo "Error updating activity.";
    }
}
?>
