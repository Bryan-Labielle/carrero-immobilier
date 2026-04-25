# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Repo Is

Toolbox for bootstrapping Laravel Inertia Vue.js projects. Contains AI agent rules (`CLAUDE.md`) and skills (`SKILL.md`) that get copied into new projects during init.

This is NOT a runnable application. There is no dev server, no build, no tests.

## Repository Structure

```
resources/js/               # CLAUDE.md files copied into src/ during init
├── Components/CLAUDE.md    # Vue component conventions (always active)
├── Composables/CLAUDE.md   # Composable patterns (always active)
├── Pages/CLAUDE.md         # Inertia patterns (always active)
└── Stores/CLAUDE.md        # Pinia store patterns (always active)

.claude/skills/
├── init-project/SKILL.md   # /init-project — full Laravel setup + copy rules
├── testing/SKILL.md        # /testing — Vitest, Vue Test Utils, Inertia mocking
├── update-deps/SKILL.md    # /update-deps — dependency updates
└── writing/SKILL.md        # /writing — prose style guide

src/                         # Laravel project goes here (laravel new src)
```

## Usage Flow

1. Clone this repo
2. `laravel new src` (create Laravel Inertia app inside `src/`)
3. `claude` then `/init-project` (configures everything + copies CLAUDE.md rules)

## CLAUDE.md vs SKILL.md

- `CLAUDE.md` in a directory = always loaded when the agent works there. Use for conventions.
- `SKILL.md` in `.claude/skills/` = loaded on demand (`/init-project`, `/testing`). Use for one-off tasks.
