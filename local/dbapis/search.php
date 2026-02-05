<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Search posts page.
 *
 * @package     local_dbapis
 * @copyright  2026 Pedro L. Garcia <pedroljaen@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

global $DB, $OUTPUT, $PAGE;

$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/dbapis/search.php'));
$PAGE->set_pagelayout('standard');

$strtitle   = get_string('pluginname', 'local_dbapis');
$strheading = get_string('searchposts', 'local_dbapis');

$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);

// Breadcrumbs.
$PAGE->navbar->add($strtitle, new moodle_url('/local/dbapis/'));
$PAGE->navbar->add($strheading)->make_active();

// Permission.
$candelete = is_siteadmin() || has_capability('local/dbapis:deletemessage', $context);

// Form.
$searchform = new \local_dbapis\form\search_form();

$searched = false;
$resultsout = [];

if ($data = $searchform->get_data()) {
    require_sesskey();
    $searched = true;

    $searchterm = trim((string)$data->searchterm);

    $params = [];
    $wheresql = '1=1';

    if ($searchterm !== '') {
        $wheresql = $DB->sql_like('d.message', ':searchterm', false, false);
        $params['searchterm'] = '%' . $searchterm . '%';
    }

    $sql = "
        SELECT
            d.id,
            d.message,
            u.firstname,
            u.lastname
        FROM {local_dbapis} d
        JOIN {user} u ON u.id = d.userid
        WHERE $wheresql
        ORDER BY d.timecreated DESC
    ";

    $records = $DB->get_records_sql($sql, $params);

    foreach ($records as $r) {
        // Build the delete button HTML in PHP (safe + includes sesskey).
        $deletebutton = '';
        if ($candelete) {
            $deletebutton = $OUTPUT->single_button(
                new moodle_url('/local/dbapis/deletepost.php', [
                    'id' => $r->id,
                    'returnurl' => $PAGE->url->out(false),
                    'sesskey' => sesskey(),
                ]),
                get_string('delete'),
                'post'
            );
        }

        // Text output: escape in PHP, then print as plain text in mustache.
        $text = $r->id . ', ' . $r->message . ', ' . $r->firstname . ' ' . $r->lastname;

        $resultsout[] = [
            'id' => $r->id,
            'text' => s($text),
            'candelete' => $candelete,
            'deletebutton' => $deletebutton, // triple-stached in template
        ];
    }
}

$templatecontext = [
    'heading' => $strheading,
    'formhtml' => $searchform->render(),
    'searched' => $searched,
    'hasresults' => !empty($resultsout),
    'noresults' => get_string('nosearchresults', 'local_dbapis', ''),
    'results' => $resultsout,
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_dbapis/search', $templatecontext);
echo $OUTPUT->footer();
