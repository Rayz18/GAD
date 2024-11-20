<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_vids_id = $_POST['camp_vids_id'];
    $campaign_id = $_POST['campaign_id'];

    // Get the video path
    $videoQuery = "SELECT video_path FROM campaign_videos WHERE camp_vids_id = ?";
    $stmt = $conn->prepare($videoQuery);
    $stmt->bind_param("i", $camp_vids_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $video = $result->fetch_assoc();

    if ($video) {
        // Delete video file from server
        $file_path = $video['video_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete video record from database
        $deleteQuery = "DELETE FROM campaign_videos WHERE camp_vids_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $camp_vids_id);
        $deleteStmt->execute();
    }
}

// Redirect back to the campaign management page
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=videos");
exit;
?>
