# Requirement traceability

Moi feature nen co mot dong trong bang truy vet. Khong ghi mot danh sach ID
khong co lien ket; moi ID nen tro den heading hoac file cu the.

| Business | Requirement | Design | API/Data/UI | Test | Issue/PR | Release |
| --- | --- | --- | --- | --- | --- | --- |
| BR-001 | FR-001, NFR-001 | ADR-001 | API-001, DATA-001, UI-001 | TC-001 | #123 / #456 | v1.0.0 |
| BR-001 | FR-001 | - | mini-assessment.php, Activator | TC-001 | #9 | 1.0.0 |
| BR-002 | FR-002, FR-003 | - | DATA-001 / REST management APIs | TC-002, TC-003 | #9 | 1.1.0 |
| BR-003 | FR-005, FR-006, FR-007 | - | API-001 / Admin UI | TC-005, TC-006, TC-007 | #9 | 1.0.0 |
| BR-004 | FR-004, FR-008 | - | API-001 / React detail | TC-001, TC-002, TC-008 | #9 | 1.0.0 |
| BR-005 | FR-009, NFR-002 | - | Runtime config / API client | TC-009 | #9 | 1.0.0 |
| BR-006 | FR-010, NFR-005 | - | build-zip.sh / dist | TC-010 | #9 | 1.0.0 |

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
