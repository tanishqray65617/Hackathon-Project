<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$database = "festa_sphere";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $sap = $_POST["sap"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $school = $_POST["school"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hashing the password
$hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert data into database
    $sql = "INSERT INTO students (name, sap_number, email, contact, school, password) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $sap, $email, $contact, $school, $password);
    
    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
