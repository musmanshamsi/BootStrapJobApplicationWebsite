<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = ""; // Add your database password if needed
$database = "jobsapplication";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to retrieve job applications by category
function getApplications($conn, $category) {
    $stmt = $conn->prepare("SELECT `name`, `username`, `jobcategory`, `gender`, `jobtype` FROM `data` WHERE `jobcategory` = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #a4d3a2;
            color: black;
            padding: 15px;
            font-size: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .accordion-button {
            font-weight: bold;
            color: #333;
        }
        .rotate-icon {
            transition: transform 0.3s;
        }
        .rotate-icon.rotate {
            transform: rotate(180deg);
        }
        .icon-right {
            float: right;
        }
        .dot-online {
            position: absolute;
            left: 10px;
            font-weight: bold;
        }
        .accordion-open {
            background-color: lightblue !important;
        }

        footer {
            background-color: #a4d3a2; /* Light green background */
            color: black; /* Text color */
            padding: 20px; /* Padding */
            text-align: center; /* Center text */
        }
        footer .row {
            margin-bottom: 10px; /* Space between footer elements */
        }
        footer h5 {
            margin-bottom: 10px; /* Space below headings */
        }
        footer a {
            color: black; /* Link color */
            text-decoration: none; /* Remove underline */
        }
        footer a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>

<div class="header">
    <span class="dot-online">.online</span>    
    Candidates Applied
</div>
<hr>
<div class="container-fluid mt-4" id="accordion">
    <?php
    // Job categories to display
    $jobCategories = [
        "Web Development" => ["Frontend Developer", "Backend Developer", "Full-Stack Developer"],
        "Game Development" => ["Gameplay Programmer", "Level Designer", "3D Artist"],
        "Machine Learning" => ["Machine Learning Engineer", "Data Scientist", "AI Research Scientist"]
    ];

    // Colors for each table
    $tableColors = ["green", "blue", "red"];
    $colorIndex = 0;

    // Loop through each main category section and fetch applications
    foreach ($jobCategories as $section => $categories) {
        // Set 'show' class for the first section to make it open by default
        $showClass = ($colorIndex === 0) ? 'show' : '';
        echo "<div class='card'>
                <div class='card-header accordion-button' data-toggle='collapse' href='#collapse".str_replace(" ", "", $section)."' aria-expanded='true'>
                    <span>$section Jobs</span>
                    <span class='icon-right'><i class='fas fa-chevron-down rotate-icon'></i></span>
                </div>
                <div id='collapse".str_replace(" ", "", $section)."' class='collapse $showClass' data-parent='#accordion'>
                    <div class='card-body'>";

        // Display a single table for each main category with unique border color
        echo "<table class='table table-bordered' style='border-color: ".$tableColors[$colorIndex]."; border-width: 2px;'>
                  <thead>
                      <tr style='border-color: ".$tableColors[$colorIndex].";'>
                          <th style='border-color: ".$tableColors[$colorIndex].";'>Name</th>
                          <th style='border-color: ".$tableColors[$colorIndex].";'>Email</th>
                          <th style='border-color: ".$tableColors[$colorIndex].";'>Job Category</th>
                          <th style='border-color: ".$tableColors[$colorIndex].";'>Gender</th>
                          <th style='border-color: ".$tableColors[$colorIndex].";'>Job Type</th>
                      </tr>
                  </thead>
                  <tbody>";

        // Loop through each job role under the current main category
        foreach ($categories as $category) {
            $applications = getApplications($conn, $category);
            if (count($applications) > 0) {
                foreach ($applications as $app) {
                    // Check if the jobtype contains both "Part-Time" and "Full-Time"
                    $jobTypeDisplay = $app['jobtype'] === "Part-Time, Full-Time" ? "Both" : $app['jobtype'];
                    
                    echo "<tr style='border-color: ".$tableColors[$colorIndex].";'>
                            <td style='border-color: ".$tableColors[$colorIndex].";'>".$app['name']."</td>
                            <td style='border-color: ".$tableColors[$colorIndex].";'>".$app['username']."</td>
                            <td style='border-color: ".$tableColors[$colorIndex].";'>".$app['jobcategory']."</td>
                            <td style='border-color: ".$tableColors[$colorIndex].";'>".$app['gender']."</td>
                            <td style='border-color: ".$tableColors[$colorIndex].";'>".$jobTypeDisplay."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='border-color: ".$tableColors[$colorIndex].";'>No applications for $category.</td></tr>";
            }
        }
        echo "</tbody></table></div></div></div>";

        // Increment color index for each main category table
        $colorIndex++;
    }

    // Close database connection
    $conn->close();
    ?>
</div>
<br>
<br>
<br>
<!--Footer started-->
<footer style="background-color: #a4d3a2; color: black; padding: 20px; text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>About Us</h5>
                    <p>Learn more about our company, our mission, and our values.</p>
                </div>
                <div class="col">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Job Listings</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Contact</h5>
                    <p>Email: info@jobportal.com</p>
                    <p>Phone: +1 123 456 7890</p>
                </div>
                <div class="col">
                    <h5>Follow Us</h5>
                    <a href="#">Facebook</a> | 
                    <a href="#">Twitter</a> | 
                    <a href="#">LinkedIn</a>
                </div>
            </div>
            <hr>
            <p>© 2024 Job Portal. All rights reserved.</p>
        </div>
    </footer>

    <!--Footer Ended-->

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.accordion-button').on('click', function() {
            $(this).find('.rotate-icon').toggleClass('rotate');
            if ($(this).next('.collapse').hasClass('show')) {
                $(this).removeClass('accordion-open');
            } else {
                $(this).addClass('accordion-open');
            }
        });

        $('.collapse').on('show.bs.collapse', function() {
            $(this).prev('.card-header').addClass('accordion-open');
        }).on('hide.bs.collapse', function() {
            $(this).prev('.card-header').removeClass('accordion-open');
        });
    });
</script>

</body>
</html>
