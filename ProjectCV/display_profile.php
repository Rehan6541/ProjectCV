<?php
require 'connection.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch personal details
    $stmt = $conn->prepare("SELECT * FROM personal_details WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $personal_details = $stmt->get_result()->fetch_assoc();

    // Fetch education details
    $stmt = $conn->prepare("SELECT details FROM education WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $education_details = $stmt->get_result()->fetch_assoc()['details'];

    // Fetch skills
    $stmt = $conn->prepare("SELECT skill_list FROM skills WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $skills = $stmt->get_result()->fetch_assoc()['skill_list'];

    // Fetch hobbies
    $stmt = $conn->prepare("SELECT interests FROM hobbies WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $hobbies = $stmt->get_result()->fetch_assoc()['interests'];

    // Fetch certificates
    $stmt = $conn->prepare("SELECT certificate_details FROM certificates WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $certificates = $stmt->get_result()->fetch_assoc()['certificate_details'];

    // Fetch internships
    $stmt = $conn->prepare("SELECT internship_details FROM internships WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $internships = $stmt->get_result()->fetch_assoc()['internship_details'];

    // Fetch projects
    $stmt = $conn->prepare("SELECT project_name, project_description FROM projects WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .container {
            max-width: 900px;
        }
        h1 {
            color: #343a40;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .section-title {
            color: #495057;
            font-weight: bold;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .personal-info p {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .projects ul {
            list-style-type: none;
            padding-left: 0;
        }
        .projects li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>Profile Details</h1>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title"><?php echo $personal_details['name']; ?></h2>
                <div class="personal-info">
                    <p><?php echo $personal_details['about']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $personal_details['phone_number']; ?></p>
                    <p><strong>Address:</strong> <?php echo $personal_details['address']; ?></p>
                    <p><strong>Email:</strong> <?php echo $personal_details['email']; ?></p>
                    <p><strong>LinkedIn:</strong> <a href="<?php echo $personal_details['linkedin']; ?>" target="_blank"><?php echo $personal_details['linkedin']; ?></a></p>
                    <p><strong>GitHub:</strong> <a href="<?php echo $personal_details['github']; ?>" target="_blank"><?php echo $personal_details['github']; ?></a></p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title">Education</h2>
                <p><?php echo $education_details; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title">Skills</h2>
                <p><?php echo $skills; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title">Hobbies</h2>
                <p><?php echo $hobbies; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title">Certificates</h2>
                <p><?php echo $certificates; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="section-title">Internships</h2>
                <p><?php echo $internships; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-body projects">
                <h2 class="section-title">Projects</h2>
                <ul>
                    <?php foreach ($projects as $project): ?>
                        <li>
                            <h5><?php echo $project['project_name']; ?></h5>
                            <p><?php echo $project['project_description']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
