<?php
session_start();
include '../config.php'; // Database connection

// Check if learner is logged in
if (!isset($_SESSION['learner_id'])) {
    header('Location: login.php');
    exit;
}

// Get learner ID from session
$learner_id = $_SESSION['learner_id'];

// Get seminar ID from the URL
$seminar_id = $_GET['seminar_id'] ?? null;
if (!$seminar_id) {
    echo "Invalid Seminar ID.";
    exit;
}

try {
    // Start a transaction to ensure data integrity
    $conn->begin_transaction();

    // Check if the learner is already registered for this seminar
    $query = "SELECT * FROM seminar_registrations WHERE learner_id = ? AND seminar_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $learner_id, $seminar_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You are already registered for this seminar.";
    } else {
        // Register the learner for the seminar
        $query = "INSERT INTO seminar_registrations (learner_id, seminar_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $learner_id, $seminar_id);

        if ($stmt->execute()) {
            $conn->commit();
            echo "Successfully registered for the seminar.";
        } else {
            throw new Exception("Failed to register for the seminar.");
        }
    }

} catch (Exception $e) {
    // Roll back the transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Redirect back to the course interface after registration
header("Location: CourseContent.php?course_id={$_GET['course_id']}&status=success");
exit;