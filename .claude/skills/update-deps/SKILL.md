---
name: update-deps
description: "Updates PHP (Composer) and JS (npm) dependencies for a Laravel project. Handles patch/minor updates automatically and provides impact analysis with user validation for major updates. Activate whenever the user asks to update dependencies, check for outdated packages, upgrade packages, do dependency maintenance, or mentions npm update, composer update, outdated, upgrade, or dependency check."
---

# Update Dependencies

Updates PHP and JS dependencies in a structured, safe way. Patch/minor versions are updated directly. Major versions go through an impact analysis with user approval before proceeding.

## Workflow

Follow these steps in order. Run independent commands in parallel whenever possible.

### Step 1 — Security Audit

Run in parallel:
- `composer audit`
- `npm audit`

If critical vulnerabilities are found, report them immediately and prioritize fixing them before continuing.

### Step 2 — Check Outdated Versions

Run in parallel:
- `composer outdated --direct` (PHP direct dependencies only)
- `npm outdated` (JS dependencies)

If everything is up to date, tell the user and stop. Ignore platform-specific packages showing as `MISSING` (e.g., `@rollup/rollup-linux-x64-gnu` on macOS) — these are normal.

Classify each outdated package:
- **patch/minor** — safe to update directly
- **major** — requires impact analysis and user validation

### Step 3 — Update Patch/Minor Versions

Update these without asking:
- `composer update` (respects semver constraints in composer.json, so only patch/minor)
- `npm update` (same — respects semver constraints in package.json)

After updating, run `vendor/bin/pint --dirty --format agent` if any PHP files changed.

### Step 4 — Major Version Analysis

For each major version available, do the following **one package at a time**:

#### 4a. Check peer dependency constraints

Before anything else, check if other packages block this update. For example, `laravel-vite-plugin` requiring `vite ^7.0.0` blocks a Vite 8 upgrade. Check with:
- `npm view <package> peerDependencies --json` for packages that depend on it
- `npm ls <package>` to see the dependency tree

If the update is blocked by a peer dependency, mark it as **blocked** with the reason and move to the next package. Do not attempt the update.

#### 4b. Research breaking changes

Use `WebFetch` to read the migration guide or changelog:
- npm packages: check the GitHub releases page or official migration guide
- Composer packages: check the GitHub releases page or upgrade guide

Extract a concise list of breaking changes relevant to the project.

#### 4c. Scan the codebase for impact

For each breaking change, search the codebase to find impacted files:
- Use `Grep` to find imports, function calls, or API usage that would be affected
- Use `Glob` to find files of relevant types

#### 4d. Present impact report and ask for validation

Present the user with a clear report for each major package:

```
### <package> <current> -> <latest>

**Breaking changes:**
- <change 1>
- <change 2>

**Impacted files:**
- `path/to/file.ts` — uses <affected API>
- `path/to/other.vue` — imports <removed export>

**Peer dependencies:** OK / Blocked by <package>
**Risk:** Low / Medium / High

Proceed with this update? (yes/no)
```

Wait for the user's response before continuing.

#### 4e. Update and fix

If the user validates:
1. Install the new version (`npm install <package>@latest` or `composer require <package>:^<version>`)
2. Fix impacted files based on the breaking changes identified
3. Run verification checks (see Step 5) to confirm nothing is broken

If the user refuses, skip and move to the next package.

### Step 5 — Global Verification

After all updates are done, run these checks to confirm nothing is broken:

1. `vendor/bin/pint --test --format agent` (PHP lint)
2. `npx eslint .` (JS lint)
3. `npx vue-tsc --noEmit` (TypeScript types)
4. `npm run build` (frontend build)
5. `php artisan test --compact` (tests)

If any check fails, attempt to fix the issue. If the fix is not straightforward, report it to the user.

### Step 6 — Final Report

Present a summary table:

```
### Updated
| Package | Before | After | Type |
|---------|--------|-------|------|
| ...     | ...    | ...   | minor/major |

### Not Updated
| Package | Current | Latest | Reason |
|---------|---------|--------|--------|
| ...     | ...     | ...    | Blocked by X / User declined / ... |

### Issues
- Any remaining errors or warnings to address manually
```