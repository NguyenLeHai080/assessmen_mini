<?php
namespace MiniAssessment\API;

use WP_Error;
use WP_REST_Response;

abstract class REST_Base {
    protected $namespace = 'assessment/v1';

    public function check_admin_permission() {
        if (!is_user_logged_in()) {
            return new WP_Error('rest_forbidden', 'Ban can dang nhap de thuc hien thao tac nay.', ['status' => 401]);
        }

        if (!current_user_can('edit_posts')) {
            return new WP_Error('rest_forbidden', 'Ban khong co quyen thuc hien thao tac nay.', ['status' => 403]);
        }

        return true;
    }

    protected function success_response($data, $status = 200) {
        return new WP_REST_Response(['success' => true, 'data' => $data], $status);
    }

    protected function invalid($message) {
        return new WP_Error('invalid_data', $message, ['status' => 422]);
    }

    protected function not_found($message) {
        return new WP_Error('not_found', $message, ['status' => 404]);
    }
}
