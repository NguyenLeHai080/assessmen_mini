# Document lifecycle

## 1. Intake

- Tao GitHub Issue, mo ta van de, doi tuong su dung va ket qua mong muon.
- Product/BA gan ID `BR-*`, xac dinh pham vi in-scope va out-of-scope.
- Chi tiet chua ro duoc ghi thanh open question, khong ngam dinh trong code.

Dieu kien qua buoc: co owner, Issue ID, muc tieu va pham vi so bo.

## 2. Business analysis

- Mo ta as-is/to-be flow, stakeholder, glossary va business rule.
- Tach requirement thanh `FR-*` va `NFR-*` co the kiem chung.
- Viet acceptance criteria theo Given/When/Then khi phu hop.

Dieu kien qua buoc: Business/Product va Tech Lead thong nhat yeu cau.

## 3. Solution design

- Architecture ghi component/integration bi anh huong.
- Thay doi lon hoac co trade-off phai co `ADR-*`.
- API ghi contract, auth, validation, error va compatibility.
- Data ghi entity/field, migration, rollback va retention.
- UI/UX ghi flow, screen state, loading/empty/error va accessibility.
- Security ghi quyen truy cap, du lieu nhay cam va abuse case.

Dieu kien qua buoc: API/data/UI co the review doc lap voi implementation.

## 4. Ready for development

Mot Issue dat Definition of Ready khi:

- Requirement va acceptance criteria khong con blocker.
- Dependency, risk va rollout strategy da duoc xac dinh.
- API/data migration co backward compatibility hoac ke hoach migration.
- Test approach va observability requirement da ro.
- Tai lieu lien ket den Issue va lien ket cheo bang cac ID.

## 5. Implementation

- Tao `feat/<name>` tu `dev`; commit tham chieu Issue ID.
- Code va tai lieu lien quan nam trong cung PR neu co the.
- PR phai neu ro requirement nao duoc dap ung va cach kiem tra.
- Reviewer kiem tra ca tinh dung cua code lan tinh dong bo cua docs.

## 6. Verification

- Unit/integration/API/UI test chay theo test strategy.
- QA cap nhat ket qua `TC-*`, evidence va defect neu co.
- Traceability phai du tu `BR/FR` den code PR va test case.
- Security/performance test duoc thuc hien neu NFR yeu cau.

Dieu kien qua buoc: acceptance criteria dat, khong con defect blocker.

## 7. Release

- Merge `dev` vao `staging` bang PR de QA/demo.
- Cap nhat deployment plan, config, migration, rollback va release note.
- Sau approval release, merge `staging` vao `prod` bang PR.
- Gan version/tag neu du an dung release version.

## 8. Operations

- Kiem tra health check, log, metric va alert sau deployment.
- Theo doi smoke test va business KPI trong cua so rollout.
- Neu rollback, ghi timeline, impact va ly do vao Issue/incident report.
- Dong Issue sau khi docs, code, test evidence va release note da day du.

## Hotfix

1. Tao Issue cho incident/bug va nhanh `hotfix/<name>` tu `prod`.
2. Cap nhat toi thieu: root cause so bo, thay doi, test va rollback.
3. PR hotfix vao `prod`; sau release dong bo `prod -> staging -> dev`.
4. Hoan thien RCA, test regression va tai lieu con thieu sau khi on dinh.

Hotfix duoc phep rut gon tai lieu truoc release, nhung khong duoc bo qua Issue,
test evidence, rollback plan va buoc dong bo nhanh.

## Document status

- `Draft`: dang soan, chua duoc dung lam contract.
- `In Review`: da san sang de stakeholder/technical reviewer kiem tra.
- `Approved`: la contract hien hanh cho implementation va test.
- `Deprecated`: khong con ap dung; phai chi den tai lieu thay the neu co.

Thay doi behavior cua tai lieu `Approved` phai di qua PR va reviewer phu hop.
