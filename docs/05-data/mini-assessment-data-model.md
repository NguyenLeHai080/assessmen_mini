# Mini Assessment - Data Model

Status: Approved
Owner: Backend
Reviewers: Tech Lead, QA
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-business-rules.md, ../03-architecture/mini-assessment-architecture.md

Table names use the active WordPress prefix, for example `wp_assessment` on a
default installation.

## Tables

### `{prefix}assessment`

| Column | Type | Rule |
| --- | --- | --- |
| id | bigint unsigned | Primary key, auto increment |
| title | varchar(255) | Required |
| description | text | Optional |
| status | varchar(20) | `draft/published/archived` |
| created_at | datetime | Required |
| updated_at | datetime | Required |

### `{prefix}assessment_questions`

| Column | Type | Rule |
| --- | --- | --- |
| id | bigint unsigned | Primary key, auto increment |
| assessment_id | bigint unsigned | Parent assessment required |
| content | text | Required |
| sort_order | int | Non-negative display order |
| status | varchar(20) | Defaults `active` |
| created_at/updated_at | datetime | Required |

### `{prefix}assessment_answers`

| Column | Type | Rule |
| --- | --- | --- |
| id | bigint unsigned | Primary key, auto increment |
| question_id | bigint unsigned | Parent question required |
| content | text | Required |
| score | int | Defaults 0 |
| sort_order | int | Non-negative display order |
| created_at/updated_at | datetime | Required |

## Integrity and lifecycle

- Application layer validates parent existence before insert.
- Assessment delete removes answers, then questions, then assessment.
- `dbDelta()` owns schema creation/update; DB version is stored in
  `mini_assessment_db_version`.
- Seed is idempotent and only runs when the assessment table is empty.
- No production PII or credentials belong in seed data or repository.
