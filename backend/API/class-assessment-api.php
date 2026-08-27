<?php
namespace MiniAssessment\API;

use MiniAssessment\Database\Assessment_DB;
use WP_Error;
use WP_REST_Server;

class Assessment_API extends REST_Base {
    private $assessments;

    public function __construct() {
        $this->assessments = new Assessment_DB();
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/assessments', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'permission_callback' => '__return_true',
                'args' => [
                    'page' => ['default' => 1, 'sanitize_callback' => 'absint'],
                    'per_page' => ['default' => 10, 'sanitize_callback' => 'absint'],
                ],
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'check_admin_permission'],
            ],
        ]);

        register_rest_route($this->namespace, '/assessments/(?P<id>\d+)', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_item'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_item'],
                'permission_callback' => [$this, 'check_admin_permission'],
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_item'],
                'permission_callback' => [$this, 'check_admin_permission'],
            ],
        ]);
    }

    public function get_items($request) {
        $page = max(1, (int) $request->get_param('page'));
        $per_page = min(100, max(1, (int) ($request->get_param('per_page') ?: 10)));
        $public_only = !(is_user_logged_in() && current_user_can('edit_posts'));
        $total = $this->assessments->count($public_only);

        return $this->success_response([
            'items' => $this->assessments->all($page, $per_page, $public_only),
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $per_page,
                'total_pages' => $total ? (int) ceil($total / $per_page) : 0,
            ],
        ]);
    }

    public function create_item($request) {
        $title = sanitize_text_field($request->get_param('title'));
        $description = sanitize_textarea_field($request->get_param('description'));
        $status = sanitize_key($request->get_param('status') ?: 'draft');

        if ($title === '') {
            return $this->invalid('Tieu de khong duoc de trong.');
        }

        if (!in_array($status, ['draft', 'published', 'archived'], true)) {
            $status = 'draft';
        }

        $item = $this->assessments->create([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql'),
        ]);

        if (!$item) {
            return new WP_Error('db_error', 'Khong the tao bai danh gia.', ['status' => 500]);
        }

        return $this->success_response($item, 201);
    }

    public function get_item($request) {
        $id = (int) $request['id'];
        $item = $this->assessments->find($id, !(is_user_logged_in() && current_user_can('edit_posts')));
        return $item ? $this->success_response($item) : $this->not_found('Khong tim thay bai danh gia.');
    }

    public function update_item($request) {
        $id = (int) $request['id'];
        if (!$this->assessments->find($id)) {
            return $this->not_found('Khong tim thay bai danh gia.');
        }

        $data = ['updated_at' => current_time('mysql')];
        if ($request->get_param('title') !== null) {
            $title = sanitize_text_field($request->get_param('title'));
            if ($title === '') {
                return $this->invalid('Tieu de khong duoc de trong.');
            }
            $data['title'] = $title;
        }
        if ($request->get_param('description') !== null) {
            $data['description'] = sanitize_textarea_field($request->get_param('description'));
        }
        if ($request->get_param('status') !== null) {
            $status = sanitize_key($request->get_param('status'));
            if (!in_array($status, ['draft', 'published', 'archived'], true)) {
                return $this->invalid('Trang thai khong hop le.');
            }
            $data['status'] = $status;
        }

        return $this->success_response($this->assessments->update($id, $data));
    }

    public function delete_item($request) {
        $id = (int) $request['id'];
        if (!$this->assessments->find($id)) {
            return $this->not_found('Khong tim thay bai danh gia.');
        }

        if (!$this->assessments->delete_with_children($id)) {
            return new WP_Error('db_error', 'Khong the xoa bai danh gia.', ['status' => 500]);
        }

        return $this->success_response(['message' => 'Da xoa bai danh gia thanh cong.']);
    }
}
