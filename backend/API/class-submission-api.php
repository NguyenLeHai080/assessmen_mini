<?php
namespace MiniAssessment\API;

use MiniAssessment\Database\Answer_DB;
use MiniAssessment\Database\Assessment_DB;
use MiniAssessment\Database\Question_DB;
use MiniAssessment\Database\Submission_DB;
use MiniAssessment\Support\Logger;
use WP_Error;
use WP_REST_Server;

class Submission_API extends REST_Base {
    private $assessments;
    private $questions;
    private $answers;
    private $submissions;

    public function __construct() {
        $this->assessments = new Assessment_DB();
        $this->questions = new Question_DB();
        $this->answers = new Answer_DB();
        $this->submissions = new Submission_DB();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/assessments/(?P<id>\d+)/submissions', [[
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'create_item'],
            'permission_callback' => '__return_true',
        ]]);
    }

    public function create_item($request) {
        $assessment_id = (int) $request['id'];
        if (!$this->assessments->find($assessment_id, true)) {
            return $this->not_found('Khong tim thay bai danh gia da cong bo.');
        }

        $selections = $request->get_param('answers');
        if (!is_array($selections) || !$selections) {
            return $this->invalid('Can chon it nhat mot dap an.');
        }

        $validated = [];
        foreach ($selections as $selection) {
            $question_id = isset($selection['question_id']) ? (int) $selection['question_id'] : 0;
            $answer_id = isset($selection['answer_id']) ? (int) $selection['answer_id'] : 0;
            $question = $this->questions->find($question_id);
            if (!$question || (int) $question['assessment_id'] !== $assessment_id) {
                return $this->invalid('Cau hoi khong thuoc bai danh gia.');
            }
            $answer = $this->answers->find($answer_id);
            if (!$answer || (int) $answer['question_id'] !== $question_id) {
                return $this->invalid('Dap an khong hop le.');
            }
            $validated[$question_id] = [
                'question_id' => $question_id,
                'answer_id' => $answer_id,
                'score' => (int) $answer['score'],
            ];
        }

        $active_questions = $this->questions->all_by_assessment($assessment_id, true);
        if (count($validated) !== count($active_questions)) {
            return $this->invalid('Can tra loi day du tat ca cau hoi dang hoat dong.');
        }
        foreach ($active_questions as $question) {
            if (!isset($validated[(int) $question['id']])) {
                return $this->invalid('Can tra loi day du tat ca cau hoi dang hoat dong.');
            }
        }

        $item = $this->submissions->create($assessment_id, array_values($validated));
        if (!$item) {
            Logger::error('Unable to persist submission.', ['assessment_id' => $assessment_id]);
            return new WP_Error('db_error', 'Khong the luu cau tra loi.', ['status' => 500]);
        }

        return $this->success_response($item, 201);
    }
}
