# Moodle Academy – Plugin Examples

This public repository contains **Moodle plugins and small experiments** created while completing **Moodle Academy** courses.

The goal is to keep:
- **Working examples** that accompany course activities
- **Reference implementations** for common Moodle development patterns
- A small **portfolio** of learning outcomes and hands-on practice

> ⚠️ Educational purpose: some plugins are simplified to match course requirements and may need additional hardening, testing, and review before production use.

---

## Repository structure

Plugins are organized using Moodle’s standard directory layout, so they can be copied directly into a Moodle codebase:
local/
dbapis/
version.php
db/
classes/
templates/


Each plugin folder includes its own `README.md` with:
- What the plugin does
- Installation steps
- Notes/limitations

---

## Included plugins

| Plugin | Type | Description |
|-------|------|-------------|
| `local/dbapis` | Local plugin | API / DB examples created for a Moodle Academy final course project |

---

## Installation (quick)

1. Copy the plugin folder into your Moodle root (example):
   - `local/dbapis` → `<moodle_root>/local/dbapis`
2. Log in as admin and go to:
   - **Site administration → Notifications**
3. Follow the upgrade/install prompts.

---

## Notes

- These examples are maintained as learning material.
- Contributions, suggestions, and improvements are welcome via issues/PRs.

---

## License

See individual plugin folders (and/or repository license file) for licensing details.