<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../learner/assets/common/css/LearnerNavBar.css">
    <link rel="stylesheet" href="../learner/assets/css/Home.css">
</head>

<body class="bg-light">
    <?php include '../learner/assets/common/LearnerNavBar.php'; ?>
    <!-- Image Slider Section -->
    <div class="container my-5 slider-container-fixed">
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./assets/images/A.jpg" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/B.jpg" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/C.jpg" class="d-block w-100" alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Slogan Section with Animation -->
    <section class="bg-primary py-5 text-center text-white fade-in">
        <p class="h5 px-4">
            The Batangas State University's Gender and Development Office aims to provide gender-responsive programs, projects, and services that address the needs and concerns of men and women.
        </p>
    </section>

   <!-- Latest Trainings Section -->
<section class="container my-5 py-5 border rounded">
    <h2 class="text-center mb-5">LATEST TRAININGS</h2>
    <div id="trainingsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- First Slide -->
            <div class="carousel-item active">
                <div class="row gx-4">
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=5#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 1">
                            <div class="card-body">
                                <h5 class="card-title">LARGA 2024: Gender-Responsive Activity</h5>
                                <p class="card-text">June 25, 2024</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=2#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 2">
                            <div class="card-body">
                                <h5 class="card-title">2024 KAGAPAY Student Research Forum</h5>
                                <p class="card-text">June 17, 2024</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=3#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 3">
                            <div class="card-body">
                                <h5 class="card-title">Benchmarking Activity with the UP Center for Women's and Gender Studies</h5>
                                <p class="card-text">May 09, 2024</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Second Slide -->
            <div class="carousel-item">
                <div class="row gx-4">
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=4#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 4">
                            <div class="card-body">
                                <h5 class="card-title">Another Training</h5>
                                <p class="card-text">July 15, 2024</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=5#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 5">
                            <div class="card-body">
                                <h5 class="card-title">Yet Another Training</h5>
                                <p class="card-text">August 21, 2024</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <a href="http://localhost/GAD-1/learner/CourseContent.php?course_id=6#seminar-section" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Training 6">
                            <div class="card-body">
                                <h5 class="card-title">Training Example</h5>
                                <p class="card-text">September 10, 2024</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#trainingsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#trainingsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


    <!-- Featured Course Offerings Section -->
    <section class="container my-5 py-5 border rounded bg-light">
    <div class="text-center">
        <h2 class="mb-5">FEATURED COURSE OFFERINGS</h2>
        
        <!-- Initial Row of Courses -->
        <div id="featuredCourses" class="row g-4">
            <div class="col-6 col-md-3">
                <a href="CourseContent.php?course_id=1#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                    "Title of a course 1"
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="CourseContent.php?course_id=2#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                    "Title of a course 2"
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="CourseContent.php?course_id=3#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                    "Title of a course 3"
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="CourseContent.php?course_id=4#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                    "Title of a course 4"
                </a>
            </div>
        </div>

        <!-- Hidden Additional Rows of Courses -->
        <div id="additionalCourses" class="d-none">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <a href="CourseContent.php?course_id=5#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                        "Title of a course 5"
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="CourseContent.php?course_id=6#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                        "Title of a course 6"
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="CourseContent.php?course_id=7#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                        "Title of a course 7"
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="CourseContent.php?course_id=8#introduction-section" class="bg-secondary p-4 rounded h-100 d-flex align-items-center justify-content-center text-white text-decoration-none">
                        "Title of a course 8"
                    </a>
                </div>
            </div>
            <!-- Add more rows here if needed -->
        </div>

        <!-- "See More" and "Show Less" buttons -->
        <button id="seeMoreBtn" class="btn btn-primary mt-4" onclick="showMoreRow()">See More</button>
        <button id="showLessBtn" class="btn btn-secondary mt-4 d-none" onclick="showLess()">Show Less</button>
    </div>
</section>
<script>
    // JavaScript to control row visibility
    function showMoreRow() {
        // Get the hidden additional courses container
        const additionalCourses = document.getElementById("additionalCourses");

        // Clone the first hidden row of courses and make it visible
        const newRow = additionalCourses.querySelector('.row').cloneNode(true);
        newRow.classList.remove('d-none');

        // Append the new row to the featuredCourses section
        document.getElementById("featuredCourses").appendChild(newRow);

        // Remove the row from additionalCourses
        additionalCourses.removeChild(additionalCourses.querySelector('.row'));

        // Show the "Show Less" button
        document.getElementById("showLessBtn").classList.remove('d-none');

        // Hide the "See More" button if there are no more rows in additionalCourses
        if (!additionalCourses.querySelector('.row')) {
            document.getElementById("seeMoreBtn").style.display = "none";
        }
    }

    function showLess() {
        const featuredCourses = document.getElementById("featuredCourses");
        const additionalCourses = document.getElementById("additionalCourses");

        // Remove all rows except the initial row of four courses
        while (featuredCourses.childElementCount > 4) {
            const lastRow = featuredCourses.lastElementChild;
            additionalCourses.insertAdjacentElement("afterbegin", lastRow); // Move back to additionalCourses
        }

        // Show the "See More" button again
        document.getElementById("seeMoreBtn").style.display = "inline-block";
        
        // Hide the "Show Less" button
        document.getElementById("showLessBtn").classList.add('d-none');
    }
</script>

    <!-- Campaigns Section with Carousel and Next Button -->
<section class="container my-5 py-5 border rounded">
    <h2 class="text-center mb-5">CAMPAIGNS</h2>
    <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row gx-4 gy-4">
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=21" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 1">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Gender Responsive Disaster</h5>
                                <p class="card-text text-muted">July 22, 2022</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=22" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 2">
                            <div class="card-body">
                                <h5 class="card-title text-primary">PRIDE: A Celebration of Self</h5>
                                <p class="card-text text-muted">June 28, 2022</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=23" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 3">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Orientation on Safe Spaces Act</h5>
                                <p class="card-text text-muted">December 03, 2021</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=24" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 4">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Women Empowerment Summit</h5>
                                <p class="card-text text-muted">August 15, 2023</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row gx-4 gy-4">
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=25" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 5">
                            <div class="card-body">
                                <h5 class="card-title text-primary">New Campaign 1</h5>
                                <p class="card-text text-muted">September 12, 2023</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=26" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 6">
                            <div class="card-body">
                                <h5 class="card-title text-primary">New Campaign 2</h5>
                                <p class="card-text text-muted">October 5, 2023</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=27" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">New Campaign 3</h5>
                                <p class="card-text text-muted">November 18, 2023</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="http://localhost/GAD-1/learner/AdvocacyCampaignRedirection.php?id=28" class="card shadow h-100 text-decoration-none text-dark">
                            <img src="https://placehold.co/300x180" class="card-img-top" alt="Campaign 8">
                            <div class="card-body">
                                <h5 class="card-title text-primary">New Campaign 4</h5>
                                <p class="card-text text-muted">December 25, 2023</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
