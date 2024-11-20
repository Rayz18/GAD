<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the infographic ID and campaign ID from the POST request
    $camp_infogs_id = $_POST['camp_infogs_id'];
    $campaign_id = $_POST['campaign_id'];

    // Query to get the infographic path
    $infographicQuery = "SELECT infographic_path FROM campaign_infographics WHERE camp_infogs_id = ?";
    $stmt = $conn->prepare($infographicQuery);
    $stmt->bind_param("i", $camp_infogs_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $infographic = $result->fetch_assoc();

    if ($infographic) {
        // Delete the infographic file from the server
        $file_path = $infographic['infographic_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the infographic record from the database
        $deleteQuery = "DELETE FROM campaign_infographics WHERE camp_infogs_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $camp_infogs_id);
        $deleteStmt->execute();
    }

    // Close the prepared statements
    $stmt->close();
    $deleteStmt->close();
}

// Redirect back to the campaign management page
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=infographics");
exit;
?>
