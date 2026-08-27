# Architecture documentation

Nhom nay mo ta `how` o cap he thong, khong lap lai chi tiet endpoint hoac schema.

## Noi dung can co

- `system-context.md`: user, external system va trust boundary.
- `containers.md`: application/service/database va giao tiep giua chung.
- `components.md`: module, ownership va dependency quan trong.
- `integrations.md`: protocol, retry, timeout, idempotency va failure mode.
- `quality-attributes.md`: cach dap ung NFR.
- `adr/ADR-<number>-<title>.md`: quyet dinh co trade-off dai han.

Diagram nen dung Mermaid hoac source co the version control; neu dung anh,
luu ca file nguon de co the cap nhat.

## Khi nao can ADR

- Chon database, framework, protocol hoac deployment model.
- Thay doi public contract hoac data ownership.
- Chap nhan trade-off anh huong security, performance hoac operations.
- Dao nguoc mot quyet dinh da duoc approved.

Dung [ADR template](../templates/adr-template.md) cho quyet dinh moi.
