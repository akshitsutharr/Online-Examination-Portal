-- Add difficulty column to exam_question_tbl
ALTER TABLE `exam_question_tbl` 
ADD COLUMN `exam_difficulty` ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium' 
AFTER `exam_answer`;

-- Update existing questions with random difficulty values for testing
UPDATE `exam_question_tbl` SET `exam_difficulty` = 'easy' WHERE `eqt_id` % 3 = 0;
UPDATE `exam_question_tbl` SET `exam_difficulty` = 'medium' WHERE `eqt_id` % 3 = 1;
UPDATE `exam_question_tbl` SET `exam_difficulty` = 'hard' WHERE `eqt_id` % 3 = 2; 