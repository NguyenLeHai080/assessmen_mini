<?php
namespace MiniAssessment\API;

use MiniAssessment\Database\Answer_DB;
use MiniAssessment\Database\Assessment_DB;
use MiniAssessment\Database\Question_DB;
use WP_Error;
use WP_REST_Server;

class Answer_API extends REST_Base {
    private $questions;
    private $answers;
    private $assessments;

    public function __construct() {
        $this->questions = new Question_DB();
        $this->answers = new Answer_DB();
        $this->assessments = new Assessment_DB();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/questions/(?P<id>\d+)/answers', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_answers_by_question'],
                'permission_callback' => '__return_true',
            ],
        ]);
        register_rest_route($this->namespace, '/answers', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'check_admin_permission'],
            ],
        ]);
    }

    public function get_answers_by_question($request) {
        $question_id = (int) $request['id'];
        $question = $this->questions->find($question_id);
        if (!$question) {
            return $this->not_found('Khong tim thay cau hoi.');
        }
        $can_manage = is_user_logged_in() && current_user_can('edit_posts');
        if (!$this->assessments->find((int) $question['assessment_id'], !$can_manage)) {
            return $this->not_found('Khong tim thay cau hoi.');
        }
        return $this->success_response($this->answers->all_by_question($question_id));
    }

    public function create_item($request) {
        $question_id = (int) $request->get_param('question_id');
        $content = sanitize_text_field($request->get_param('content'));
        $score = (int) ($request->get_param('score') ?: 0);
        $sort_order = max(0, (int) ($request->get_param('sort_order') ?: 0));

        if (!$question_id || $content === '') {
            return $this->invalid('Du lieu dap an khong hop le.');
        }
        if (!$this->questions->find($question_id)) {
            return $this->not_found('Khong tim thay cau hoi cha.');
        }

        $now = current_time('mysql');
        $item = $this->answers->create([
            'question_id' => $question_id,
            'content' => $content,
            'score' => $score,
            'sort_order' => $sort_order,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $item
            ? $this->success_response($item, 201)
            : new WP_Error('db_error', 'Khong the tao dap an.', ['status' => 500]);
    }
}
