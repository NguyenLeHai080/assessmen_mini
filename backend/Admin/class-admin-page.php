<?php
namespace MiniAssessment\Admin;

class Admin_Page {
    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('mini_assessment', [$this, 'render_shortcode']);
    }

    public function register_menu() {
        add_menu_page(
            'Mini Assessment',
            'Mini Assessment',
            'edit_posts',
            'mini-assessment',
            [$this, 'render_app'],
            'dashicons-clipboard',
            25
        );
    }

    public function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_mini-assessment') {
            return;
        }

        $this->enqueue_app_assets();
    }

    public function render_shortcode() {
        $this->enqueue_app_assets();
        return '<div id="mini-assessment-root"></div>';
    }

    private function enqueue_app_assets() {

        $js_file = MINI_ASSESSMENT_PATH . 'dist/bundle.js';
        $css_file = MINI_ASSESSMENT_PATH . 'dist/bundle.css';

        if (!file_exists($js_file)) {
            return;
        }

        wp_enqueue_script(
            'mini-assessment-react',
            MINI_ASSESSMENT_URL . 'dist/bundle.js',
            [],
            filemtime($js_file),
            true
        );

        if (file_exists($css_file)) {
            wp_enqueue_style(
                'mini-assessment-style',
                MINI_ASSESSMENT_URL . 'dist/bundle.css',
                [],
                filemtime($css_file)
            );
        }

        wp_localize_script('mini-assessment-react', 'miniAssessmentConfig', [
            // WordPress resolves the correct host and subdirectory for this installation.
            'apiUrl' => esc_url_raw(rest_url('assessment/v1')),
            'nonce' => wp_create_nonce('wp_rest'),
            'isLoggedIn' => is_user_logged_in(),
            'canManage' => current_user_can('edit_posts'),
            'siteUrl' => get_site_url(),
        ]);
    }

    public function render_app() {
        echo '<div class="wrap"><div id="mini-assessment-root"></div></div>';
    }
}
