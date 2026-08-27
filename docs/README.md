# Project documentation

Thu muc nay la nguon tai lieu chinh cua du an. Khong dat file moi truc tiep
vao `docs/` neu file do thuoc mot nhom ben duoi.

## Ban do tai lieu

| Thu muc | Cau hoi tra loi | Noi dung dat tai day |
| --- | --- | --- |
| [`01-business/`](01-business/README.md) | Tai sao lam? | Muc tieu, pham vi, stakeholder, quy trinh va business rule |
| [`02-requirements/`](02-requirements/README.md) | He thong phai lam gi? | Functional, non-functional requirement, use case va acceptance criteria |
| [`03-architecture/`](03-architecture/README.md) | He thong duoc thiet ke ra sao? | System context, component, integration va ADR |
| [`04-api/`](04-api/README.md) | Cac he thong giao tiep the nao? | OpenAPI, endpoint, auth, error, versioning va example |
| [`05-data/`](05-data/README.md) | Du lieu duoc luu va quan ly the nao? | ERD, data dictionary, migration, retention va privacy |
| [`06-ui-ux/`](06-ui-ux/README.md) | Nguoi dung tuong tac the nao? | User flow, screen spec, state, responsive va accessibility |
| [`07-testing/`](07-testing/README.md) | Xac minh chat luong the nao? | Test strategy, test case, test data, traceability va report |
| [`08-security/`](08-security/README.md) | Bao ve he thong the nao? | Threat model, access control, secrets va security checklist |
| [`09-deployment/`](09-deployment/README.md) | Dua thay doi len moi truong the nao? | Environment, CI/CD, deployment, rollback va release checklist |
| [`10-operations/`](10-operations/README.md) | Van hanh sau release the nao? | Logging, monitoring, alert, runbook, incident va backup |
| [`11-project/`](11-project/README.md) | Team phoi hop the nao? | Git workflow, ownership, risk, decision log va release note |
| [`templates/`](templates/README.md) | Bat dau tai lieu moi tu dau? | Cac mau tai lieu dung chung |

Tai lieu cu the cua module Mini Assessment: [business requirements](01-business/mini-assessment-business-requirements.md), [process](01-business/mini-assessment-process.md), [rules](01-business/mini-assessment-business-rules.md), [API](04-api/mini-assessment-api.md), [data model](05-data/mini-assessment-data-model.md) va [test plan](07-testing/mini-assessment-test-plan.md).

## Quy tac phan loai nhanh

- Mo ta loi ich, quy trinh cua nguoi dung hoac quy tac tinh toan: `01-business/`.
- Mo ta he thong can ho tro hanh vi nao: `02-requirements/`.
- Mo ta cach cac service/component phoi hop: `03-architecture/`.
- Mo ta request, response, status code: `04-api/`.
- Mo ta bang, field, quan he, migration: `05-data/`.
- Mo ta man hinh va trang thai giao dien: `06-ui-ux/`.
- Mo ta cach kiem tra va ket qua mong doi: `07-testing/`.
- Mo ta quyen, moi de doa, bao mat du lieu: `08-security/`.
- Mo ta build, config, deploy, rollback: `09-deployment/`.
- Mo ta log, metric, alert, xu ly su co: `10-operations/`.
- Mo ta cach team lam viec va ra quyet dinh: `11-project/`.

## Metadata bat buoc

Tai lieu nghiep vu hoac ky thuat moi nen bat dau bang block sau:

```text
Status: Draft | In Review | Approved | Deprecated
Owner: <team/person>
Reviewers: <team/person>
Last updated: YYYY-MM-DD
Related issues: #123
Related docs: BR-001, FR-001, ADR-001, API-001, TC-001
```

## Quy trinh cap nhat

Doc chi tiet tai [document-lifecycle.md](document-lifecycle.md). Tom tat:

1. Tao Issue va xac dinh business requirement.
2. Phan tich functional/non-functional requirement va acceptance criteria.
3. Cap nhat architecture, API, data, UI/UX va security neu bi anh huong.
4. Tao test case va lien ket truy vet.
5. Implement tren `feat/*`, review code va docs trong cung PR.
6. Kiem thu tren `dev`, promote sang `staging`, sau do release len `prod`.
7. Cap nhat release note, runbook va monitoring truoc khi dong Issue.

## Naming va ID

- Ten file: lowercase kebab-case, vi du `login-business-rules.md`.
- Business requirement: `BR-001`; business rule: `RULE-001`.
- Functional/non-functional requirement: `FR-001`, `NFR-001`.
- Use case: `UC-001`; architecture decision: `ADR-001`.
- API contract/operation: `API-001`; data entity: `DATA-001`.
- UI screen/flow: `UI-001`; test case: `TC-001`.
- Moi ID phai on dinh; khong tai su dung ID cua tai lieu da deprecated.
