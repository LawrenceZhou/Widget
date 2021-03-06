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
 * html render class
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mfavatar
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die();    
use plugin_renderer_base;  

class mod_widget_renderer extends plugin_renderer_base {

    /**
     * add the snapshot tool
     *
     * @return string
     * @throws coding_exception
     */
    public function create_button($cameranumber) {
      $html = '';
      for ($i = 1; $i <= $cameranumber; $i++) {
          $html .= '<div>
                    <button type="button">Click Me!</button>
                    </div>'
      }
        return $html;
    }

}