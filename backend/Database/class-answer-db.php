<?php
namespace MiniAssessment\Database;

class Answer_DB {
    private $wpdb;
    private $table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'assessment_answers';
    }

    public function all_by_question($question_id) {
        return $this->wpdb->get_results($this->wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE question_id = %d ORDER BY sort_order ASC, id ASC",
            $question_id
        ), ARRAY_A);
    }

    public function find($id) {
        return $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $id
        ), ARRAY_A);
    }

    public function create($data) {
        $this->wpdb->insert($this->table, $data, ['%d', '%s', '%d', '%d', '%s', '%s']);
        $id = (int) $this->wpdb->insert_id;
        return $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $id
        ), ARRAY_A);
    }
}
