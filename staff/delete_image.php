<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camp_img_id = $_POST['camp_img_id'];
    $campaign_id = $_POST['campaign_id'];

    $query = "SELECT image_path FROM campaign_images WHERE camp_img_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $camp_img_id);
    $stmt->execute();
    $stmt->bind_result($image_path);
    $stmt->fetch();
    $stmt->close();

    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $query = "DELETE FROM campaign_images WHERE camp_img_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $camp_img_id);

    if ($stmt->execute()) {
        header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=images");
        exit();
    } else {
        echo "Error deleting image: " . $conn->error;
    }
}
?>
