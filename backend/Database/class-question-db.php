<?php
namespace MiniAssessment\Database;

class Question_DB {
    private $wpdb;
    private $table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'assessment_questions';
    }

    public function find($id) {
        return $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $id
        ), ARRAY_A);
    }

    public function all_by_assessment($assessment_id, $public_only = false) {
        $where = $public_only ? " AND status = 'active'" : '';
        return $this->wpdb->get_results($this->wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE assessment_id = %d{$where} ORDER BY sort_order ASC, id ASC",
            $assessment_id
        ), ARRAY_A);
    }

    public function create($data) {
        $this->wpdb->insert($this->table, $data, ['%d', '%s', '%d', '%s', '%s', '%s']);
        return $this->find((int) $this->wpdb->insert_id);
    }
}
