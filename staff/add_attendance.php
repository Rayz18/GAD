<?php
session_start();
require_once '../config.php';

// Get the seminar_id or course_id from the query string
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form submission (e.g., save to the database)
    // Add your PHP logic here for handling form data
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="attendance_form.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

    <!-- Back Button -->
    <a href="javascript:history.back()" class="btn btn-outline-secondary back-button">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>

    <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 500px;">
        <h2 class="text-center h4 mb-4">Attendance Form</h2>

        <form class="space-y-4">
            <!-- Direction Textarea -->
            <div class="mb-3">
                <label class="form-label field-label">Direction:</label>
                <textarea class="form-control" rows="3" placeholder="Add direction . . ."></textarea>
            </div>

            <!-- Field Label Input -->
            <div class="mb-3">
                <label class="form-label field-label">Field Label:</label>
                <input type="text" id="fieldLabel" class="form-control" placeholder="Enter the question or label">
            </div>

            <!-- Field Type Dropdown -->
            <div class="mb-3">
                <label class="form-label field-label">Field Type:</label>
                <select id="fieldType" class="form-select" onchange="toggleChoicesSection()">
                    <option value="Textarea">Textarea</option>
                    <option value="Number">Number</option>
                    <option value="Dropdown">Dropdown</option>
                    <option value="Checkbox">Checkbox</option>
                    <option value="Radio">Radio</option>
                    <option value="Text">Text</option>
                </select>
            </div>

            <!-- Required Checkbox -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="requiredCheckbox">
                <label class="form-check-label field-label" for="requiredCheckbox">Required</label>
            </div>

            <!-- Choices Section (hidden by default) -->
            <div id="choicesSection" class="mb-3 d-none">
                <label class="form-label field-label">Choices:</label>
                <div id="choicesContainer" class="mb-2">
                    <div class="d-flex align-items-center mb-2">
                        <input type="text" class="form-control me-2" placeholder="Option 1">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeChoice(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- Add Another Choice Button -->
                <button type="button" onclick="addChoice()" class="btn btn-danger btn-sm">
                    Add another choice
                </button>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100">UPDATE ATTENDANCE FORM</button>
            </div>
        </form>
    </div>

    <script>
        function toggleChoicesSection() {
            const fieldType = document.getElementById('fieldType').value;
            const choicesSection = document.getElementById('choicesSection');

            if (fieldType === 'Dropdown' || fieldType === 'Radio') {
                choicesSection.classList.remove('d-none');
            } else {
                choicesSection.classList.add('d-none');
            }
        }

        function addChoice() {
            const choicesContainer = document.getElementById('choicesContainer');
            const choiceDiv = document.createElement('div');
            choiceDiv.className = 'd-flex align-items-center mb-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control me-2';
            input.placeholder = Option ${choicesContainer.children.length + 1};

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-outline-danger btn-sm';
            removeButton.innerHTML = '<i class="fas fa-times"></i>';
            removeButton.onclick = () => choiceDiv.remove();

            choiceDiv.appendChild(input);
            choiceDiv.appendChild(removeButton);
            choicesContainer.appendChild(choiceDiv);
        }

        function removeChoice(element) {
            element.parentElement.remove();
        }
    </script>

</body>