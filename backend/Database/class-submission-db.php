<?php
namespace MiniAssessment\Database;

class Submission_DB {
    private $wpdb;
    private $attempts;
    private $answers;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->attempts = $wpdb->prefix . 'assessment_attempts';
        $this->answers = $wpdb->prefix . 'assessment_attempt_answers';
    }

    public function create($assessment_id, array $answers) {
        $now = current_time('mysql');
        $score = array_sum(wp_list_pluck($answers, 'score'));
        $inserted = $this->wpdb->insert($this->attempts, [
            'assessment_id' => $assessment_id,
            'score' => $score,
            'created_at' => $now,
        ], ['%d', '%d', '%s']);
        if (!$inserted) {
            return false;
        }

        $attempt_id = (int) $this->wpdb->insert_id;
        foreach ($answers as $answer) {
            $inserted = $this->wpdb->insert($this->answers, [
                'attempt_id' => $attempt_id,
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
                'score' => $answer['score'],
            ], ['%d', '%d', '%d', '%d']);
            if (!$inserted) {
                $this->wpdb->delete($this->answers, ['attempt_id' => $attempt_id], ['%d']);
                $this->wpdb->delete($this->attempts, ['id' => $attempt_id], ['%d']);
                return false;
            }
        }

        return ['id' => $attempt_id, 'assessment_id' => $assessment_id, 'score' => $score];
    }

    public function delete_by_assessment($assessment_id) {
        $attempt_ids = $this->wpdb->get_col($this->wpdb->prepare(
            "SELECT id FROM {$this->attempts} WHERE assessment_id = %d",
            $assessment_id
        ));

        if ($attempt_ids) {
            $placeholders = implode(',', array_fill(0, count($attempt_ids), '%d'));
            $this->wpdb->query($this->wpdb->prepare(
                "DELETE FROM {$this->answers} WHERE attempt_id IN ($placeholders)",
                $attempt_ids
            ));
        }

        return $this->wpdb->delete($this->attempts, ['assessment_id' => $assessment_id], ['%d']) !== false;
    }
}
