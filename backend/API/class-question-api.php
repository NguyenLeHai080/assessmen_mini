<?php
namespace MiniAssessment\API;

use MiniAssessment\Database\Assessment_DB;
use MiniAssessment\Database\Answer_DB;
use MiniAssessment\Database\Question_DB;
use WP_Error;
use WP_REST_Server;

class Question_API extends REST_Base {
    private $assessments;
    private $questions;
    private $answers;

    public function __construct() {
        $this->assessments = new Assessment_DB();
        $this->questions = new Question_DB();
        $this->answers = new Answer_DB();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/assessments/(?P<id>\d+)/questions', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_questions_by_assessment'],
                'permission_callback' => '__return_true',
            ],
        ]);
        register_rest_route($this->namespace, '/questions', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'check_admin_permission'],
            ],
        ]);
    }

    public function get_questions_by_assessment($request) {
        $assessment_id = (int) $request['id'];
        $can_manage = is_user_logged_in() && current_user_can('edit_posts');
        $assessment = $this->assessments->find($assessment_id, !$can_manage);
        if (!$assessment) {
            return $this->not_found('Khong tim thay bai danh gia.');
        }

        $questions = $this->questions->all_by_assessment($assessment_id, !$can_manage);
        foreach ($questions as &$question) {
            $question['answers'] = $this->answers->all_by_question((int) $question['id']);
        }

        return $this->success_response($questions);
    }

    public function create_item($request) {
        $assessment_id = (int) $request->get_param('assessment_id');
        $content = sanitize_textarea_field($request->get_param('content'));
        $sort_order = max(0, (int) ($request->get_param('sort_order') ?: 0));

        if (!$assessment_id || $content === '') {
            return $this->invalid('Du lieu cau hoi khong hop le.');
        }
        if (!$this->assessments->find($assessment_id)) {
            return $this->not_found('Khong tim thay bai danh gia cha.');
        }

        $now = current_time('mysql');
        $item = $this->questions->create([
            'assessment_id' => $assessment_id,
            'content' => $content,
            'sort_order' => $sort_order,
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $item
            ? $this->success_response($item, 201)
            : new WP_Error('db_error', 'Khong the tao cau hoi.', ['status' => 500]);
    }
}
