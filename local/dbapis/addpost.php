<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

 /**
  * Add post.
  *
  * @package    local_dbapis
  * @copyright  2026 Pedro L. Garcia <pedroljaen@gmail.com>
  * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  */

require_once(__DIR__ . '/../../config.php');

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

global $DB, $USER, $OUTPUT, $PAGE;

// Page setup.
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/dbapis/addpost.php'));
$PAGE->set_pagelayout('standard');

$strtitle   = get_string('pluginname', 'local_dbapis');
$strheading = get_string('addpost', 'local_dbapis');

$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);

// Breadcrumbs.
$PAGE->navbar->add($strtitle, new moodle_url('/local/dbapis/'));
$PAGE->navbar->add($strheading)->make_active();

// Form.
$messageform = new \local_dbapis\form\message_form();

if ($data = $messageform->get_data()) {
    // Moodleforms already validates sesskey, but this is fine to keep explicit.
    require_sesskey();

    // "Sanitize" (really: constrain to text) + trim.
    // If you want to allow any text including special chars/newlines, use PARAM_RAW_TRIMMED instead.
    $message = trim(clean_param($data->message, PARAM_TEXT));

    // Basic validation.
    if ($message === '') {
        redirect(
            $PAGE->url,
            get_string('errormessageempty', 'local_dbapis'),
            null,
            \core\output\notification::NOTIFY_ERROR
        );
    }

    // Insert into DB (safe against SQL injection because Moodle uses parameterised queries).
    $record = (object)[
        'message'     => $message,
        'userid'      => $USER->id,
        'timecreated' => time(),
    ];

    $DB->insert_record('local_dbapis', $record);

    // Redirect after POST to prevent duplicate submissions on refresh.
    redirect(
        new moodle_url('/local/dbapis/index.php'),
        get_string('messagesaved', 'local_dbapis'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

// Display form.
echo $OUTPUT->header();
echo $OUTPUT->heading($strheading, 2);

$messageform->display();

echo $OUTPUT->footer();
