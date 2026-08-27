# Mini Assessment - Business Rules

Status: Approved
Owner: Product/BA
Reviewers: Tech Lead, QA
Last updated: 2026-08-27
Related issues: #9
Related docs: mini-assessment-business-requirements.md, ../02-requirements/README.md

## RULE-001: Assessment title

Title la bat buoc, khong duoc rong sau khi trim. Do dai toi da phu hop voi
truong luu tru; noi dung phai duoc sanitize truoc khi ghi.

## RULE-002: Assessment status

Chi chap nhan `draft`, `published`, `archived`.

- `draft`: dang soan, khong public.
- `published`: duoc public read.
- `archived`: ngung public, giu lai cho admin.

## RULE-003: Visibility

Request public chi duoc doc assessment `published`. Request cua user co quyen
quan ly co the doc moi status de phuc vu authoring.

## RULE-004: Parent-child ownership

Moi question phai co assessment ton tai; moi answer phai co question ton tai.
Khong cho phep client tu gan child vao parent khong ton tai.

## RULE-005: Ordering

Sort order la so nguyen khong am. Ket qua sort tang dan theo `sort_order`, sau
do theo `id` tang dan khi trung gia tri.

## RULE-006: Answer score

Score la so nguyen; mac dinh 0. Score duoc luu de phuc vu cham diem sau nay,
nhung khong tu dong tao submission/result trong phien ban nay.

## RULE-007: Authorization

Doc public khong can login. Moi thao tac tao/sua/xoa yeu cau dang nhap va
capability `edit_posts` (hoac capability cao hon). Nonce WordPress phai duoc
gui cho request thay doi tu admin UI.

## RULE-008: Error semantics

- `401`: chua dang nhap cho thao tac bao ve.
- `403`: da dang nhap nhung thieu capability.
- `404`: assessment/question/answer khong ton tai.
- `422`: input khong hop le.
- `500`: loi he thong/database khong du kien.

Response loi can co error code va message co the hien thi cho user; khong tra
stack trace, SQL hoac secret.

## RULE-009: Idempotent bootstrap

Activation co the chay nhieu lan an toan. Schema duoc update theo DB version;
seed chi chay khi bang assessment rong va khong ghi de du lieu da co.

## RULE-010: Cascade delete

Xoa assessment phai xoa answer truoc, question sau, assessment cuoi cung. Sau
delete khong duoc con child record tro vao parent da xoa.

## RULE-011: Stable API contract

Namespace hien hanh la `assessment/v1`. Public list co `items` va `pagination`;
successful mutation tra ve `success` va `data`. Breaking change phai doi version
namespace va co migration/deprecation plan.

## RULE-012: Environment neutrality

API URL phai duoc tao tu WordPress runtime (`rest_url`). Bundle khong duoc
chua `localhost`, site URL co dinh hay nonce hardcode.

## RULE-013: Seed content

Seed phai tao mot bai mau ve WordPress/React assessment, it nhat hai question,
va answer co score dung/sai de Lead co the kiem tra hierarchy va ordering.

## RULE-014: Data safety

Khong commit secret, credential, PII production hoac test data nhay cam vao
source/ZIP. Log va error message chi tiet vua du de chan doan.
