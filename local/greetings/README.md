# Greetings #

Greetings is a Moodle local plugin created as part of the Moodle Academy course Moodle Access and Security Essentials.

It provides a simple page where authenticated users can post greeting messages and view previously posted messages. The plugin also includes an admin setting that controls the background colour used for each message card.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/greetings

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Features ##

- Requires users to log in before accessing the page.
- Blocks guest users from accessing the plugin.
- Adds a front page navigation link for logged-in non-guest users.
- Lets users post greeting messages.
- Displays greeting messages using a configurable card background colour.

## License ##

2022 Pedro Lois

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
