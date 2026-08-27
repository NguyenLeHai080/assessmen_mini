# Mini Assessment - Business Process

Status: Approved
Owner: Product/BA
Reviewers: Tech Lead, QA
Last updated: 2026-08-27
Related issues: #9
Related docs: mini-assessment-business-requirements.md, ../document-lifecycle.md

## 1. Process overview

```text
Install/Activate
      |
      v
Bootstrap schema + seed (neu rong)
      |
      v
Admin tao/chinh sua noi dung -----> Draft
      |                                  |
      | publish                          | archive
      v                                  v
Published <------------------------- Archived
      |
      v
Public viewer doc bai va cau hoi
```

`Archived` khong xuat hien trong public list nhung van duoc admin xem de quan ly.

## 2. Installation and bootstrap flow

### Actor

Reviewer/Lead hoac WordPress administrator.

### Trigger

Upload plugin ZIP va bam Activate trong WordPress.

### Main flow

1. WordPress nap plugin entry point.
2. Activation hook tao/cap nhat 3 bang assessment, question, answer.
3. Neu assessment table rong, he thong tao 1 assessment mau, 2 question va
   cac answer mau.
4. He thong refresh rewrite rules de REST route san sang.
5. Admin mo menu `Mini Assessment` va thay UI load tu bundle `dist`.

### Exception flow

- Neu thieu bundle: UI hien thong bao goi ban giao chua du compiled asset.
- Neu schema loi: activation that bai co log chan doan, khong in output vao hook.
- Neu seed loi: khong tao ban ghi trung lap; bao loi de retry sau khi sua schema.

### Exit criteria

- Plugin active.
- Ba bang ton tai voi prefix WordPress hien tai.
- Seed co mat neu database ban dau rong.
- REST URL truy cap duoc sau mot lan refresh rewrite.

## 3. Assessment authoring flow

### Main flow

1. Admin dang nhap vao WordPress.
2. Admin mo menu Mini Assessment.
3. Admin nhap title, description va status.
4. He thong validate title va status.
5. He thong tao assessment va tra ve ban ghi moi.
6. Admin mo assessment, them questions theo thu tu.
7. Admin them answers cho tung question va gan score/sort order.
8. Admin chuyen status tu draft sang published khi noi dung san sang.

### Alternate flow

- Admin luu `draft` de tiep tuc sau.
- Admin cap nhat title/description/status cua ban ghi da ton tai.
- Admin archive noi dung khong muon xuat hien public nhung khong muon xoa.

### Validation/exception

- Thieu title/question/answer content: tu choi 422.
- Status ngoai `draft`, `published`, `archived`: dung gia tri mac dinh an toan.
- Parent ID khong ton tai: tu choi, khong tao ban ghi orphan.
- Request khong co login/permission: tu choi 401/403.

## 4. Public discovery flow

1. Visitor mo khu vuc co hien danh sach assessment.
2. He thong tai danh sach published theo page/per_page.
3. Visitor chon mot assessment.
4. He thong tai detail va questions/answers theo sort order.
5. UI hien loading trong luc goi API, empty khi khong co item va loi neu request
   that bai.

Public visitor khong thay form tao/sua/xoa va khong thay draft/archived.

## 5. Delete flow

1. Admin xac nhan xoa assessment.
2. He thong lay cac question thuoc assessment.
3. He thong xoa answers cua cac question, sau do xoa questions.
4. He thong xoa assessment.
5. UI tai lai danh sach va thong bao ket qua.

Neu bat ky buoc nao that bai, phai bao loi ro rang va tranh de quan he orphan.
Trong phien ban dau, delete la hard delete; soft delete la open question.

## 6. Release and handoff flow

1. Developer cap nhat code va docs tren `feat/*` tu `dev`.
2. PR vao `dev` phai co Issue ID, test evidence va docs lien quan.
3. Promote `dev -> staging`, QA kiem tra install/API/UI tren site trang.
4. Tao ZIP co compiled `dist` va tai lieu huong dan.
5. Promote `staging -> prod` sau khi release checklist dat.
6. Reviewer co the cai ZIP tren WordPress moi ma khong can Node/npm.

## 7. Responsibility matrix

| Buoc | Product/BA | Developer | QA | Reviewer/Lead | Ops |
| --- | --- | --- | --- | --- | --- |
| Scope/business rule | A/R | C | C | C | I |
| Schema/API/UI design | C | A/R | C | C | C |
| Implementation | I | A/R | C | I | I |
| Functional verification | C | C | A/R | C | I |
| Release/handoff | C | R | R | A | C |
| Incident/rollback | I | R | C | C | A/R |

Chu thich: A = accountable, R = responsible, C = consulted, I = informed.
