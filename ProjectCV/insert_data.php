<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect personal details from the form
    $name = $_POST['name'];
    $about = $_POST['about'];
    $phone_number = $_POST['number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];
    $hobbies = $_POST['hobbies'];
    $certificates = $_POST['certificates'];
    $internships = $_POST['internships'];
    $projects = json_decode($_POST['projects'], true); // Decoding JSON array

    // Insert personal details
    $sql = "INSERT INTO personal_details (name, about, phone_number, address, email, linkedin, github) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $about, $phone_number, $address, $email, $linkedin, $github);
    $stmt->execute();
    $user_id = $stmt->insert_id;

    // Insert education details
    $sql = "INSERT INTO education (user_id, details) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $education);
    $stmt->execute();

    // Insert skills
    $sql = "INSERT INTO skills (user_id, skill_list) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $skills);
    $stmt->execute();

    // Insert hobbies
    $sql = "INSERT INTO hobbies (user_id, interests) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $hobbies);
    $stmt->execute();

    // Insert certificates
    $sql = "INSERT INTO certificates (user_id, certificate_details) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $certificates);
    $stmt->execute();

    // Insert internships
    $sql = "INSERT INTO internships (user_id, internship_details) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $internships);
    $stmt->execute();

    // Insert projects
    foreach ($projects as $project) {
        $project_name = $project['name'];
        $project_description = $project['description'];
        $sql = "INSERT INTO projects (user_id, project_name, project_description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $project_name, $project_description);
        $stmt->execute();
    }

    // Redirect or confirm success
    echo "Data inserted successfully!";
}
?>
