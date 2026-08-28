<?php
namespace MiniAssessment\Database;

class Assessment_DB {
    private $wpdb;
    private $table;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'assessment';
    }

    public function count($public_only = false) {
        $where = $public_only ? " WHERE status = 'published'" : '';
        return (int) $this->wpdb->get_var("SELECT COUNT(*) FROM {$this->table}{$where}");
    }

    public function all($page, $per_page, $public_only = false) {
        $offset = ($page - 1) * $per_page;
        $where = $public_only ? " WHERE status = 'published'" : '';
        return $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->table}{$where} ORDER BY id DESC LIMIT %d OFFSET %d",
                $per_page,
                $offset
            ),
            ARRAY_A
        );
    }

    public function find($id, $public_only = false) {
        $where = $public_only ? " AND status = 'published'" : '';
        return $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT * FROM {$this->table} WHERE id = %d{$where}", $id),
            ARRAY_A
        );
    }

    public function create($data) {
        $this->wpdb->insert($this->table, $data, ['%s', '%s', '%s', '%s', '%s']);
        return $this->find((int) $this->wpdb->insert_id);
    }

    public function update($id, $data) {
        $this->wpdb->update($this->table, $data, ['id' => $id]);
        return $this->find($id);
    }

    public function delete_with_children($id) {
        $submission_db = new Submission_DB();
        $question_table = $this->wpdb->prefix . 'assessment_questions';
        $answer_table = $this->wpdb->prefix . 'assessment_answers';
        $question_ids = $this->wpdb->get_col($this->wpdb->prepare(
            "SELECT id FROM $question_table WHERE assessment_id = %d",
            $id
        ));

        if ($question_ids) {
            $placeholders = implode(',', array_fill(0, count($question_ids), '%d'));
            $this->wpdb->query($this->wpdb->prepare(
                "DELETE FROM $answer_table WHERE question_id IN ($placeholders)",
                $question_ids
            ));
        }

        if (!$submission_db->delete_by_assessment($id)) {
            return false;
        }

        $this->wpdb->delete($question_table, ['assessment_id' => $id], ['%d']);
        return (bool) $this->wpdb->delete($this->table, ['id' => $id], ['%d']);
    }
}
