<?php
require_once '../config.php';

$campaign_id = $_POST['campaign_id'];
$upload_dir = "../staff/upload/materials/";

if ($campaign_id && isset($_FILES['material']) && $_FILES['material']['error'] == 0) {
    $original_name = $_FILES['material']['name']; // Store the original file name
    $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $file_name = uniqid('material_', true) . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    // Check if directory exists or create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['material']['tmp_name'], $file_path)) {
        // Insert data into database with original name
        $stmt = $conn->prepare("INSERT INTO campaign_materials (campaign_id, material_path, original_name, uploaded_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $campaign_id, $file_path, $original_name);
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
header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=materials");
exit;
