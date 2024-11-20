<?php
require_once '../config.php';

$campaign_id = $_POST['campaign_id'];
$upload_dir = "../staff/upload/infographics/";

if ($campaign_id && isset($_FILES['infographic']) && $_FILES['infographic']['error'] == 0) {
    $file_extension = pathinfo($_FILES['infographic']['name'], PATHINFO_EXTENSION);
    $file_name = uniqid('infographic_', true) . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    // Check if directory exists or create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['infographic']['tmp_name'], $file_path)) {
        // Insert data into database with the correct column name
        $stmt = $conn->prepare("INSERT INTO campaign_infographics (campaign_id, infographic_path, uploaded_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $campaign_id, $file_path);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
        exit;
    }
} else {
    echo "Invalid campaign ID or file upload error.";
    exit;
}

// Redirect back to the campaign management page
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=infographics");
exit;
