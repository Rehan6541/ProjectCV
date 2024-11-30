<?php
require 'connection.php'; // Assumes you have a 'connection.php' for DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Personal Details
    $name = $_POST['name'];
    $about = $_POST['about'];
    $phone_number = $_POST['number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];

    // Education, Skills, Hobbies, Certificates, and Internships
    $education = $_POST['education'];
    $skills = $_POST['skills'];
    $hobbies = $_POST['hobbies'];
    $certificates = $_POST['certificates'];
    $internships = $_POST['internships'];

    // Projects (passed as JSON string)
    $projects = json_decode($_POST['projects'], true); // Convert the JSON string to an array

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM personal_details WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists, do not insert the record
        echo "Email already exists in the database.";
    } else {
        // Email does not exist, insert the new record
        $stmt = $conn->prepare("INSERT INTO personal_details (name, about, phone_number, address, email, linkedin, github) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $about, $phone_number, $address, $email, $linkedin, $github);
        $stmt->execute();

        // Get the last inserted ID to associate with related tables
        $user_id = $conn->insert_id;

        // Insert education details into education table
        $stmt = $conn->prepare("INSERT INTO education (user_id, details) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $education);
        $stmt->execute();

        // Insert skills into skills table
        $stmt = $conn->prepare("INSERT INTO skills (user_id, skill_list) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $skills);
        $stmt->execute();

        // Insert hobbies into hobbies table
        $stmt = $conn->prepare("INSERT INTO hobbies (user_id, interests) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $hobbies);
        $stmt->execute();

        // Insert certificates into certificates table
        $stmt = $conn->prepare("INSERT INTO certificates (user_id, certificate_details) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $certificates);
        $stmt->execute();

        // Insert internships into internships table
        $stmt = $conn->prepare("INSERT INTO internships (user_id, internship_details) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $internships);
        $stmt->execute();

        // Insert projects into projects table
        if (is_array($projects) && !empty($projects)) {
            foreach ($projects as $project) {
                $project_name = $project['name'];
                $project_description = $project['description'];

                $stmt = $conn->prepare("INSERT INTO projects (user_id, project_name, project_description) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $user_id, $project_name, $project_description);
                $stmt->execute();
            }
        }

        // Redirect to display_profile.php
        header("Location: display_profile.php?user_id=$user_id");
        exit();
    }
}
?>