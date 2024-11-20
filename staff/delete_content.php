<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit;
}

if (isset($_GET['content_id']) && isset($_GET['campaign_id'])) {
    $content_id = $_GET['content_id'];
    $campaign_id = $_GET['campaign_id'];

    $stmt = $conn->prepare("DELETE FROM campaign_content WHERE content_id = ?");
    $stmt->bind_param("i", $content_id);
    $stmt->execute();
}

header("Location: manage_campaign_content.php?campaign_id=" . $campaign_id);
exit;