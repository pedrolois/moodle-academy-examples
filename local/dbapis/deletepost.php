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
  * Delete post.
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

require_sesskey();

global $DB;

$context = context_system::instance();

// Only admins or users with the capability can delete messages.
if (!is_siteadmin() && !has_capability('local/dbapis:deletemessage', $context)) {
    throw new required_capability_exception($context, 'local/dbapis:deletemessage', 'nopermissions', '');
}

$id = required_param('id', PARAM_INT);
$returnurl = optional_param('returnurl', '/local/dbapis/search.php', PARAM_LOCALURL);

// Ensure record exists.
$DB->get_record('local_dbapis', ['id' => $id], '*', MUST_EXIST);

// Delete record.
$DB->delete_records('local_dbapis', ['id' => $id]);

redirect(new moodle_url($returnurl), get_string('messagedeleted', 'local_dbapis'));
