$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$frontendPath = Join-Path $projectRoot 'frontend'
$packagePath = Join-Path $projectRoot 'mini-assessment-package'
$zipPath = Join-Path $projectRoot 'mini-assessment.zip'

Push-Location $frontendPath
try {
    npm.cmd ci
    npm.cmd run build
} finally {
    Pop-Location
}

if (Test-Path -LiteralPath $packagePath) {
    Remove-Item -LiteralPath $packagePath -Recurse -Force
}
if (Test-Path -LiteralPath $zipPath) {
    Remove-Item -LiteralPath $zipPath -Force
}

New-Item -ItemType Directory -Path $packagePath | Out-Null
Copy-Item -LiteralPath (Join-Path $projectRoot 'mini-assessment.php') -Destination $packagePath
Copy-Item -LiteralPath (Join-Path $projectRoot 'README.md') -Destination $packagePath
Copy-Item -LiteralPath (Join-Path $projectRoot 'backend') -Destination $packagePath -Recurse
Copy-Item -LiteralPath (Join-Path $projectRoot 'dist') -Destination $packagePath -Recurse
# tar writes POSIX entry separators, which WordPress on Linux extracts correctly.
tar.exe -a -c -f $zipPath -C $packagePath .
if (-not (Test-Path -LiteralPath $zipPath)) {
    throw "Archive was not created: $zipPath"
}
Remove-Item -LiteralPath $packagePath -Recurse -Force

Write-Output "Created $zipPath"
