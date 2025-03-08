<?php
session_start();
include 'db_connect.php'; // Ensure this file contains database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sap = $_POST['sap'];
    $password = $_POST['password'];

    // Fetch user details from database
    $stmt = $conn->prepare("SELECT * FROM students WHERE sap_number = ?");
    $stmt->bind_param("s", $sap);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['sap'] = $user['sap_number'];
        $_SESSION['name'] = $user['full_name'];

        // Redirect to dashboard
        header("Location: dashboard.html");
        exit();
    } else {
        echo "<script>alert('Invalid SAP Number or Password'); window.location.href='student-login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
