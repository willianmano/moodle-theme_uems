<?php

namespace theme_uems\util;

use core_course_category;
use core_course_list_element;
use coursecat_helper;
use moodle_url;

class course {
    protected $course;

    /**
     * Class constructor
     *
     * @param core_course_list_element $course
     *
     */
    public function __construct($course) {
        $this->course = $course;
    }

    /**
     * Returns the first course's summary image url
     *
     * @return string
     */
    public function get_summary_image() {
        global $CFG, $OUTPUT;

        foreach ($this->course->get_course_overviewfiles() as $file) {
            if ($file->is_valid_image()) {
                $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php",
                    '/' . $file->get_contextid() . '/' . $file->get_component() . '/' .
                    $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$file->is_valid_image());

                return $url->out();
            }
        }

        return $OUTPUT->get_generated_image_for_id($this->course->id);
    }

    /**
     * Returns HTML to display course contacts.
     *
     * @return array
     */
    public function get_course_contacts() {
        $theme = \theme_config::load('uems');

        $contacts = [];
        if ($this->course->has_course_contacts()) {
            $instructors = $this->course->get_course_contacts();

            foreach ($instructors as $instructor) {
                $user = $instructor['user'];
                $userutil = new user($user->id);

                $contacts[] = [
                    'id' => $user->id,
                    'fullname' => fullname($user),
                    'userpicture' => $userutil->get_user_picture(),
                    'role' => $instructor['role']->displayname
                ];
            }
        }

        return $contacts;
    }

    /**
     * Returns HTML to display course category name.
     *
     * @return string
     *
     * @throws \moodle_exception
     */
    public function get_category(): string {
        $cat = core_course_category::get($this->course->category, IGNORE_MISSING);

        if (!$cat) {
            return '';
        }

        return $cat->get_formatted_name();
    }

    /**
     * Returns course summary.
     *
     * @param coursecat_helper $chelper
     */
    public function get_summary(coursecat_helper $chelper): string {
        if ($this->course->has_summary()) {
            return $chelper->get_course_formatted_summary($this->course,
                ['overflowdiv' => true, 'noclean' => true, 'para' => false]
            );
        }

        return false;
    }

    /**
     * Returns course custom fields.
     *
     * @return string
     */
    public function get_custom_fields(): string {
        if ($this->course->has_custom_fields()) {
            $handler = \core_course\customfield\course_handler::create();

            return $handler->display_custom_fields_data($this->course->get_custom_fields());
        }

        return '';
    }

    /**
     * Returns HTML to display course enrolment icons.
     *
     * @return array
     */
    public function get_enrolment_icons(): array {
        if ($icons = enrol_get_course_info_icons($this->course)) {
            return $icons;
        }

        return [];
    }

    /**
     * Get the user progress in the course.
     *
     * @param null $userid
     *
     * @return mixed
     */
    public function get_progress($userid = null) {
        return \core_completion\progress::get_course_progress_percentage($this->course, $userid);
    }
}
