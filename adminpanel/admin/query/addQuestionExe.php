<?php 
 include("../../../conn.php");

// Set headers
header('Content-Type: application/json');

// Check if required fields are set
if (!isset($_POST['examId']) || !isset($_POST['question']) || !isset($_POST['choice_A']) || 
    !isset($_POST['choice_B']) || !isset($_POST['choice_C']) || !isset($_POST['choice_D']) || 
    !isset($_POST['correctAnswer'])) {
    echo json_encode(array("res" => "failed", "msg" => "Missing required fields"));
    exit();
}

// Extract POST data
extract($_POST);

try {
    // Check if question already exists
    $selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$examId' AND exam_question='$question' ");
    
    if($selQuest->rowCount() > 0)
    {
        $res = array("res" => "exist", "msg" => $question);
    }
    else
    {
        // Insert the question
        $insQuest = $conn->query("INSERT INTO exam_question_tbl(exam_id,exam_question,exam_ch1,exam_ch2,exam_ch3,exam_ch4,exam_answer,exam_difficulty) 
                                VALUES('$examId','$question','$choice_A','$choice_B','$choice_C','$choice_D','$correctAnswer','$difficulty') ");

        if($insQuest)
        {
            $res = array("res" => "success", "msg" => $question);
        }
        else
        {
            $res = array("res" => "failed", "msg" => "Database insertion failed");
        }
    }
} catch (PDOException $e) {
    // Handle database errors
    $res = array("res" => "failed", "msg" => "Database error: " . $e->getMessage());
}

// Return JSON response
echo json_encode($res);
?>