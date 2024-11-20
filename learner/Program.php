<?php
session_start();
require_once "../config.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs Page</title>
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/Program.css">
</head>

<body>
    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>
    <!-- Programs Section -->
    <div class="program-container">
        <div class="content">
            <div class="term-search">
                <h1>PROGRAMS</h1>
                <div class="search-container">
                    <input type="text" placeholder="Search" id="search">
                    <button onclick="search()">🔍</button>
                </div>
            </div>

            <!-- Program Images and Titles -->
            <div class="photo-grid"> <!-- Updated to wrap all photo cards -->
                <!-- Program 1 -->
                <?php
                $result = $conn->query("SELECT * FROM programs");
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='photo-card'>";
                    echo "<a href='Course.php?program_id=" . $row['program_id'] . "'>";
                    echo "<img src='../staff/upload/" . $row['program_img'] . "' alt='" . $row['program_name'] . "'></a>";
                    echo "<a class='photo-title'>" . $row['program_name'] . "</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>