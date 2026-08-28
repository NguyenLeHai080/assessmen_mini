<?php
namespace MiniAssessment\Database;

class Activator {
    const DB_VERSION = '1.1.0';

    public static function activate() {
        self::create_tables();
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    private static function create_tables() {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset_collate = $wpdb->get_charset_collate();
        $assessment_table = $wpdb->prefix . 'assessment';
        $question_table = $wpdb->prefix . 'assessment_questions';
        $answer_table = $wpdb->prefix . 'assessment_answers';
        $attempt_table = $wpdb->prefix . 'assessment_attempts';
        $attempt_answer_table = $wpdb->prefix . 'assessment_attempt_answers';

        $sql_assessments = "CREATE TABLE $assessment_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text NULL,
            status varchar(20) NOT NULL DEFAULT 'draft',
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY status (status)
        ) $charset_collate;";

        $sql_questions = "CREATE TABLE $question_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            assessment_id bigint(20) unsigned NOT NULL,
            content text NOT NULL,
            sort_order int(11) NOT NULL DEFAULT 0,
            status varchar(20) NOT NULL DEFAULT 'active',
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY assessment_id (assessment_id),
            KEY assessment_sort_order (assessment_id, sort_order)
        ) $charset_collate;";

        $sql_answers = "CREATE TABLE $answer_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            question_id bigint(20) unsigned NOT NULL,
            content text NOT NULL,
            score int(11) NOT NULL DEFAULT 0,
            sort_order int(11) NOT NULL DEFAULT 0,
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY question_id (question_id),
            KEY question_sort_order (question_id, sort_order)
        ) $charset_collate;";

        $sql_attempts = "CREATE TABLE $attempt_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            assessment_id bigint(20) unsigned NOT NULL,
            score int(11) NOT NULL DEFAULT 0,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY assessment_id (assessment_id)
        ) $charset_collate;";

        $sql_attempt_answers = "CREATE TABLE $attempt_answer_table (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            attempt_id bigint(20) unsigned NOT NULL,
            question_id bigint(20) unsigned NOT NULL,
            answer_id bigint(20) unsigned NOT NULL,
            score int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY  (id),
            KEY attempt_id (attempt_id),
            KEY question_id (question_id)
        ) $charset_collate;";

        dbDelta($sql_assessments);
        dbDelta($sql_questions);
        dbDelta($sql_answers);
        dbDelta($sql_attempts);
        dbDelta($sql_attempt_answers);
        update_option('mini_assessment_db_version', self::DB_VERSION);
    }

}
