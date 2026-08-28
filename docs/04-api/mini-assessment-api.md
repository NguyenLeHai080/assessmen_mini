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
- `POST`, `PUT/PATCH /assessments/{id}`, `DELETE`, `POST /questions`, and
  `POST /answers`: require a user with `edit_posts`. WordPress admin uses
  `X-WP-Nonce`; API clients such as Postman may use Basic Auth with a WordPress
  Application Password.
- 401 means no login; 403 means insufficient capability.

## Endpoints

| Method | Path | Purpose | Success |
| --- | --- | --- | --- |
| GET | `/assessments?page=1&per_page=10` | List assessments with pagination | 200 |
| POST | `/assessments` | Create assessment | 201 |
| GET | `/assessments/{id}` | Read one assessment | 200/404 |
| PUT/PATCH | `/assessments/{id}` | Update title/description/status | 200/404/422 |
| DELETE | `/assessments/{id}` | Delete assessment and children | 200/404 |
| GET | `/assessments/{id}/questions` | Read nested questions/answers | 200/404 |
| POST | `/questions` | Create question under assessment | 201 |
| GET | `/questions/{id}/answers` | Read answers for question | 200/404 |
| POST | `/answers` | Create answer under question | 201 |
| POST | `/assessments/{id}/submissions` | Submit selected public answers | 201 |

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
- Submission accepts `answers`, an array of `{question_id, answer_id}`. Each
  pair must belong to the published assessment in the URL, and every active
  question must be answered exactly once.
- `sort_order` is normalized to a non-negative integer.
- Unknown parent returns 404; invalid payload returns 422.

## Runtime URL rule

The admin page injects a WordPress-generated REST URL; frontend must never
contain a fixed hostname. On servers without pretty permalink support, use
`/?rest_route=/assessment/v1/...`.
