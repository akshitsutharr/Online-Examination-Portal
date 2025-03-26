<?php 
session_start();
include("../conn.php");

// Debug information
$debug = true; // Temporarily enable debugging
if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Login attempt\n", FILE_APPEND);
    file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
}

extract($_POST);

// Try-catch block to catch any PDO exceptions
try {
    $selAcc = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_email='$username' AND exmne_password='$pass'");
    $selAccRow = $selAcc->fetch(PDO::FETCH_ASSOC);

    if($selAcc->rowCount() > 0)
    {
        $_SESSION['examineeSession'] = array(
            'exmne_id' => $selAccRow['exmne_id'],
            'examineenakalogin' => true
        );
        $res = array("res" => "success");
        
        if ($debug) {
            file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Login successful for: $username\n", FILE_APPEND);
        }
    }
    else
    {
        $res = array("res" => "invalid");
        
        if ($debug) {
            file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Invalid login for: $username\n", FILE_APPEND);
        }
    }
} catch (PDOException $e) {
    $res = array("res" => "error", "message" => $e->getMessage());
    
    if ($debug) {
        file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}

// Set appropriate headers
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($res);
?>