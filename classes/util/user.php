<?php

namespace theme_uems\util;

use stdClass;
use user_picture;
class user {
    /**
     * @var \stdClass $user The user object.
     */
    protected $user;

    /**
     * Class constructor
     *
     * @param stdClass $user
     *
     */
    public function __construct($user = null) {
        global $USER, $DB;

        if (!is_object($user)) {
            $user = $DB->get_record('user', ['id' => $user], '*', MUST_EXIST);
        }

        if (!$user) {
            $user = $USER;
        }

        $this->user = $user;
    }

    /**
     * Returns the user picture
     *
     * @param int $imgsize
     *
     * @return string
     * @throws \coding_exception
     */
    public function get_user_picture($imgsize = 100) {
        global $PAGE;

        $userimg = new user_picture($this->user);

        $userimg->size = $imgsize;

        return $userimg->get_url($PAGE)->out();
    }
}