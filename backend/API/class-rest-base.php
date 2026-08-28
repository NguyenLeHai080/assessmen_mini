<?php
namespace MiniAssessment\API;

use WP_Error;
use WP_REST_Response;

abstract class REST_Base {
    protected $namespace = 'assessment/v1';

    public function check_admin_permission() {
        // Some local Apache/FastCGI setups strip Authorization before PHP sees it.
        // Re-authenticate from the raw header so Postman Application Passwords work.
        if (!is_user_logged_in()) {
            $header = '';
            foreach (['HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION'] as $key) {
                if (!empty($_SERVER[$key])) {
                    $header = $_SERVER[$key];
                    break;
                }
            }
            if (!$header && function_exists('getallheaders')) {
                $headers = getallheaders();
                $header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            }
            if ($header && stripos($header, 'basic ') === 0) {
                $decoded = base64_decode(trim(substr($header, 6)), true);
                if ($decoded && strpos($decoded, ':') !== false) {
                    [$username, $password] = explode(':', $decoded, 2);
                    $user = wp_authenticate_application_password(null, $username, $password);
                    if (!is_wp_error($user)) {
                        wp_set_current_user($user->ID);
                    }
                }
            }
        }

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
