<?php

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

function theme_uems_get_main_scss_content($theme) {
    global $CFG;

    $scss = file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');

    $variables = file_get_contents($CFG->dirroot . '/theme/uems/scss/core/_variables.scss');
    $uems = file_get_contents($CFG->dirroot . '/theme/uems/scss/default.scss');

    return $scss . ' ' . $variables . ' ' . $uems;
}
