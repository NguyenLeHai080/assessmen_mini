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
2. Upload `mini-assessment.zip` qua Plugins -> Add New -> Upload Plugin va
   activate plugin.
3. Mo menu `Mini Assessment`; plugin tao/cap nhat schema theo option
   `mini_assessment_db_version`.
4. Tao mot trang WordPress va them shortcode `[mini_assessment]` de hien thi
   React SPA cong khai. Nguoi dung co the xem assessment `published`, chon dap
   an va nop bai.

### Schema va migration

Activation dung `dbDelta()` va option `mini_assessment_db_version` de quan ly
schema. Plugin tao cac bang co prefix WordPress: `assessment`,
`assessment_questions`, `assessment_answers`, `assessment_attempts` va
`assessment_attempt_answers`. Cac khoa join/filter (`assessment_id`,
`question_id`, `attempt_id`, `status`, `sort_order`) deu co index.

### REST API

Base URL: `/wp-json/assessment/v1`. Khi local server khong bat pretty permalink,
dung dang fallback `/?rest_route=/assessment/v1/...`.

| Method | Endpoint | Quyen |
| --- | --- | --- |
| GET | `/assessments?page=1&per_page=10` | Public, chi `published` |
| POST | `/assessments` | `edit_posts` + REST nonce hoac Application Password |
| GET/PUT/PATCH/DELETE | `/assessments/{id}` | Read public; write `edit_posts` |
| GET | `/assessments/{id}/questions` | Public theo visibility assessment |
| POST | `/answers` | `edit_posts` + REST nonce |
| POST | `/questions` | `edit_posts` + REST nonce hoac Application Password |
| POST | `/answers` | `edit_posts` + REST nonce hoac Application Password |
| GET | `/questions/{id}/answers` | Public theo visibility assessment |
| POST | `/answers` | `edit_posts` + REST nonce |
| POST | `/assessments/{id}/submissions` | Public, chi assessment `published` |

Tao assessment:

```json
POST /wp-json/assessment/v1/assessments
{"title":"Kiem tra React","description":"Co ban","status":"published"}
```

Nop bai:

```json
POST /wp-json/assessment/v1/assessments/12/submissions
{"answers":[{"question_id":31,"answer_id":92}]}
```

Response thanh cong co dang `{"success":true,"data":{...}}`. Input sai tra
`422`; chua dang nhap/khong du quyen ghi tra `401`/`403`; resource khong ton tai
tra `404`; loi luu du lieu duoc log voi prefix `[mini-assessment]` va tra `500`.

De test endpoint ghi bang Postman, tao WordPress Application Password cho user co
capability `edit_posts`, sau do dung Basic Auth. Collection import san co tai
`docs/07-testing/Mini-Assessment.postman_collection.json`.

### Dong goi va kiem thu

Chay `scripts/build-zip.ps1` tren Windows hoac `scripts/build-zip.sh` tren Bash.
ZIP chi chua entry point, `backend/`, `dist/` va README, khong co dependencies
frontend hay secrets. Chi tiet schema, API, test plan va deployment nam trong
[`docs/`](docs/README.md).

Chi tiet business cua module xem tai
[`docs/01-business/mini-assessment-business-requirements.md`](docs/01-business/mini-assessment-business-requirements.md).

### AI assistance disclosure

OpenAI Codex duoc dung de ho tro scaffold plugin/React, review API contract, va
debug moi truong WordPress local. Cac phan da tu review/xac nhan gom PHP lint,
React production build, kich hoat plugin, REST endpoint (public va protected),
va Postman collection. Khong dua secret, Application Password, hay du lieu moi
truong local vao repository.
