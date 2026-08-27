# API documentation

Nhom nay la contract giua client, backend va external system.

## Cau truc khuyen nghi

- `openapi.yaml`: machine-readable contract va source of truth cho REST API.
- `conventions.md`: base URL, naming, date/time, pagination va versioning.
- `authentication.md`: auth flow, scope/role va token lifecycle.
- `errors.md`: error envelope, error code va cach client xu ly.
- `webhooks.md`: event, signature, retry va idempotency.
- `examples/`: request/response mau khong chua du lieu nhay cam.

## Moi endpoint phai co

- Operation ID/`API-*`, business purpose va related `FR-*`.
- Method/path, auth/permission, header, path/query/body parameter.
- Validation, request/response example va status code.
- Error code, rate limit, timeout, retry va idempotency neu ap dung.
- Backward compatibility, deprecation va rollout plan neu thay doi contract.

## Quy trinh thay doi API

1. Cap nhat contract va example truoc/kem code.
2. Client va server reviewer approve breaking/behavior change.
3. Test contract, permission, validation va error path.
4. Breaking change can ADR, version/deprecation plan va release note.

Dung [API endpoint template](../templates/api-endpoint-template.md) khi chua
co OpenAPI. Khong duy tri hai source of truth mau thuan.
