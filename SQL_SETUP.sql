-- ============================================
-- Create sub_topic_scores table
-- ============================================
-- This table stores per-subtopic scores for each user's test attempt
-- No migration needed - run this SQL directly

CREATE TABLE IF NOT EXISTS sub_topic_scores (
    id CHAR(36) PRIMARY KEY COMMENT 'UUID',
    answer_sheet_id CHAR(36) NOT NULL COMMENT 'Reference to answer_sheets table',
    sub_topic_id CHAR(36) NOT NULL COMMENT 'Reference to sub_topics table',
    total_questions INT NOT NULL DEFAULT 0 COMMENT 'Total questions in this sub-topic',
    correct_answers INT NOT NULL DEFAULT 0 COMMENT 'Number of correct answers',
    total_score INT NOT NULL DEFAULT 0 COMMENT 'Total score (sum of weights)',
    passing_grade INT NOT NULL DEFAULT 70 COMMENT 'Passing grade percentage',
    is_passed BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Whether user passed this sub-topic',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes for performance
    INDEX idx_answer_sheet_id (answer_sheet_id),
    INDEX idx_sub_topic_id (sub_topic_id),
    UNIQUE KEY unique_sheet_topic (answer_sheet_id, sub_topic_id),
    
    -- Foreign keys
    CONSTRAINT fk_sub_topic_scores_answer_sheet 
        FOREIGN KEY (answer_sheet_id) 
        REFERENCES answer_sheets(id) 
        ON DELETE CASCADE,
    
    CONSTRAINT fk_sub_topic_scores_sub_topic 
        FOREIGN KEY (sub_topic_id) 
        REFERENCES sub_topics(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Verify tables exist
-- ============================================

-- Check if sub_topic_scores table was created
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sub_topic_scores';

-- ============================================
-- Sample queries
-- ============================================

-- Get all scores for a specific answer sheet
SELECT 
    sts.id,
    sts.answer_sheet_id,
    st.name as sub_topic_name,
    sts.total_questions,
    sts.correct_answers,
    sts.total_score,
    sts.passing_grade,
    sts.is_passed,
    ROUND((sts.total_score / sts.total_questions * 100), 2) as percentage
FROM sub_topic_scores sts
JOIN sub_topics st ON sts.sub_topic_id = st.id
WHERE sts.answer_sheet_id = '{answer_sheet_id}'
ORDER BY st.name;

-- Get user's performance across all attempts
SELECT 
    u.name,
    p.title as package_title,
    st.name as sub_topic_name,
    COUNT(sts.id) as attempt_count,
    AVG(sts.total_score) as avg_score,
    SUM(CASE WHEN sts.is_passed THEN 1 ELSE 0 END) as passed_count
FROM sub_topic_scores sts
JOIN answer_sheets ans ON sts.answer_sheet_id = ans.id
JOIN users u ON ans.user_id = u.id
JOIN packages p ON ans.package_id = p.id
JOIN sub_topics st ON sts.sub_topic_id = st.id
GROUP BY u.id, p.id, st.id
ORDER BY u.name, p.title, st.name;

-- Get statistics for a specific package
SELECT 
    st.name as sub_topic_name,
    COUNT(DISTINCT sts.answer_sheet_id) as total_attempts,
    AVG(sts.total_score) as avg_score,
    MIN(sts.total_score) as min_score,
    MAX(sts.total_score) as max_score,
    SUM(CASE WHEN sts.is_passed THEN 1 ELSE 0 END) as passed_count,
    ROUND(SUM(CASE WHEN sts.is_passed THEN 1 ELSE 0 END) / COUNT(DISTINCT sts.answer_sheet_id) * 100, 2) as pass_rate
FROM sub_topic_scores sts
JOIN answer_sheets ans ON sts.answer_sheet_id = ans.id
JOIN sub_topics st ON sts.sub_topic_id = st.id
WHERE ans.package_id = '{package_id}'
GROUP BY st.id, st.name
ORDER BY st.name;
