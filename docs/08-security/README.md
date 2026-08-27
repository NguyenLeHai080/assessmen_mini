# Security documentation

Nhom nay ghi security requirement va control; khong commit secret, token,
private key, production credential hoac du lieu ca nhan thuc.

## Noi dung can co

- `threat-model.md`: asset, actor, trust boundary, threat va mitigation.
- `access-control.md`: role/permission matrix va least privilege.
- `data-protection.md`: classification, encryption va masking.
- `secrets-management.md`: noi luu, rotation va access process.
- `security-checklist.md`: review theo feature/release.
- `vulnerability-response.md`: severity, SLA va disclosure process.

## Review trigger

Bat buoc security review khi co auth, permission, payment, upload, public API,
PII, external integration hoac thay doi trust boundary.
