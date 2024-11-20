<?php
require_once '../config.php';

$campaign_id = $_POST['campaign_id'];
$description = $_POST['description'];

if ($campaign_id && $description) {
    $stmt = $conn->prepare("INSERT INTO campaign_descriptions (campaign_id, description) VALUES (?, ?)");
    $stmt->bind_param("is", $campaign_id, $description);

    if ($stmt->execute()) {
        header("Location: manage_campaign_content.php?campaign_id=$campaign_id");
        exit;
    } else {
        echo "Database error: " . $stmt->error;
    }
} else {
    echo "Campaign ID and description are required.";
}