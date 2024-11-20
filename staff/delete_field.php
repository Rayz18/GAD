<?php
include '../config.php';
header('Content-Type: application/json');
session_start();

// Retrieve JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if field_id is provided
if (!isset($data['field_id'])) {
    echo json_encode(['success' => false, 'message' => 'Field ID is required.']);
    exit;
}

$field_id = $data['field_id'];

// Prepare the delete statement
$stmt = $conn->prepare("DELETE FROM seminar_fields WHERE field_id = ?");
$stmt->bind_param("i", $field_id);

// Execute and check if deletion was successful
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Field deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting field.']);
}

// Close the statement
$stmt->close();
$conn->close();