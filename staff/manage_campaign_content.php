<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaign Content</title>
    <link rel="stylesheet" href="../staff/assets/css/manage_campaign_content.css">
</head>

<body>
    <?php $campaign_id = $_GET['campaign_id'] ?? null; ?>

    <!-- Main Container -->
    <div class="main-container">

        <!-- Back Button -->
        <div class="back-button-container">
            <a href="manage_advocacy_campaign.php" class="back-btn">← Back</a>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <button onclick="showSection('description')" class="tab">Description</button>
            <button onclick="showSection('activities')" class="tab">Activities</button>
            <button onclick="showSection('images')" class="tab">Images</button>
            <button onclick="showSection('videos')" class="tab">Videos</button>
            <button onclick="showSection('infographics')" class="tab">Infographics</button>
            <button onclick="showSection('materials')" class="tab">Materials</button>
        </div>

        <!-- Content Container -->
        <div class="content-container">
            <!-- Description Section -->
            <div id="description" class="section">
                <h2>Campaign Description</h2>
                <form method="POST" action="save_description.php">
                    <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
                    <textarea name="description" placeholder="Type description..." required></textarea>
                    <button type="submit" class="submit-btn">Save</button>
                </form>
            </div>

            <!-- Activities Section -->
            <div id="activities" class="section">
                <h2>Campaign Activities</h2>
                <form method="POST" action="save_activity.php">
                    <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
                    <textarea name="activity" placeholder="Enter activity..." required></textarea>
                    <button type="submit" class="submit-btn">Add Activity</button>
                </form>
                <div class="activity-list">
                    <?php
                    include '../config.php';
                    $activityQuery = "SELECT camp_acts_id, activity, created_at FROM campaign_activities WHERE campaign_id = ? ORDER BY created_at ASC";
                    $activityStmt = $conn->prepare($activityQuery);
                    $activityStmt->bind_param("i", $campaign_id);
                    $activityStmt->execute();
                    $activityResult = $activityStmt->get_result();

                    while ($activity = $activityResult->fetch_assoc()) {
                        echo "<div class='activity-item'>";
                        echo "<p>" . htmlspecialchars($activity['activity']) . "</p>";
                        echo "<small>Added on " . htmlspecialchars($activity['created_at']) . "</small>";
                        echo "<div class='activity-actions'>";
                        echo "<form method='POST' action='edit_activity.php' style='display: inline;'>
                                <input type='hidden' name='camp_acts_id' value='" . $activity['camp_acts_id'] . "'>
                                <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                                <button type='submit' class='edit-btn'>Edit</button>
                              </form>";
                        echo "<form method='POST' action='delete_activity.php' style='display: inline;'>
                                <input type='hidden' name='camp_acts_id' value='" . $activity['camp_acts_id'] . "'>
                                <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                                <button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this activity?\");'>Delete</button>
                              </form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Images Section -->
            <div id="images" class="section">
                <h2>Campaign Images</h2>
                <form method="POST" action="upload_image.php" enctype="multipart/form-data">
                    <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
                    <input type="file" name="image" accept="image/*" required>
                    <button type="submit" class="submit-btn">Upload Image</button>
                </form>
                <div class="image-list">
                    <?php
                    $imageQuery = "SELECT camp_img_id, image_path, uploaded_at FROM campaign_images WHERE campaign_id = ? ORDER BY uploaded_at DESC";
                    $imageStmt = $conn->prepare($imageQuery);
                    $imageStmt->bind_param("i", $campaign_id);
                    $imageStmt->execute();
                    $imageResult = $imageStmt->get_result();

                    while ($image = $imageResult->fetch_assoc()) {
                        echo "<div class='image-item'>";
                        echo "<img src='" . htmlspecialchars($image['image_path']) . "' alt='Uploaded Image' class='uploaded-image'>";
                        echo "<small>Uploaded on " . htmlspecialchars($image['uploaded_at']) . "</small>";
                        echo "<div class='image-actions'>";
                        echo "<form method='POST' action='delete_image.php' style='display: inline;'>
                                <input type='hidden' name='camp_img_id' value='" . $image['camp_img_id'] . "'>
                                <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                                <button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this image?\");'>Delete</button>
                              </form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Videos Section -->
<div id="videos" class="section">
    <h2>Campaign Videos</h2>
    <form method="POST" action="upload_video.php" enctype="multipart/form-data">
        <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
        <input type="file" name="video" accept="video/*" required>
        <button type="submit" class="submit-btn">Upload Video</button>
    </form>

    <!-- Video List -->
    <div class="video-list">
        <?php
        $videoQuery = "SELECT camp_vids_id, video_path, uploaded_at FROM campaign_videos WHERE campaign_id = ? ORDER BY uploaded_at DESC";
        $videoStmt = $conn->prepare($videoQuery);
        $videoStmt->bind_param("i", $campaign_id);
        $videoStmt->execute();
        $videoResult = $videoStmt->get_result();

        while ($video = $videoResult->fetch_assoc()) {
            echo "<div class='video-item'>";
            echo "<video controls class='uploaded-video'>";
            echo "<source src='" . htmlspecialchars($video['video_path']) . "' type='video/mp4'>";
            echo "Your browser does not support the video tag.";
            echo "</video>";
            echo "<small>Uploaded on " . htmlspecialchars($video['uploaded_at']) . "</small>";
            echo "<div class='video-actions'>";
            echo "<form method='POST' action='delete_video.php' style='display: inline;'>
                    <input type='hidden' name='camp_vids_id' value='" . $video['camp_vids_id'] . "'>
                    <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                    <button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this video?\");'>Delete</button>
                  </form>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>


            <div class="content-container">
            <!-- Infographics Section -->
            <div id="infographics" class="section">
                <h2>Campaign Infographics</h2>
                <form method="POST" action="upload_infographic.php" enctype="multipart/form-data">
                    <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
                    <input type="file" name="infographic" accept="image/*" required>
                    <button type="submit" class="submit-btn">Upload Infographic</button>
                </form>

                <!-- Infographic List -->
                <div class="infographic-list">
                    <?php
                    $infographicQuery = "SELECT camp_infogs_id, infographic_path, uploaded_at FROM campaign_infographics WHERE campaign_id = ? ORDER BY uploaded_at DESC";
                    $infographicStmt = $conn->prepare($infographicQuery);
                    $infographicStmt->bind_param("i", $campaign_id);
                    $infographicStmt->execute();
                    $infographicResult = $infographicStmt->get_result();

                    while ($infographic = $infographicResult->fetch_assoc()) {
                        echo "<div class='infographic-item'>";
                        echo "<img src='" . htmlspecialchars($infographic['infographic_path']) . "' alt='Uploaded Infographic' class='uploaded-infographic'>";
                        echo "<small>Uploaded on " . htmlspecialchars($infographic['uploaded_at']) . "</small>";
                        echo "<div class='infographic-actions'>";
                        echo "<form method='POST' action='delete_infographic.php' style='display: inline;'>
                                <input type='hidden' name='camp_infogs_id' value='" . $infographic['camp_infogs_id'] . "'>
                                <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                                <button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this infographic?\");'>Delete</button>
                            </form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

<!-- Materials Section -->
<div id="materials" class="section">
    <h2>Campaign Materials</h2>
    <form method="POST" action="upload_materials.php" enctype="multipart/form-data">
        <input type="hidden" name="campaign_id" value="<?php echo htmlspecialchars($campaign_id); ?>">
        <input type="file" name="material" accept=".pdf,.doc,.docx" required>
        <button type="submit" class="submit-btn">Upload Material</button>
    </form>

    <!-- Material List -->
    <div class="material-list">
        <?php
        include '../config.php';
        $materialQuery = "SELECT camp_mtrls_id, original_name, material_path, uploaded_at FROM campaign_materials WHERE campaign_id = ? ORDER BY uploaded_at DESC";
        $materialStmt = $conn->prepare($materialQuery);
        $materialStmt->bind_param("i", $campaign_id);
        $materialStmt->execute();
        $materialResult = $materialStmt->get_result();

        while ($material = $materialResult->fetch_assoc()) {
            echo "<div class='material-item'>";
            // Display the original name with a shortened version if too long
            $displayName = strlen($material['original_name']) > 15 ? substr($material['original_name'], 0, 12) . '...' : $material['original_name'];
            echo "<a href='" . htmlspecialchars($material['material_path']) . "' target='_blank' title='" . htmlspecialchars($material['original_name']) . "'>" . htmlspecialchars($displayName) . "</a>";
            echo "<small>Uploaded on " . htmlspecialchars($material['uploaded_at']) . "</small>";
            echo "<form method='POST' action='delete_material.php' style='display: inline;'>
                    <input type='hidden' name='camp_mtrls_id' value='" . $material['camp_mtrls_id'] . "'>
                    <input type='hidden' name='campaign_id' value='" . htmlspecialchars($campaign_id) . "'>
                    <button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this material?\");'>Delete</button>
                  </form>";
            echo "</div>";
        }
        ?>
    </div>
</div>
            
        </div>
    </div>

    <script>
        function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');

    // Show the clicked section
    document.getElementById(sectionId).style.display = 'block';

    // Remove the active class from all tabs
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Add the active class to the clicked tab
    document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add('active');
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section') || 'description';
    showSection(section);
});

    </script>
</body>

</html>