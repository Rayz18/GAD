<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_mtrls_id = $_POST['camp_mtrls_id'];
    $campaign_id = $_POST['campaign_id'];

    // Fetch the file path before deleting
    $stmt = $conn->prepare("SELECT material_path FROM campaign_materials WHERE camp_mtrls_id = ?");
    $stmt->bind_param("i", $camp_mtrls_id);
    $stmt->execute();
    $stmt->bind_result($material_path);
    $stmt->fetch();
    $stmt->close();

    if ($material_path && file_exists($material_path)) {
        unlink($material_path); // Delete the file from the server
    }

    // Delete the record from the database
    $stmt = $conn->prepare("DELETE FROM campaign_materials WHERE camp_mtrls_id = ?");
    $stmt->bind_param("i", $camp_mtrls_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the materials section of the campaign content management page
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=materials");
exit;
