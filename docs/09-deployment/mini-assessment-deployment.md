# Mini Assessment - Deployment and Handoff

Status: Approved
Owner: Developer/Ops
Reviewers: QA, Reviewer/Lead
Last updated: 2026-08-27
Related issues: #9
Related docs: ../01-business/mini-assessment-process.md, ../07-testing/mini-assessment-test-plan.md

## Build from source

```powershell
cd frontend
npm install
npm run build
```

For a complete handoff on a Bash-capable machine:

```bash
./scripts/build-zip.sh
```

On Windows PowerShell, use:

```powershell
.\scripts\build-zip.ps1
```

The resulting `mini-assessment.zip` contains `mini-assessment.php`, `backend/`,
`dist/` and `README.md`. Node/npm is needed only at build time, not on the
WordPress runtime.

## Install and verify

1. Upload ZIP through WordPress Plugins or copy it to `wp-content/plugins/`.
2. Activate plugin once; activation creates schema, seed and rewrite rules.
3. Open `Mini Assessment` as a user with `edit_posts`.
4. Run the clean-site smoke test in `../07-testing/mini-assessment-test-plan.md`.

## Rollback

- Deactivate the plugin to stop hooks; deactivation does not delete data.
- Restore the previous plugin package and reactivate it.
- Do not drop custom tables as part of a normal rollback; data deletion requires
  an explicit approved migration/operation.
- If a schema migration is introduced later, document expand/migrate/contract
  and rollback in `../05-data/` before release.
