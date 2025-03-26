<?php 

// Database connection parameters
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cee_db";
$conn = null;

try {
    // Create a PDO connection with appropriate error handling
    $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Enable exceptions for connection errors
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch (PDOException $e) {
    // Log the error or display it if in development environment
    $error_message = "Connection failed: " . $e->getMessage();
    error_log($error_message);
    
    // You can uncomment this in development environment
    // echo $error_message;
    
    // Set conn to null to indicate failed connection
    $conn = null;
    
    // In production, you might want to redirect to an error page
    // header("Location: error.php");
    // exit;
}


 ?>