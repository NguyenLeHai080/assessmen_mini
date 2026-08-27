# API-000: Endpoint title

Status: Draft
Owner: TBD
Reviewers: TBD
Last updated: YYYY-MM-DD
Related issues: #000
Related docs: FR-000, DATA-000, TC-000

## Purpose

Mo ta business purpose va consumer cua endpoint.

## Contract

```text
METHOD /api/v1/resource/{id}
```

- Authentication:
- Required role/scope:
- Idempotency:
- Rate limit:
- Timeout/retry:

## Parameters

| Location | Name | Type | Required | Validation | Description |
| --- | --- | --- | --- | --- | --- |
| path | id | string | yes | TBD | TBD |

## Request example

```json
{}
```

## Success response

```json
{}
```

## Error responses

| HTTP | Error code | Condition | Client action |
| --- | --- | --- | --- |
| 400 | VALIDATION_ERROR | Invalid input | Fix request |

## Compatibility and rollout

- Breaking change:
- Deprecation/version plan:
- Feature flag/rollout:
- Monitoring:

## Test scenarios

- Happy path:
- Permission failure:
- Validation failure:
- Dependency failure/retry:
