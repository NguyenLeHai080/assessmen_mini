# Data documentation

Nhom nay mo ta ownership, cau truc va vong doi du lieu.

## Noi dung can co

- `data-model.md`: ERD va quan he giua cac `DATA-*` entity.
- `data-dictionary.md`: field, type, nullable, default va y nghia nghiep vu.
- `ownership.md`: service/team nao duoc ghi va doc du lieu.
- `migrations.md`: expand/migrate/contract, backfill, verify va rollback.
- `retention-and-privacy.md`: PII, encryption, retention va deletion.
- `backup-and-restore.md`: RPO/RTO va cach kiem tra restore.

## Checklist thay doi schema

- Lien ket den `FR-*`, API va service bi anh huong.
- Danh gia backward compatibility va lock/downtime risk.
- Co migration, backfill, verification query va rollback/roll-forward plan.
- Khong luu secret hoac du lieu nhay cam neu khong co ly do va control.
- Cap nhat test data, monitoring va data dictionary.
