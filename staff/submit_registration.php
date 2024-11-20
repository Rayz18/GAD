<?php
// Include config.php to establish the database connection
include '../config.php';

try {
    // Check if form data is submitted via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get seminar_id from POST or GET data
        $seminar_id = $_POST['seminar_id'] ?? $_GET['seminar_id'];

        // Start a MySQLi transaction
        $conn->begin_transaction();

        // Insert into registration_form
        $direction = $_POST['direction'] ?? '';
        $stmt = $conn->prepare("INSERT INTO registration_form (seminar_id, direction) VALUES (?, ?)");
        $stmt->bind_param("is", $seminar_id, $direction);
        $stmt->execute();
        $form_id = $conn->insert_id;  // Get the last inserted form_id

        // Insert fields into form_fields
        $fieldLabel = $_POST['fieldLabel'] ?? '';
        $fieldType = $_POST['fieldType'] ?? 'Text';
        $required = isset($_POST['required']) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO form_fields (form_id, field_label, field_type, required) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $form_id, $fieldLabel, $fieldType, $required);
        $stmt->execute();
        $field_id = $conn->insert_id;  // Get the last inserted field_id

        // Insert choices into field_choices (if field type is Dropdown or Radio)
        if (($fieldType === 'Dropdown' || $fieldType === 'Radio') && !empty($_POST['choices'])) {
            $stmt = $conn->prepare("INSERT INTO field_choices (field_id, choice_text) VALUES (?, ?)");
            foreach ($_POST['choices'] as $choice) {
                $choice_text = htmlspecialchars($choice);
                $stmt->bind_param("is", $field_id, $choice_text);
                $stmt->execute();
            }
        }

        // Commit transaction
        $conn->commit();
        echo "Form data inserted successfully.";
    }
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}