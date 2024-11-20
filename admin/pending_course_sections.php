<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$sections_query = $conn->query("SELECT * FROM course_sections WHERE status = 'pending'");

if (!$sections_query) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pending Course Sections</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../admin/assets/common/AdminNavBar.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Pending Course Sections</h1>
        <div class="list-group mt-4">
            <?php while ($section = $sections_query->fetch_assoc()): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <strong><?php echo htmlspecialchars($section['section_name']); ?></strong>
                    <div>
                        <form method="POST" action="moderate_content_action.php" class="d-inline">
                            <input type="hidden" name="content_mdrtn_id" value="<?php echo $section['section_id']; ?>">
                            <input type="hidden" name="content_type" value="section">
                            <button type="submit" name="action" value="approve"
                                class="btn btn-success btn-sm">Approve</button>
                            <button type="submit" name="action" value="decline"
                                class="btn btn-danger btn-sm">Decline</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>