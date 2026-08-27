# Mini Assessment - Test Plan

Status: Approved
Owner: QA
Reviewers: Developer, Reviewer/Lead
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-business-requirements.md, ../04-api/mini-assessment-api.md

## Clean WordPress smoke test

1. Install a blank WordPress 5.8+ / PHP 7.4+ site.
2. Upload `mini-assessment.zip`, activate plugin and confirm no WSOD/fatal error.
3. Verify `{prefix}assessment`, `{prefix}assessment_questions` and
   `{prefix}assessment_answers` exist.
4. Verify one seeded assessment, two questions and five answers.
5. Open `Mini Assessment`; confirm bundle loads and list/detail render.
6. Repeat deactivate/activate; confirm seed is not duplicated.

## API scenarios

| ID | Scenario | Expected |
| --- | --- | --- |
| TC-001 | Public GET assessments | 200; published only; pagination present |
| TC-002 | Public GET draft detail | 404/not exposed |
| TC-003 | Anonymous POST assessment | 401; no DB write |
| TC-004 | Logged-in user without capability | 403; no DB write |
| TC-005 | Admin creates valid assessment | 201; returned record |
| TC-006 | Missing title/parent/content | 422 |
| TC-007 | Create question + answer | 201; nested in detail |
| TC-008 | Delete assessment | Children removed; no orphan rows |

## Packaging scenarios

- `npm run build` creates `dist/bundle.js` and `dist/bundle.css`.
- Build script creates ZIP containing only entry point, `backend/`, `dist/` and
  `README.md`; no `node_modules`, secrets or source-only files are required.
- Install ZIP on a second clean site without Node.js/npm.
