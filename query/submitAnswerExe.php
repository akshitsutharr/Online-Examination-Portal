<?php
 session_start(); 
 include("../conn.php");
 extract($_POST);

 $exmne_id = $_SESSION['examineeSession']['exmne_id'];

// Check if there are old answers for this exam and mark them as old
$selAns = $conn->query("SELECT * FROM exam_answers WHERE axmne_id='$exmne_id' AND exam_id='$exam_id' ");

if($selAns->rowCount() > 0)
{
	$updLastAns = $conn->query("UPDATE exam_answers SET exans_status='old' WHERE axmne_id='$exmne_id' AND exam_id='$exam_id'  ");
	if($updLastAns)
	{
		foreach ($_REQUEST['answer'] as $key => $value) {
			 $value = $value['correct'];
		  	 $insAns = $conn->query("INSERT INTO exam_answers(axmne_id,exam_id,quest_id,exans_answer) VALUES('$exmne_id','$exam_id','$key','$value')");
		}
		if($insAns)
		{
			 $insAttempt = $conn->query("INSERT INTO exam_attempt(exmne_id,exam_id)  VALUES('$exmne_id','$exam_id') ");
			 if($insAttempt)
			 {
				 $res = array("res" => "success");
			 }
			 else
			 {
				 $res = array("res" => "failed");
			 }
		}
		else
		{
			 $res = array("res" => "failed");
		}
	}
}
else
{
	foreach ($_REQUEST['answer'] as $key => $value) {
		 $value = $value['correct'];
	  	 $insAns = $conn->query("INSERT INTO exam_answers(axmne_id,exam_id,quest_id,exans_answer) VALUES('$exmne_id','$exam_id','$key','$value')");
	}
	if($insAns)
	{
		 $insAttempt = $conn->query("INSERT INTO exam_attempt(exmne_id,exam_id)  VALUES('$exmne_id','$exam_id') ");
		 if($insAttempt)
		 {
			 $res = array("res" => "success");
		 }
		 else
		 {
			 $res = array("res" => "failed");
		 }
	}
	else
	{
		 $res = array("res" => "failed");
	}
}

echo json_encode($res);
 ?>


 