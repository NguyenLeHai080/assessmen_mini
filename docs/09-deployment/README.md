# Deployment documentation

Nhom nay mo ta cach build va dua mot version qua `dev`, `staging`, `prod`.

## Noi dung can co

- `environments.md`: URL, purpose, owner va dependency; khong ghi secret.
- `configuration.md`: ten bien, y nghia, required/default va secret source.
- `ci-cd.md`: pipeline, artifact, quality gate va permission.
- `deployment.md`: pre-check, deploy order, migration va smoke test.
- `rollback.md`: trigger, rollback/roll-forward step va data handling.
- `release-notes/`: thay doi, migration, known issue va monitoring window.

## Release flow

1. Feature PR merge vao `dev` sau review va CI.
2. PR `dev -> staging`; deploy va thuc hien QA/UAT.
3. Chuan bi release checklist, migration va rollback.
4. PR `staging -> prod`; deploy theo approved plan.
5. Smoke test, theo doi metric/log/alert va ghi ket qua.

Dung [release checklist](../templates/release-checklist-template.md) cho moi
production release.
