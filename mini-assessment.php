<?php
/**
 * Plugin Name: Mini Assessment Plugin
 * Description: Assessment management module for WordPress with REST API and React admin UI.
 * Version: 1.0.0
 * Author: Project Team
 * Text Domain: mini-assessment
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MINI_ASSESSMENT_VERSION', '1.0.0');
define('MINI_ASSESSMENT_PATH', plugin_dir_path(__FILE__));
define('MINI_ASSESSMENT_URL', plugin_dir_url(__FILE__));

require_once MINI_ASSESSMENT_PATH . 'backend/Database/class-activator.php';
require_once MINI_ASSESSMENT_PATH . 'backend/Database/class-assessment-db.php';
require_once MINI_ASSESSMENT_PATH . 'backend/Database/class-question-db.php';
require_once MINI_ASSESSMENT_PATH . 'backend/Database/class-answer-db.php';
require_once MINI_ASSESSMENT_PATH . 'backend/API/class-rest-base.php';
require_once MINI_ASSESSMENT_PATH . 'backend/API/class-assessment-api.php';
require_once MINI_ASSESSMENT_PATH . 'backend/API/class-question-api.php';
require_once MINI_ASSESSMENT_PATH . 'backend/API/class-answer-api.php';
require_once MINI_ASSESSMENT_PATH . 'backend/Admin/class-admin-page.php';

register_activation_hook(__FILE__, ['MiniAssessment\\Database\\Activator', 'activate']);
register_deactivation_hook(__FILE__, ['MiniAssessment\\Database\\Activator', 'deactivate']);

add_action('rest_api_init', function () {
    (new MiniAssessment\API\Assessment_API())->register_routes();
    (new MiniAssessment\API\Question_API())->register_routes();
    (new MiniAssessment\API\Answer_API())->register_routes();
});

add_action('plugins_loaded', function () {
    if (is_admin()) {
        new MiniAssessment\Admin\Admin_Page();
    }
});
