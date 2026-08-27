# Requirement traceability

Moi feature nen co mot dong trong bang truy vet. Khong ghi mot danh sach ID
khong co lien ket; moi ID nen tro den heading hoac file cu the.

| Business | Requirement | Design | API/Data/UI | Test | Issue/PR | Release |
| --- | --- | --- | --- | --- | --- | --- |
| BR-001 | FR-001, NFR-001 | ADR-001 | API-001, DATA-001, UI-001 | TC-001 | #123 / #456 | v1.0.0 |

## Kiem tra theo chieu doc

- Moi `BR-*` co it nhat mot `FR-*` hoac ly do khong can implementation.
- Moi `FR-*` co design/API/data/UI lien quan hoac ghi `N/A` kem ly do.
- Moi `FR-*` va `NFR-*` co it nhat mot `TC-*`.
- Moi PR ghi Issue va requirement ID da implement.
- Moi release ghi danh sach PR/Issue va migration lien quan.

## Kiem tra theo chieu nguoc

- Moi endpoint, table va screen phai truy ve duoc requirement.
- Moi test case phai neu requirement hoac defect ma no xac minh.
- Code khong co requirement phai duoc phan loai la maintenance/technical debt
  va van can Issue ID.
