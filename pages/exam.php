<script type="text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>

<style>
    /* Custom styling for difficulty badges */
    .difficulty-badge {
        display: inline-block;
        min-width: 70px;
        padding: 6px 10px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        border-radius: 4px;
        margin-right: 15px;
        margin-top: 2px;
        text-transform: uppercase;
    }
    
    .difficulty-easy {
        background-color: #28a745;
        color: white;
    }
    
    .difficulty-medium {
        background-color: #ffc107;
        color: #212529;
    }
    
    .difficulty-hard {
        background-color: #dc3545;
        color: white;
    }
    
    .question-container {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    
    .question-content {
        flex: 1;
    }
</style>

<?php 
    $examId = $_GET['id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);
    $selExamTimeLimit = $selExam['ex_time_limit'];
    $exDisplayLimit = $selExam['ex_questlimit_display'];
?>


<div class="app-main__outer">
<div class="app-main__inner">
    <div class="col-md-12">
         <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <?php echo $selExam['ex_title']; ?>
                            <div class="page-title-subheading">
                              <?php echo $selExam['ex_description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions mr-5" style="font-size: 20px;">
                        <form name="cd">
                          <input type="hidden" name="" id="timeExamLimit" value="<?php echo $selExamTimeLimit; ?>">
                          <label>Remaining Time : </label>
                          <input style="border:none;background-color: transparent;color:blue;font-size: 25px;" name="disp" type="text" class="clock" id="txt" value="00:00" size="5" readonly="true" />
                      </form> 
                    </div>   
                 </div>
            </div>  
    </div>

    <div class="col-md-12 p-0 mb-4">
        <form method="post" id="submitAnswerFrm">
            <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $examId; ?>">
            <input type="hidden" name="examAction" id="examAction" >
        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
        <?php 
            // Get all questions for this exam, fully randomized
            $selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$examId' ORDER BY RAND() LIMIT $exDisplayLimit");
            
            // Check if we have questions
            if($selQuest->rowCount() > 0)
            {
                $i = 1;
                while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { 
                    $questId = $selQuestRow['eqt_id']; 
                    
                    // Get the difficulty level and set badge color
                    $difficultyLevel = ucfirst($selQuestRow['exam_difficulty']);
                    $badgeColor = 'secondary';
                    
                    if ($difficultyLevel == 'Easy') {
                        $badgeColor = 'success';
                    } elseif ($difficultyLevel == 'Medium') {
                        $badgeColor = 'warning';
                    } elseif ($difficultyLevel == 'Hard') {
                        $badgeColor = 'danger';
                    }
                    ?>
                    <tr>
                        <td>
                            <div class="question-container">
                                <div class="difficulty-badge difficulty-<?php echo strtolower($difficultyLevel); ?>">
                                    <?php echo $difficultyLevel; ?>
                                </div>
                                <div class="question-content">
                                    <p><b><?php echo $i++ ; ?> .) <?php echo $selQuestRow['exam_question']; ?></b></p>
                                    <div class="col-md-4 float-left">
                                        <div class="form-group pl-4 ">
                                            <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch1']; ?>" class="form-check-input" type="radio" value="" id="invalidCheck" required >
                                        
                                            <label class="form-check-label" for="invalidCheck">
                                                <?php echo $selQuestRow['exam_ch1']; ?>
                                            </label>
                                        </div>  

                                        <div class="form-group pl-4">
                                            <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch2']; ?>" class="form-check-input" type="radio" value="" id="invalidCheck" required >
                                        
                                            <label class="form-check-label" for="invalidCheck">
                                                <?php echo $selQuestRow['exam_ch2']; ?>
                                            </label>
                                        </div>   
                                    </div>
                                    <div class="col-md-8 float-left">
                                        <div class="form-group pl-4">
                                            <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch3']; ?>" class="form-check-input" type="radio" value="" id="invalidCheck" required >
                                        
                                            <label class="form-check-label" for="invalidCheck">
                                                <?php echo $selQuestRow['exam_ch3']; ?>
                                            </label>
                                        </div>  

                                        <div class="form-group pl-4">
                                            <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch4']; ?>" class="form-check-input" type="radio" value="" id="invalidCheck" required >
                                        
                                            <label class="form-check-label" for="invalidCheck">
                                                <?php echo $selQuestRow['exam_ch4']; ?>
                                            </label>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php }
                ?>
                       <tr>
                             <td style="padding: 20px;">
                                 <button type="button" class="btn btn-xlg btn-warning p-3 pl-4 pr-4" id="resetExamFrm">Reset</button>
                                 <input name="submit" type="submit" value="Submit" class="btn btn-xlg btn-primary p-3 pl-4 pr-4 float-right" id="submitAnswerFrmBtn">
                             </td>
                         </tr>

                <?php
            }
            else
            { ?>
                <b>No question at this moment</b>
            <?php }
         ?>   
              </table>

        </form>
    </div>
</div>
 
