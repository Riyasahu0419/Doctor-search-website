<?php
// Step 1: Establish database connection
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = "";
$dbname = "search doctor"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Step 3: Sanitize and validate input data (you can implement more thorough validation)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Step 4: Insert data into database
    $sql = "INSERT INTO appointments (name, number, email, appointment_date) 
            VALUES ('$name', '$number', '$email', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>