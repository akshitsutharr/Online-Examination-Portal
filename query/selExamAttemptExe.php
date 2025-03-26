<?php 
 session_start();
 include("../conn.php");
$exmneId = $_SESSION['examineeSession']['exmne_id'];
 

extract($_POST);

// Modified to allow retaking exams
// For now, we won't check if the exam has been taken before
$res = array("res" => "takeNow");

echo json_encode($res);
 ?>