<?php
// ... your PHP code to fetch doctors from the database ...
// ... your PHP code to fetch doctors from the database ...
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ''; // Change this to your database password
$dbname = "search doctor"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape user input to prevent SQL injection (sanitize for security)
$specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
$location = mysqli_real_escape_string($conn, $_POST['location']);

// Build the query dynamically based on form input
$sql = "SELECT * FROM doctors WHERE 1 "; // Initial condition to always select rows

if (!empty($specialty)) {
    $sql .= " AND specialty = '$specialty' ";
}

if (!empty($location)) {
    $sql .= " AND location = '$location' ";
}

// Execute the query
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    *{
    
    }
    body {
        font-family: Arial, sans-serif;
    }
    
    h2 {
        text-align: center;
        margin-top: 20px;
        font-size: 3.5rem;
        color: #8285FA;
    }
    
    .doctor-card {
        height: 500px;
        width: 400px;
        display: inline-block;
        background-color: beige;
        margin: 10px;
        margin-right: 20%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        /* width: 250px; Adjust card width as needed */
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-left: 25px;
    }

    .doctor-card img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-top: 10px;
        margin-bottom: 50px;
    }

    .doctor-card h3 {
        margin-top: 5px;
        margin-bottom: 5px;
        font-size: 2rem;
    }

    .doctor-card p {
        margin-top: 5px;
        margin-bottom: 5px;
        font-size: 1.5rem;
    }
</style>

<body>
    <?php

    // Check for errors
    if ($result->num_rows > 0) {
        echo "<h2>Search Results</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='doctor-card'>";

            // Assuming you have a 'image_path' column in your 'doctors' table
            if (!empty($row['image'])) {
                $imagePath = $row['image']; // Replace with your image path logic (absolute or relative)
                echo "<img src='$imagePath' alt='Dr. " . $row['name'] . "'>";
            } else {
                echo "<img src='images/doctor-placeholder.png' alt='Doctor Placeholder'>"; // Placeholder image
            }

            echo "<h3>Dr. " . $row['name'] . "</h3>";
            echo "<p>Specialty: " . $row['specialty'] . "</p>";
            echo "<p>Location: " . $row['location'] . "</p>";
            // Add other doctor details (phone number, email, etc.) as needed
            // Consider adding a link to a doctor's profile or appointment booking page
            echo "</div>";
        }
    } else {
        echo "No doctors found matching your criteria.";
    }

    $conn->close();
    ?>
</body>

</html>