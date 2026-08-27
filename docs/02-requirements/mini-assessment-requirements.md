# Mini Assessment - System Requirements

Status: Approved
Owner: Tech Lead
Reviewers: Product/BA, QA
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-business-requirements.md, ../traceability.md

## Functional requirements

| ID | Requirement | Priority | Verification |
| --- | --- | --- | --- |
| FR-001 | Activate plugin without fatal error and refresh rewrite rules | Must | TC-001 |
| FR-002 | Create three prefixed custom tables and persist DB version | Must | TC-002 |
| FR-003 | Seed one assessment with questions/answers only when empty | Must | TC-003 |
| FR-004 | Public list/detail reads only published assessments | Must | TC-004 |
| FR-005 | Authenticated user with `edit_posts` can create/update/delete assessment | Must | TC-005 |
| FR-006 | Authorized user can create question under existing assessment | Must | TC-006 |
| FR-007 | Authorized user can create answer under existing question | Must | TC-007 |
| FR-008 | Detail response embeds questions and answers in stable order | Must | TC-008 |
| FR-009 | Admin UI loads runtime API URL and WordPress nonce | Must | TC-009 |
| FR-010 | Build script creates installable ZIP with compiled assets | Must | TC-010 |

## Non-functional requirements

| ID | Requirement | Target |
| --- | --- | --- |
| NFR-001 | Minimum runtime compatibility | WordPress 5.8+, PHP 7.4+ |
| NFR-002 | Environment neutrality | No hardcoded localhost/site URL/token in bundle |
| NFR-003 | Security | Capability and nonce checks on mutations; no secret in repo |
| NFR-004 | Error handling | 401/403/404/422/500 semantics and actionable message |
| NFR-005 | Handoff | Reviewer can install ZIP without Node.js/npm |
| NFR-006 | Data integrity | No orphan child after assessment deletion |
