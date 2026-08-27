#!/usr/bin/env bash
set -euo pipefail

project_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$project_root"

echo "Building React assets..."
(cd frontend && npm ci && npm run build)

package_dir="mini-assessment-package"
rm -rf "$package_dir" mini-assessment.zip
mkdir -p "$package_dir"
cp mini-assessment.php README.md "$package_dir/"
cp -R backend dist "$package_dir/"

if command -v zip >/dev/null 2>&1; then
  (cd "$package_dir" && zip -qr "../mini-assessment.zip" .)
else
  echo "zip command is required to create mini-assessment.zip" >&2
  exit 1
fi

rm -rf "$package_dir"
echo "Created $project_root/mini-assessment.zip"
