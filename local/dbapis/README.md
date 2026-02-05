# local_dbapis (Database API examples)

A small Moodle local plugin demonstrating core Moodle development patterns:

## Features
- Create messages (CRUD) stored in a custom table (`local_dbapis`)
- Search messages with safe SQL (placeholders) and XSS-safe output
- Delete messages with capability-based access control
- XMLDB schema + upgrade path (adds `local_dbapis_history` and copies data)
- Input sanitization (plain text only)
- Optional: Mustache templates for output rendering

## Technical highlights
- XMLDB: `db/install.xml`
- Upgrades: `db/upgrade.php`
- Capabilities: `db/access.php` (`local/dbapis:deletemessage`)
- DB API: `$DB->insert_record()`, `$DB->get_records_sql()`, `$DB->delete_records()`
- Security: `clean_param(PARAM_TEXT)`, placeholders, `s()` for output, `require_sesskey()`

## Installation
1. Copy to: `moodle/local/dbapis`
2. Visit Site administration → Notifications
3. Assign capability `local/dbapis:deletemessage` to a role if needed

## Tested on
- Moodle 4.x (adjust as appropriate)

## License
GPL v3 or later
