# assessmen_mini

Quy trinh lam viec va quy uoc commit duoc mo ta trong
[CONTRIBUTING.md](CONTRIBUTING.md).

Tai lieu nghiep vu, yeu cau, API, data, testing, deployment va van hanh duoc
phan loai tai [docs/README.md](docs/README.md).

## Mini Assessment Plugin

Day la plugin WordPress quan ly Assessment, Question va Answer:

- Entry point: `mini-assessment.php`.
- Backend PHP: `backend/Database`, `backend/API`, `backend/Admin`.
- React source: `frontend/`; compiled assets: `dist/`.
- REST namespace: `/wp-json/assessment/v1`.
- Admin menu: `Mini Assessment` (yeu cau capability `edit_posts`).

### Cai dat nhanh

1. Chay `npm install` va `npm run build` trong `frontend/`, hoac dung
   `scripts/build-zip.ps1` (Windows) / `scripts/build-zip.sh` (Bash) de tao goi
   ban giao.
2. Upload repository/plugin ZIP vao `wp-content/plugins/` va activate plugin.
3. Mo menu `Mini Assessment`; lan activate dau se tao schema va seed data.

Chi tiet business cua module xem tai
[`docs/01-business/mini-assessment-business-requirements.md`](docs/01-business/mini-assessment-business-requirements.md).
