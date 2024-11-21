<?php
session_start();
include '../config.php';

// Check if learner is logged in
if (!isset($_SESSION['learner_id'])) {
    header('Location: login.php');
    exit;
}

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    echo "Invalid Course ID.";
    exit;
}

// Fetch Course Details
$query = "SELECT * FROM courses WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();
if (!$course) {
    echo "Course not found.";
    exit;
}

// Fetch Introduction Content
$query = "SELECT * FROM course_sections WHERE course_id = ? AND section_name = 'Introduction'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_section = $stmt->get_result()->fetch_assoc();

// Fetch Pre-Test Questions
$query = "SELECT * FROM pre_test_questions WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$pre_test_questions = $stmt->get_result();

// Fetch Learning Materials
$query = "SELECT * FROM learning_materials WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$learning_materials = $stmt->get_result();

// Fetch Videos
$query = "SELECT * FROM course_videos WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$videos = $stmt->get_result();

// Fetch Post-Test Questions
$query = "SELECT * FROM post_test_questions WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$post_test_questions = $stmt->get_result();

// Fetch Seminar Details
$query = "SELECT * FROM seminars WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$seminar = $stmt->get_result();

// Convert result sets to arrays
$pre_test_questions_array = [];
while ($row = $pre_test_questions->fetch_assoc()) {
    $pre_test_questions_array[] = $row;
}

$learning_materials_array = [];
while ($material = $learning_materials->fetch_assoc()) {
    $learning_materials_array[] = $material;
}

$videos_array = [];
while ($video = $videos->fetch_assoc()) {
    $videos_array[] = $video;
}

$post_test_questions_array = [];
while ($row = $post_test_questions->fetch_assoc()) {
    $post_test_questions_array[] = $row;
}

$seminar_array = [];
while ($row = $seminar->fetch_assoc()) {
    $seminar_array[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['course_name']); ?> - Course Interface</title>
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/CourseContent.css">
</head>


<body>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success text-center">You have successfully registered for the seminar!</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
        <div class="alert alert-danger text-center">Registration failed. Please try again.</div>
    <?php endif; ?>

    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="menu" id="menu">
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'introduction')">Introduction</a></li>
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'pre-test')">Pre-Test</a></li>
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'learning-materials')">Learning Materials</a>
            </li>
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'videos')">Videos</a></li>
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'post-test')">Post-Test</a></li>
            <li><a href="#" class="menu-item" onclick="activateTab(this, 'seminar')">Seminar/Webinar</a></li>
        </ul>
    </div>

    <!-- Floating Arrow Toggle -->
    <div class="sidebar-toggle" id="sidebar-toggle"></div>

    <div class="content" id="content">
        <h1 class="content-title"><?php echo htmlspecialchars($course['course_name']); ?></h1>
        <div class="content-section" id="content-section"></div>
    </div>

    <!-- Pass PHP data as JSON -->
    <script>
        const courseData = {
            course_section: <?php echo json_encode($course_section); ?>,
            pre_test_questions: <?php echo json_encode($pre_test_questions_array); ?>,
            learning_materials: <?php echo json_encode($learning_materials_array); ?>,
            videos: <?php echo json_encode($videos_array); ?>,
            post_test_questions: <?php echo json_encode($post_test_questions_array); ?>,
            seminars: <?php echo json_encode($seminar_array); ?>
        };

        const contentData = {
            introduction: `
                <h2>Introduction</h2>
                <p>${courseData.course_section && courseData.course_section.section_content
                    ? courseData.course_section.section_content.replace(/\n/g, '<br>')
                    : 'No introduction available for this course.'}</p>
            `,
            'pre-test': `
                <h2>Pre-Test</h2>
                <p>Please take this pre-test to assess your prior knowledge before starting the course.</p>
                <form method="POST" action="submit_pretest.php">
                    <ol>
                        ${courseData.pre_test_questions.map(q => `
                            <li>
                                ${q.question_text}
                                <ul>
                                    <li><label><input type="radio" name="q${q.id}" value="a"> a) ${q.option_a}</label></li>
                                    <li><label><input type="radio" name="q${q.id}" value="b"> b) ${q.option_b}</label></li>
                                    <li><label><input type="radio" name="q${q.id}" value="c"> c) ${q.option_c}</label></li>
                                </ul>
                            </li>
                        `).join('')}
                    </ol>
                    <button type="submit" class="submit-button">SUBMIT</button>
                </form>
            `,
            'learning-materials': `
                <h2>Learning Materials</h2>
                <ul>
                    ${courseData.learning_materials.map(material => `
                        <li><a href="${material.file_path}" target="_blank">${material.file_name}</a></li>
                    `).join('')}
                </ul>
            `,
            videos: `
                <h2>Videos</h2>
                <div class="video-grid">
                    ${courseData.videos.map(video => `
                        <div class="video-item">
                            <video width="300" controls>
                                <source src="${video.video_path}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    `).join('')}
                </div>
            `,
            'post-test': `
                <h2>Post-Test</h2>
                <p>Take the post-test to evaluate your understanding after completing the course.</p>
                <form method="POST" action="submit_posttest.php">
                    <ol>
                        ${courseData.post_test_questions.map(q => `
                            <li>
                                ${q.question_text}
                                <ul>
                                    <li><label><input type="radio" name="q${q.id}" value="a"> a) ${q.option_a}</label></li>
                                    <li><label><input type="radio" name="q${q.id}" value="b"> b) ${q.option_b}</label></li>
                                    <li><label><input type="radio" name="q${q.id}" value="c"> c) ${q.option_c}</label></li>
                                </ul>
                            </li>
                        `).join('')}
                    </ol>
                    <button type="submit" class="submit-button">SUBMIT</button>
                </form>
            `,
            seminar: `
                <h2 class="page-title">Seminars/Webinars</h2>
                ${courseData.seminars.length > 0
                    ? courseData.seminars.map(seminar => `
                            <div class="seminar-item">
                                <img src="${seminar.poster_path}" alt="Seminar Banner" class="seminar-image">
                                <div class="seminar-text">
                                    <h1 class="seminar-title">${seminar.seminar_title}</h1>
                                    <p class="seminar-description">${seminar.description.replace(/\n/g, '<br>')}</p>
                                </div>
                                <div class="seminar-details">
                                    <p><strong>Date:</strong> ${seminar.date}</p>
                                    <p><strong>Time:</strong> ${seminar.time}</p>
                                    <p><strong>Venue:</strong> ${seminar.venue}</p>
                                </div>
                                <div class="seminar-buttons">
                                    ${seminar.include_registration ? `<a href="register.php?seminar_id=${seminar.seminar_id}&course_id=<?php echo htmlspecialchars($course_id); ?>" class="seminar-button">REGISTER</a>` : ''}
                                    ${seminar.include_attendance ? `<a href="attendance.php?seminar_id=${seminar.seminar_id}&course_id=<?php echo htmlspecialchars($course_id); ?>" class="seminar-button">ATTENDANCE</a>` : ''}
                                    ${seminar.include_evaluation ? `<a href="evaluation.php?seminar_id=${seminar.seminar_id}" class="seminar-button">EVALUATION</a>` : ''}
                                </div>
                            </div>
                            <hr>
                        `).join('')
                    : '<p>No seminars available for this course.</p>'
                }
            `
        };

        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab') || 'introduction';

            // Automatically activate the tab specified in the URL (or default to 'introduction')
            const targetTabElement = document.querySelector(`.menu-item[onclick*="${tab}"]`);
            if (targetTabElement) {
                activateTab(targetTabElement, tab);
            }

            document.getElementById('sidebar-toggle').addEventListener('click', toggleSidebar);
        });

        function activateTab(tabElement, tabName) {
            const contentSection = document.getElementById('content-section');
            document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
            tabElement.classList.add('active');
            contentSection.innerHTML = contentData[tabName] || "<p>No content available.</p>";
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleButton = document.getElementById('sidebar-toggle');

            if (sidebar && content && toggleButton) {
                if (sidebar.classList.contains('expanded')) {
                    sidebar.classList.remove('expanded');
                    content.classList.remove('shifted');
                    toggleButton.style.left = '0';
                } else {
                    sidebar.classList.add('expanded');
                    content.classList.add('shifted');
                    toggleButton.style.left = '250px';
                }
            } else {
                console.error("Sidebar, content, or toggle button not found in DOM.");
            }
        }
    </script>
</body>

</html>