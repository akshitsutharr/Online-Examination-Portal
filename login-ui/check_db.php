<?php
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("../conn.php");

echo "<h2>Database Connection Test</h2>";

// Check connection
if ($conn) {
    echo "<p style='color:green'>Database connection successful!</p>";
    
    // Check if table exists and has records
    try {
        $query = $conn->query("SELECT COUNT(*) AS count FROM examinee_tbl");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Number of examinees in database: " . $result['count'] . "</p>";
        
        // Show some sample user credentials if available
        if ($result['count'] > 0) {
            $users = $conn->query("SELECT exmne_id, exmne_fullname, exmne_email FROM examinee_tbl LIMIT 5");
            echo "<h3>Sample Users:</h3>";
            echo "<ul>";
            while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>ID: " . $user['exmne_id'] . ", Name: " . $user['exmne_fullname'] . ", Email: " . $user['exmne_email'] . "</li>";
            }
            echo "</ul>";
            
            echo "<p>To test login, use one of these emails with the corresponding password.</p>";
        } else {
            echo "<p style='color:orange'>No user records found in the database. You need to add users first.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red'>Error checking tables: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red'>Database connection failed!</p>";
}

// Show database config (without password)
echo "<h3>Database Configuration:</h3>";
echo "<p>Host: localhost<br>";
echo "Database: cee_db<br>";
echo "Username: root</p>";

// Display PHP and Server information
echo "<h3>System Information:</h3>";
echo "<p>PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
?> 