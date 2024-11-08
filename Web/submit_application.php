<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = ""; // Update this if you have a password set
$database = "jobsapplication"; // Ensure this database exists

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert data into the database
function submitApplication($conn, $name, $username, $jobcategory, $gender, $jobtype) {
    $stmt = $conn->prepare("INSERT INTO `data` (`name`, `username`, `jobcategory`, `gender`, `jobtype`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $jobcategory, $gender, $jobtype);
    
    if ($stmt->execute()) {
        header("Location: view_applications.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $jobtype = isset($_POST['jobtype']) ? implode(', ', $_POST['jobtype']) : ''; // Concatenate job types if multiple
    
    // Determine which button was clicked based on the job category
    if (isset($_POST['frontend'])) {
        $jobcategory = "Frontend Developer";
    } elseif (isset($_POST['backend'])) {
        $jobcategory = "Backend Developer";
    } elseif (isset($_POST['fullstack'])) {
        $jobcategory = "Full-Stack Developer";
    } elseif (isset($_POST['gameplay'])) {
        $jobcategory = "Gameplay Programmer";
    } elseif (isset($_POST['level'])) {
        $jobcategory = "Level Designer";
    } elseif (isset($_POST['artist'])) {
        $jobcategory = "3D Artist";
    } elseif (isset($_POST['mlengineer'])) {
        $jobcategory = "Machine Learning Engineer";
    } elseif (isset($_POST['datascientist'])) {
        $jobcategory = "Data Scientist";
    } elseif (isset($_POST['airesearcher'])) {
        $jobcategory = "AI Research Scientist";
    } else {
        $jobcategory = "";
    }

    // Insert the application into the database if a job category is chosen
    if ($jobcategory) {
        submitApplication($conn, $name, $username, $jobcategory, $gender, $jobtype);
    } else {
        echo "Please select a job category.";
    }
}

// Close the database connection
$conn->close();
?>
