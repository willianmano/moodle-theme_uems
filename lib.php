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

function theme_uems_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    $theme = theme_config::load('uems');

    if ($context->contextlevel == CONTEXT_SYSTEM && preg_match("/^sliderimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
}
