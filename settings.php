<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettinguems', get_string('configtitle', 'theme_uems'));

    $page = new admin_settingpage('theme_uems_general', get_string('frontpagesettings', 'theme_uems'));

    $options = [];
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect(
        'theme_uems/slidercount',
        get_string('slidercount', 'theme_uems'),
        get_string('slidercountdesc', 'theme_uems'),
        0,
        $options
    );
    $page->add($setting);

    if ($slidercount = get_config('theme_uems', 'slidercount')) {
        for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
            $fileid = 'sliderimage' . $sliderindex;
            $name = 'theme_uems/sliderimage' . $sliderindex;
            $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
            $setting = new admin_setting_configstoredfile($name, get_string('sliderimage', 'theme_uems'), '', $fileid, 0, $opts);
            $page->add($setting);

            $name = 'theme_uems/slidertext' . $sliderindex;
            $setting = new admin_setting_confightmleditor($name, get_string('slidertext', 'theme_uems'), '', '');
            $page->add($setting);
        }
    }

    $settings->add($page);
}
