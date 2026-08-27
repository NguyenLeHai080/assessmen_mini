# Mini Assessment - Business Requirements

Status: Approved
Owner: Product/BA
Reviewers: Tech Lead, QA, WordPress reviewer
Last updated: 2026-08-27
Related issues: #9
Related docs: FR-001, NFR-001, API-001, DATA-001, UI-001, TC-001

## 1. Business context

Mini Assessment la module quan ly bai danh gia nang luc trong WordPress. Nguoi
quan tri co the tao bai danh gia, cau hoi va dap an; nguoi dung cong khai co
the xem cac bai da publish. He thong phai chay duoc tren mot site WordPress
trang tinh ma khong can cai them Node.js/npm o moi truong tiep nhan.

Ban phan tich tap trung vao kha nang ban giao va review nhanh: kich hoat plugin
khong loi, co du lieu mau, API truy cap dung va giao dien quan tri hoat dong.

## 2. Problem statement

Reviewer can mot goi plugin co the cai vao site WordPress moi va xac minh ngay:

- Plugin kich hoat duoc, khong WSOD/fatal error.
- Co 3 nhom du lieu assessment, question va answer sau khi kich hoat.
- Co bai mau de mo len xem ngay, khong phai nhap du lieu thu cong.
- API co dia chi on dinh theo namespace va khong phu thuoc hostname hardcode.
- Giao dien quan tri co loading, empty, error state va phan quyen ro rang.

## 3. Goals and success metrics

| ID | Muc tieu | Cac do |
| --- | --- | --- |
| BR-001 | Reviewer cai va kich hoat plugin tren WordPress moi | Kich hoat thanh cong, khong WSOD trong smoke test |
| BR-002 | Du lieu mau san sang sau kich hoat | Co it nhat 1 assessment, 2 question va 5 answer mau |
| BR-003 | Quan tri vien quan ly noi dung danh gia | Tao, xem, cap nhat, xoa assessment; tao question/answer |
| BR-004 | Nguoi dung xem noi dung da cong bo | Public list/detail chi hien assessment `published` |
| BR-005 | Giao tiep FE/BE dung tren moi hostname | Frontend dung API URL dong tu WordPress, khong hardcode localhost |
| BR-006 | Ban giao khong phu thuoc tool build | ZIP co san `dist/bundle.js` va `dist/bundle.css` |

## 4. Stakeholders and actors

| Actor | Nhu cau | Quyen/trach nhiem |
| --- | --- | --- |
| Reviewer/Lead | Cai va danh gia nhanh goi ban giao | Kiem tra plugin, DB, API, UI va packaging |
| Admin/Content manager | Quan ly bai danh gia | Tao/sua/xoa assessment, question, answer |
| Public viewer | Xem bai da cong bo | Chi doc assessment published va cau hoi/answer |
| Developer | Mo rong va sua he thong | Bao toan contract, test, migration va docs |
| WordPress | Nen tang chay plugin | Auth, nonce, REST routing, menu va database prefix |

## 5. Domain model (business view)

```text
Assessment (bai danh gia)
  1 --- n Question (cau hoi)
              1 --- n Answer (dap an)
```

- `Assessment` co tieu de, mo ta va trang thai `draft/published/archived`.
- `Question` thuoc duy nhat mot assessment, co noi dung va thu tu hien thi.
- `Answer` thuoc duy nhat mot question, co noi dung, diem va thu tu hien thi.
- Diem nam o answer de phuc vu cham diem mo rong; phien ban hien tai chi quan
  ly va hien thi noi dung, chua co luu bai lam cua nguoi thi.

## 6. Scope

### In scope

- Cai dat/kich hoat plugin va tao schema custom table.
- Seed du lieu mau idempotent cho lan kich hoat dau.
- Public read assessment published va cau hoi/answer cua assessment.
- Admin CRUD assessment va tao question/answer.
- Permission dang nhap + capability WordPress cho thao tac thay doi.
- React SPA trong WordPress Admin, phan trang, detail, form, loading/empty/error.
- REST namespace `assessment/v1`, nonce va API URL dong.
- Build bundle va dong goi ZIP ban giao.

### Out of scope (khong ngam dinh implement)

- Luong nguoi dung lam bai, nop bai, cham diem hoac luu ket qua ca nhan.
- Dang ky user, SSO, thanh toan, email, report/analytics nang cao.
- Multi-tenant, phan quyen theo tung assessment, workflow approval noi dung.
- Upload media, import/export CSV, drag-and-drop question builder.
- Public frontend page rieng ngoai man quan tri WordPress.

## 7. Business capabilities

### CAP-01: Discover assessments

Public viewer xem danh sach assessment da `published`. Admin dang nhap co the
xem ca `draft` va `archived` de quan ly.

### CAP-02: Manage assessment

Admin co the tao assessment voi title bat buoc, mo ta tuy chon va status hop le.
Admin co the xem chi tiet, cap nhat thong tin/status va xoa assessment.

### CAP-03: Manage question and answer

Admin tao question cho assessment va answer cho question. Danh sach detail hien
question theo `sort_order`, answer theo `sort_order` roi den ID.

### CAP-04: Safe installation and handoff

Lead upload ZIP, activate plugin, mo menu `Mini Assessment` va thay du lieu mau.
Neu frontend chua build hoac API loi, UI phai thong bao loi co the chan doan.

## 8. Use cases

| ID | Use case | Actor | Ket qua |
| --- | --- | --- | --- |
| UC-001 | Kich hoat va bootstrap plugin | Reviewer/Admin | Schema va seed san sang |
| UC-002 | Xem danh sach assessment | Public viewer/Admin | Danh sach dung visibility va pagination |
| UC-003 | Xem chi tiet assessment | Public viewer/Admin | Questions/answers dung thu tu |
| UC-004 | Tao assessment | Admin/Content manager | Assessment moi duoc luu |
| UC-005 | Cap nhat trang thai assessment | Admin/Content manager | Draft/published/archived cap nhat |
| UC-006 | Xoa assessment | Admin/Content manager | Assessment va child records bi xoa |
| UC-007 | Them question va answer | Admin/Content manager | Noi dung thuoc dung parent |
| UC-008 | Dong goi va ban giao | Developer/Reviewer | ZIP cai duoc tren site trang |

## 9. Business requirements

### BR-010: Kich hoat an toan

Khi plugin duoc activate, he thong tao/cap nhat schema can thiet, seed data neu
database dang rong va refresh WordPress rewrite rules. Hook activate khong duoc
in output ra man hinh hoac lam dung qua trinh kich hoat.

### BR-011: Khong lap seed data

Kich hoat lai, update plugin hoac reload khong duoc tao them assessment mau neu
da co du lieu. Seed chi la bootstrap, khong ghi de noi dung cua admin.

### BR-012: Hien thi public co kiem soat

Nguoi chua dang nhap chi duoc doc assessment `published`. Draft/archived va cac
thao tac thay doi khong duoc lo ra qua public UI/API.

### BR-013: Quan ly noi dung co quyen

Tao, sua, xoa assessment va them question/answer yeu cau user dang nhap va co
capability `edit_posts` hoac capability cao hon. Unauthorized request tra loi
401 khi chua login va 403 khi khong du quyen.

### BR-014: Validation truoc ghi du lieu

Title, question content, answer content va quan he cha bat buoc phai hop le.
Du lieu sai khong duoc ghi mot phan; client nhan loi 422 co ma loi de sua.

### BR-015: Toan ven quan he

Question khong duoc tro den assessment khong ton tai; answer khong duoc tro den
question khong ton tai. Xoa assessment phai xoa question va answer con treo.

### BR-016: Thu tu on dinh

Question va answer duoc hien thi tang dan theo `sort_order`; neu trung thu tu,
dung ID tang dan lam tie-breaker de ket qua lap lai duoc.

### BR-017: API khong phu thuoc moi truong

Client nhan API base URL va nonce tu WordPress runtime config. Khong hardcode
hostname, path site hay token vao bundle.

### BR-018: Ban giao tu kiem chung

Goi ZIP phai chua plugin entry point, backend, dist va README can thiet; nguoi
review khong can npm de cai va chay giao dien.

## 10. Acceptance criteria tong quat

```gherkin
Given mot WordPress site moi chua co du lieu assessment
When Lead upload va activate plugin
Then plugin khong WSOD, schema duoc tao va co du lieu mau
```

```gherkin
Given visitor chua dang nhap
When visitor goi danh sach assessment
Then chi assessment published duoc tra ve va response co pagination
```

```gherkin
Given admin da dang nhap va co capability edit_posts
When admin tao assessment voi title hop le
Then he thong luu assessment va tra ve ban ghi moi voi status 201
```

```gherkin
Given user khong dang nhap hoac khong co capability
When user goi endpoint thay doi du lieu
Then he thong tu choi voi 401 hoac 403 va khong thay doi database
```

```gherkin
Given assessment co questions va answers
When admin mo chi tiet assessment
Then questions/answers hien thi dung thu tu va loading/error/empty state ro rang
```

## 11. Business risks and mitigations

| Risk | Anh huong | Giam thieu |
| --- | --- | --- |
| WordPress/PHP version khac nhau | Plugin fatal khi activate | Giu PHP 7.4 syntax, smoke test tren site trang |
| Schema custom table sai | Khong co du lieu | Dung dbDelta syntax chuan, kiem tra bang sau activate |
| Rewrite/API URL sai hostname | API 404 khi ban giao | flush rewrite va inject `rest_url()` runtime |
| Seed lap du lieu | Reviewer thay nhieu ban ghi rac | Seed idempotent, chi chay khi bang assessment rong |
| Xoa cha de lai con | Du lieu orphan | Cascade o application layer trong transaction/flow ro rang |
| Public lo draft | Rui ro noi dung | Loc published o read path public, test permission |

## 12. Open questions can chot truoc mo rong

- Co can cho nguoi dung public lam bai va luu ket qua khong?
- Diem am/toi da moi answer co bi gioi han khong?
- Ai duoc phep publish/archived trong team nhieu vai tro?
- Co can audit log cho thay doi noi dung khong?
- Khi xoa assessment, business co can soft delete thay vi hard delete khong?
