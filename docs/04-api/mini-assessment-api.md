# Mini Assessment - REST API Contract

Status: Approved
Owner: Backend
Reviewers: Frontend, QA, Security
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-business-rules.md, ../02-requirements/mini-assessment-requirements.md

Base URL: `/wp-json/assessment/v1`

## Authentication and permissions

- `GET` list/detail/questions/answers: public reads are allowed, but public data
  is filtered to `published` assessments.
- `POST`, `POST /assessments/{id}`, `DELETE`: require logged-in user with
  `edit_posts` capability and header `X-WP-Nonce` from `wp_create_nonce('wp_rest')`.
- 401 means no login; 403 means insufficient capability.

## Endpoints

| Method | Path | Purpose | Success |
| --- | --- | --- | --- |
| GET | `/assessments?page=1&per_page=10` | List assessments with pagination | 200 |
| POST | `/assessments` | Create assessment | 201 |
| GET | `/assessments/{id}` | Read one assessment | 200/404 |
| POST | `/assessments/{id}` | Update title/description/status | 200/404 |
| DELETE | `/assessments/{id}` | Delete assessment and children | 200/404 |
| GET | `/assessments/{id}/questions` | Read nested questions/answers | 200/404 |
| POST | `/questions` | Create question under assessment | 201 |
| GET | `/questions/{id}/answers` | Read answers for question | 200/404 |
| POST | `/answers` | Create answer under question | 201 |

## Response envelope

Success:

```json
{
  "success": true,
  "data": {}
}
```

List `data` contains `items` and `pagination` (`total`, `page`, `per_page`,
`total_pages`). Error responses use WordPress `code`, `message` and `data.status`.

## Validation

- Assessment title is required; status is `draft`, `published` or `archived`.
- Question/answer content and parent IDs are required.
- `sort_order` is normalized to a non-negative integer.
- Unknown parent returns 404; invalid payload returns 422.

## Runtime URL rule

The admin page injects `rest_url('assessment/v1')`; frontend must never contain a
fixed hostname or `/wp-json` path for a specific environment.
