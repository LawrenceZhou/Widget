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
 * Prints a particular instance of widget
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_widget
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace widget with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... widget instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('widget', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $widget  = $DB->get_record('widget', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $widget  = $DB->get_record('widget', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $widget->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('widget', $widget->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_widget\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $widget);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/widget/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($widget->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->requires->js('/mod/widget/module.js');

//new added
$context = context_module::instance($cm->id);

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('widget-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($widget->intro) {
    echo $OUTPUT->box(format_module_intro('widget', $widget, $cm->id), 'generalbox mod_introbox', 'widgetintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Yay! It works!');

//Time the live will start.
$start_time_db = $widget->livestarttime;
$intro_string = 'The time when the live begin is: ';
$date_string = date('m/d/Y H:i', $start_time_db);
$end_string = '. Please pay attention to the time.';
echo $OUTPUT->box($intro_string.$date_string.$end_string);



if (has_capability('mod/widget:createvideo', $context)) {
    //$camera_number_db = $widget->cameranumber;
    //for ($i = 1; $i <= $camera_number_db; $i++) {
    //echo '<div><button name="camera'.$i.'" onclick=M.mod_widget.create_camera("video'.$i.'")>Click to choose the camera</button></div>';
    //echo '<video id="video'.$i.'" width="487" height="365"></video>';  
    //}
    echo '<meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/kurento.png" type="image/png" />

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/demo-console/index.css">
    <link rel="stylesheet" href="bower_components/ekko-lightbox/dist/ekko-lightbox.min.css">
    <link rel="stylesheet" href="css/kurento.css">

    <script src="bower_components/adapter.js/adapter.js"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/demo-console/index.js"></script>
    <script src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script>

    <script src="bower_components/kurento-utils/js/kurento-utils.js"></script>

    <script src="js/teacher.js"></script>

        <div class="container">
      <div class="page-header">
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-12">
              <a id="call" href="#" class="btn btn-success">
                <span class="glyphicon glyphicon-play"></span> Start</a>
              <a id="viewer" href="#" class="btn btn-primary">
                <span class="glyphicon glyphicon-user"></span> Watch</a>
              <a id="terminate" href="#" class="btn btn-danger">
                <span class="glyphicon glyphicon-stop"></span> Stop</a>
            </div>
          </div>
          <br/>
          <label class="control-label" for="console">Console</label><br><br>
          <div id="console" class="democonsole">
            <ul></ul>
          </div>
        </div>
        <div class="col-md-7">
          <div id="videoBig">
            <video id="video" autoplay width="640px" height="480px" poster="img/webrtc.png"></video>
          </div>
        </div>
      </div>
    </div>'; 
    
}else {
    echo '<meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/kurento.png" type="image/png" />

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/demo-console/index.css">
    <link rel="stylesheet" href="bower_components/ekko-lightbox/dist/ekko-lightbox.min.css">
    <link rel="stylesheet" href="css/kurento.css">

    <script src="bower_components/adapter.js/adapter.js"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/demo-console/index.js"></script>
    <script src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script>

    <script src="bower_components/kurento-utils/js/kurento-utils.js"></script>

    <script src="js/student.js"></script>

        <div class="container">
      <div class="page-header">
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-12">
              <a id="viewer" href="#" class="btn btn-primary">
                <span class="glyphicon glyphicon-user"></span> Watch</a>
              <a id="terminate" href="#" class="btn btn-danger">
                <span class="glyphicon glyphicon-stop"></span> Stop</a>
            </div>
          </div>
          <br/>
          <label class="control-label" for="console">Console</label><br><br>
          <div id="console" class="democonsole">
            <ul></ul>
          </div>
        </div>
        <div class="col-md-7">
          <div id="videoBig">
            <video id="video" autoplay width="640px" height="480px" poster="img/webrtc.png"></video>
          </div>
        </div>
      </div>
    </div>';
}



//echo $renderer->create_button($camera_number_db);


// Finish the page.
echo $OUTPUT->footer();
