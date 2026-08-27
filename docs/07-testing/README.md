# Testing documentation

Nhom nay mo ta chien luoc, test case va evidence de xac minh requirement.

## Noi dung can co

- `test-strategy.md`: test level, scope, environment va quality gate.
- `test-cases.md`: `TC-*`, precondition, step, expected result va priority.
- `test-data.md`: cach tao, reset va bao ve test data.
- `automation.md`: pham vi automation, command va ownership.
- `reports/`: ket qua theo release; khong commit secret hoac PII.
- [`../traceability.md`](../traceability.md): mapping requirement den test.

## Quality gate toi thieu

- Unit test cho business rule va validation quan trong.
- Integration/contract test cho API, database va external dependency.
- End-to-end/smoke test cho critical user flow.
- Regression test cho bug/hotfix.
- NFR test khi co muc tieu performance, security hoac accessibility.

Dung [test case template](../templates/test-case-template.md) cho test moi.
