<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$content_mdrtn_id = $_POST['content_mdrtn_id'];
$content_type = $_POST['content_type'];
$action = $_POST['action'];

$status = ($action === 'approve') ? 'approved' : 'declined';

// Plural to singular mapping
$content_type_mapping = [
    'programs' => 'program',
    'courses' => 'course',
    'sections' => 'section',
    'learning materials' => 'material',
    'course videos' => 'course_video',
    'post-test questions' => 'post_test',
    'pre-test questions' => 'pre_test',
    'seminars' => 'seminar',
    'campaigns' => 'campaign',
    'descriptions' => 'description',
    'activities' => 'activity',
    'images' => 'image',
    'videos' => 'video',
    'infographics' => 'infographic',
    'materials' => 'campaign_material'
];

// Convert content type to singular using mapping
$content_type = $content_type_mapping[strtolower($content_type)] ?? strtolower($content_type);

// Define the table and ID field based on content type
$content_mappings = [
    'program' => ['table' => 'programs', 'id_field' => 'program_id'],
    'course' => ['table' => 'courses', 'id_field' => 'course_id'],
    'section' => ['table' => 'course_sections', 'id_field' => 'section_id'],
    'material' => ['table' => 'learning_materials', 'id_field' => 'LM_id'],
    'course_video' => ['table' => 'course_videos', 'id_field' => 'course_videos_id'],
    'post_test' => ['table' => 'post_test_questions', 'id_field' => 'post_test_id'],
    'pre_test' => ['table' => 'pre_test_questions', 'id_field' => 'pre_test_id'],
    'seminar' => ['table' => 'seminars', 'id_field' => 'seminar_id'],
    'campaign' => ['table' => 'advocacy_campaigns', 'id_field' => 'campaign_id'],
    'description' => ['table' => 'campaign_descriptions', 'id_field' => 'camp_desc_id'],
    'activity' => ['table' => 'campaign_activities', 'id_field' => 'camp_acts_id'],
    'image' => ['table' => 'campaign_images', 'id_field' => 'camp_img_id'],
    'video' => ['table' => 'campaign_videos', 'id_field' => 'camp_vids_id'],
    'infographic' => ['table' => 'campaign_infographics', 'id_field' => 'camp_infogs_id'],
    'campaign_material' => ['table' => 'campaign_materials', 'id_field' => 'camp_mtrls_id'],
];

if (array_key_exists($content_type, $content_mappings)) {
    $table = $content_mappings[$content_type]['table'];
    $id_field = $content_mappings[$content_type]['id_field'];

    $stmt = $conn->prepare("UPDATE $table SET status = ? WHERE $id_field = ?");
    $stmt->bind_param("si", $status, $content_mdrtn_id);
    $stmt->execute();
    $stmt->close();
    header("Location: content_moderation.php?status=updated");
    exit;
} else {
    die("Invalid content type specified.");
}
?>
