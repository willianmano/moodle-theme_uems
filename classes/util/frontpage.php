<?php

namespace theme_uems\util;

class frontpage {
    public function get_favourite() {
        global $DB;

        return $DB->get_records('course');
    }

    public function get_slides() {
        $theme = \theme_config::load('uems');

        $counter = (int) $theme->settings->slidercount;

        $data = [
            'slidercount' => $counter
        ];

        if (!$counter) {
            return $data;
        }

        for ($i = 1, $j = 0; $i <= $counter; $i++, $j++) {
            $sliderimage = 'sliderimage' . $i;
            $slidertext = 'slidertext' . $i;

            $data['slides'][] = [
                'key' => $j,
                'active' => $i == 1,
                'image' => $theme->setting_file_url($sliderimage, $sliderimage),
                'text' => format_text($slidertext)
            ];
        }

        return $data;
    }
}
