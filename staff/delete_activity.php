<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_acts_id = $_POST['camp_acts_id'];
    $campaign_id = $_POST['campaign_id']; // Get the campaign_id from the form

    // Delete the activity from the database
    $query = "DELETE FROM campaign_activities WHERE camp_acts_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $camp_acts_id);

    if ($stmt->execute()) {
        // Redirect back to manage_campaign_content.php, showing 'activities' section
        header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=activities");
        exit();
    } else {
        echo "Error deleting activity: " . $conn->error;
    }
}
?>
