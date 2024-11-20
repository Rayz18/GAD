<?php
require_once '../config.php';

$campaign_id = $_POST['campaign_id'];
$upload_dir = "../staff/upload/images/";

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($campaign_id && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $file_name = uniqid('img_', true) . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        $stmt = $conn->prepare("INSERT INTO campaign_images (campaign_id, image_path, uploaded_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $campaign_id, $file_path);

        if ($stmt->execute()) {
            header("Location: manage_campaign_content.php?campaign_id=$campaign_id&section=images");
            exit;
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "Error in file upload: " . $_FILES['image']['error'];
}
?>
