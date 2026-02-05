<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade code for local_dbapis.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_dbapis_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();
    
    if ($oldversion < 2026012701) {

        // 1) Create table local_dbapis_history.
        $table = new xmldb_table('local_dbapis_history');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('messageid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // 2) Copy data from local_dbapis → local_dbapis_history.
        $records = $DB->get_records('local_dbapis');

        foreach ($records as $record) {
            $history = (object)[
                'messageid'   => $record->id,
                'message'     => $record->message,
                'userid'      => $record->userid,
                'timecreated' => $record->timecreated,
            ];
            $DB->insert_record('local_dbapis_history', $history);
        }

        // 3) Savepoint.
        upgrade_plugin_savepoint(true, 2026012701, 'local', 'dbapis');
    }

    return true;
}
