# Release checklist: YYYY-MM-DD / version

Status: Draft
Owner: TBD
Related issues/PRs: #000

## Scope

- Features/fixes:
- Services/components:
- Known limitations:

## Before staging

- [ ] PRs da merge vao `dev`; CI va automated tests dat.
- [ ] API/data/UI/security docs da cap nhat.
- [ ] Migration va backward compatibility da review.
- [ ] Test data va QA plan san sang.

## Staging verification

- [ ] PR `dev -> staging` da merge va deploy thanh cong.
- [ ] Smoke, regression va UAT dat.
- [ ] Performance/security checks dat neu ap dung.
- [ ] Defect con lai da duoc chap nhan ro rang.

## Production readiness

- [ ] Deployment steps, owner va thoi gian da thong nhat.
- [ ] Config/secret reference da san sang; khong ghi gia tri secret tai day.
- [ ] Backup/migration/rollback hoac roll-forward plan da test.
- [ ] Dashboard, log, alert va runbook da san sang.
- [ ] Stakeholder va support/operations da duoc thong bao.

## Production verification

- [ ] PR `staging -> prod` da merge va deploy thanh cong.
- [ ] Health check va critical smoke test dat.
- [ ] Error rate, latency va business KPI binh thuong.
- [ ] Migration/backfill duoc xac minh.
- [ ] Release note/tag/version da cap nhat.

## Result

- Released at:
- Released by:
- Monitoring window:
- Rollback performed: No | Yes, link incident
- Follow-up Issues:
