# Mini Assessment - Architecture

Status: Approved
Owner: Tech Lead
Reviewers: Developer, QA, Security
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-business-requirements.md, ../04-api/mini-assessment-api.md, ../05-data/mini-assessment-data-model.md

## Runtime topology

```text
WordPress Admin
      |
      v
React SPA (dist/bundle.js + bundle.css)
      | runtime apiUrl + X-WP-Nonce
      v
WordPress REST API (assessment/v1)
      |
      v
DB repositories -> {$wpdb->prefix}assessment*
```

Source is separated from runtime assets: `frontend/` is build-time React source,
`dist/` is the handoff artifact loaded by WordPress, and `backend/` contains PHP
activation, persistence, API and admin integration.

## Module responsibilities

- `mini-assessment.php`: constants, file loading and WordPress hooks.
- `Database/Activator`: dbDelta schema migration and rewrite refresh.
- `Database/*_DB`: query/persistence boundary per aggregate.
- `API/REST_Base`: response helpers and capability guard.
- `API/*_API`: REST route registration, validation and orchestration.
- `Admin/Admin_Page`: menu, assets and runtime configuration injection.
- `frontend/src`: list/detail/forms and API client error normalization.

## Key decisions

- Custom tables use the active WordPress prefix; no fixed `wp_` assumption.
- No foreign key constraints are required; application-layer cascade delete keeps
  compatibility with common WordPress hosting and explicitly removes children.
- Public reads filter `published`; admin reads require login for non-public data.
- Mutations require `edit_posts` and WordPress REST nonce from the admin runtime.
