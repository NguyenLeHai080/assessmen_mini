# Git workflow

## Cac nhanh chinh

- `prod`: ma nguon dang chay tren production.
- `staging`: kiem thu QA va demo truoc khi phat hanh.
- `dev`: tich hop cac feature cua team phat trien.

Khong push truc tiep vao `prod` va `staging`. Moi thay doi vao hai nhanh
nay phai di qua pull request (PR).

## Feature workflow

1. Cap nhat `dev` va tao nhanh `feat/<feature_name>` tu `dev`.
2. Commit theo Conventional Commits va kem Issue ID.
3. Push nhanh feature, sau do tao PR vao `dev`.
4. Sau khi review, merge PR vao `dev`.
5. Tao PR tu `dev` vao `staging` de QA/demo.
6. Khi da dat kiem tra, tao PR tu `staging` vao `prod` de phat hanh.

Vi du:

```powershell
git switch dev
git pull --ff-only origin dev
git switch -c feat/homepage
git add .
git commit -m "feat: add homepage #123"
git push -u origin feat/homepage
```

## Hotfix workflow

1. Tao `hotfix/<hotfix_name>` tu `prod`.
2. Sua loi, commit kem Issue ID va push nhanh.
3. Tao PR tu nhanh hotfix vao `prod`.
4. Sau khi merge, dong bo `prod` vao `staging`, roi `staging` vao `dev`
   bang PR de tranh bo sot ban sua loi.

Vi du:

```powershell
git switch prod
git pull --ff-only origin prod
git switch -c hotfix/fix-login-error
git add .
git commit -m "fix: resolve login error #456"
git push -u origin hotfix/fix-login-error
```

## Commit message

Dinh dang khuyen nghi:

```text
<type>(<scope>): <description> #<issue_id>
```

Vi du hop le:

```text
feat(auth): add login page #123
fix: resolve login error #456
docs: document deployment flow #789
```

GitHub Actions bat buoc Issue ID dang `#123` doi voi cac type:
`feat`, `fix`, `refactor`, `perf`, `test` va `docs`. Cac commit van hanh
`chore`, `build`, `ci`, `style`, cung merge/revert commit, khong bat buoc
Issue ID.

## Quy tac review

- Khong tu merge khi chua kiem tra thay doi va ket qua CI.
- Moi trao doi review phai duoc giai quyet truoc khi merge.
- Khong force-push hoac xoa `prod` va `staging`.
- Neu thay doi behavior, API, data, UI, deployment hoac operations, cap nhat
  nhom tai lieu tuong ung trong [`docs/`](docs/README.md) cung PR.
- PR phai lien ket requirement va test case theo
  [`docs/traceability.md`](docs/traceability.md) khi feature co tai lieu chi tiet.
- Khi team co tu hai reviewer, bat buoc it nhat mot approval trong branch
  protection cua `prod` va `staging`.
