<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $program_name = $_POST['program_name'];
    $program_desc = $_POST['program_desc'];

    // Handle file upload
    $program_img = '';
    if (!empty($_FILES['program_img']['name'])) {
        $target_dir = "../staff/upload/";
        $target_file = $target_dir . basename($_FILES['program_img']['name']);
        if (move_uploaded_file($_FILES['program_img']['tmp_name'], $target_file)) {
            $program_img = $_FILES['program_img']['name'];  // Store the image filename
        }
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO programs (program_name, program_img, program_desc) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $program_name, $program_img, $program_desc);
    $stmt->execute();
    $stmt->close();

    header('Location: staff_dashboard.php');  // Redirect to the staff dashboard after adding a program
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Program</title>
    <link rel="stylesheet" href="../staff/assets/css/add_program.css">
</head>

<body>
    <form action="add_program.php" method="POST" enctype="multipart/form-data">
        <h2>ADD PROGRAM</h2>

        <label for="program_name">Program Name:</label>
        <input type="text" id="program_name" name="program_name" required>

        <label for="program_desc">Program Description:</label>
        <textarea id="program_desc" name="program_desc" required></textarea>

        <label for="program_img">Program Image:</label>
        <input type="file" id="program_img" name="program_img">

        <div class="button-container">
            <input type="submit" value="Add Program">
            <a href="staff_dashboard.php" class="back-button">Back</a>
        </div>
    </form>
</body>

</html>