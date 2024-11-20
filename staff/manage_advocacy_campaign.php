<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit;
}

$edit_mode = false;
$campaign_name = '';
$campaign_img = '';
$campaign_id = '';

if (isset($_GET['edit_campaign_id'])) {
    $campaign_id = $_GET['edit_campaign_id'];
    $result = $conn->query("SELECT * FROM advocacy_campaigns WHERE campaign_id = $campaign_id");

    if ($result->num_rows > 0) {
        $campaign = $result->fetch_assoc();
        $campaign_name = $campaign['campaign_name'];
        $campaign_img = $campaign['campaign_img'];
        $edit_mode = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campaign_name = $_POST['campaign_name'];
    $campaign_img_path = $campaign_img;

    if (isset($_FILES['campaign_img']) && $_FILES['campaign_img']['error'] == 0) {
        $upload_dir = "../staff/upload/";
        $file_extension = pathinfo($_FILES['campaign_img']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('campaign_', true) . '.' . $file_extension;
        $campaign_img_path = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['campaign_img']['tmp_name'], $campaign_img_path)) {
            die("Failed to upload image.");
        }
    }

    if (isset($_POST['edit_campaign_id'])) {
        $edit_campaign_id = $_POST['edit_campaign_id'];
        $stmt = $conn->prepare("UPDATE advocacy_campaigns SET campaign_name = ?, campaign_img = ? WHERE campaign_id = ?");
        $stmt->bind_param("ssi", $campaign_name, $campaign_img_path, $edit_campaign_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO advocacy_campaigns (campaign_name, campaign_img) VALUES (?, ?)");
        $stmt->bind_param("ss", $campaign_name, $campaign_img_path);
        $stmt->execute();
    }
    header("Location: manage_advocacy_campaign.php");
    exit;
}

if (isset($_GET['delete_campaign_id'])) {
    $campaign_id = $_GET['delete_campaign_id'];
    $stmt = $conn->prepare("DELETE FROM advocacy_campaigns WHERE campaign_id = ?");
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    header("Location: manage_advocacy_campaign.php");
    exit;
}

$campaigns = $conn->query("SELECT * FROM advocacy_campaigns");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Advocacy Campaigns</title>
    <link rel="stylesheet" href="../staff/assets/common/css/StaffNavBar.css">
    <link rel="stylesheet" href="../staff/assets/css/manage_advocacy_campaigns.css">
</head>

<body>
    <?php include '../staff/assets/common/StaffNavBar.php'; ?>
    <div class="container">
        <h1>Manage Advocacy Campaigns</h1>

        <!-- Form Section -->
        <div class="form-container">
            <form action="manage_advocacy_campaign.php" method="POST" enctype="multipart/form-data">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="edit_campaign_id" value="<?php echo $campaign_id; ?>">
                <?php endif; ?>

                <label for="campaign_name">Campaign Name</label>
                <input type="text" id="campaign_name" name="campaign_name" 
                       value="<?php echo htmlspecialchars($campaign_name); ?>" required>

                <label for="campaign_img">Campaign Image</label>
                <input type="file" id="campaign_img" name="campaign_img" accept="image/*">
                <?php if ($edit_mode && $campaign_img): ?>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars($campaign_img); ?>" alt="Current Campaign Image">
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-submit">
                    <?php echo $edit_mode ? 'Update Campaign' : 'Add Campaign'; ?>
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <h2>Existing Campaigns</h2>
            <table>
                <thead>
                    <tr>
                        <th>Campaign Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($campaign = $campaigns->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($campaign['campaign_name']); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($campaign['campaign_img']); ?>" alt="Campaign Image">
                            </td>
                            <td>
                                <a href="manage_advocacy_campaign.php?edit_campaign_id=<?php echo $campaign['campaign_id']; ?>" class="edit-link">Edit</a>
                                <a href="manage_advocacy_campaign.php?delete_campaign_id=<?php echo $campaign['campaign_id']; ?>" 
                                   class="delete-link" onclick="return confirm('Are you sure you want to delete this campaign?');">Delete</a>
                                <a href="manage_campaign_content.php?campaign_id=<?php echo $campaign['campaign_id']; ?>" class="add-content-link">Add Content</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
