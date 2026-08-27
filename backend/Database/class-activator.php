<?php
namespace MiniAssessment\Database;

class Activator {
    const DB_VERSION = '1.0.0';

    public static function activate() {
        self::create_tables();
        self::seed_dummy_data();
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
            KEY sort_order (sort_order)
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
            KEY sort_order (sort_order)
        ) $charset_collate;";

        dbDelta($sql_assessments);
        dbDelta($sql_questions);
        dbDelta($sql_answers);
        update_option('mini_assessment_db_version', self::DB_VERSION);
    }

    private static function seed_dummy_data() {
        global $wpdb;

        $assessment_table = $wpdb->prefix . 'assessment';
        $question_table = $wpdb->prefix . 'assessment_questions';
        $answer_table = $wpdb->prefix . 'assessment_answers';

        $count = (int) $wpdb->get_var("SELECT COUNT(*) FROM $assessment_table");
        if ($count > 0) {
            return;
        }

        $now = current_time('mysql');
        $wpdb->insert($assessment_table, [
            'title' => 'Bai danh gia nang luc WordPress va React',
            'description' => 'Kiem tra kien thuc ve plugin WordPress, custom database, REST API va React SPA.',
            'status' => 'published',
            'created_at' => $now,
            'updated_at' => $now,
        ], ['%s', '%s', '%s', '%s', '%s']);

        $assessment_id = (int) $wpdb->insert_id;
        if (!$assessment_id) {
            return;
        }

        $questions = [
            [
                'content' => 'Ham nao dung de tao va cap nhat custom table theo chuan WordPress?',
                'answers' => [
                    ['content' => 'dbDelta()', 'score' => 10],
                    ['content' => 'wp_create_table()', 'score' => 0],
                    ['content' => '$wpdb->query() truc tiep', 'score' => 0],
                ],
            ],
            [
                'content' => 'Namespace REST API cua module nay la gi?',
                'answers' => [
                    ['content' => 'assessment/v1', 'score' => 10],
                    ['content' => 'wp/v2/assessment', 'score' => 0],
                ],
            ],
        ];

        foreach ($questions as $question_index => $question) {
            $wpdb->insert($question_table, [
                'assessment_id' => $assessment_id,
                'content' => $question['content'],
                'sort_order' => $question_index + 1,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ], ['%d', '%s', '%d', '%s', '%s', '%s']);

            $question_id = (int) $wpdb->insert_id;
            if (!$question_id) {
                continue;
            }

            foreach ($question['answers'] as $answer_index => $answer) {
                $wpdb->insert($answer_table, [
                    'question_id' => $question_id,
                    'content' => $answer['content'],
                    'score' => $answer['score'],
                    'sort_order' => $answer_index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], ['%d', '%s', '%d', '%d', '%s', '%s']);
            }
        }
    }
}
