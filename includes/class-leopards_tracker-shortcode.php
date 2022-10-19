<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://awesomecoder.dev/
 * @since      1.0.0
 *
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/includes
 * @author     Mohammad Ibrahim <awesomecoder.dev@gmail.com>
 *                                                              _
 *                                                             | |
 *    __ ___      _____  ___  ___  _ __ ___   ___  ___ ___   __| | ___ _ __
 *   / _` \ \ /\ / / _ \/ __|/ _ \| '_ ` _ \ / _ \/ __/ _ \ / _` |/ _ \ '__|
 *  | (_| |\ V  V /  __/\__ \ (_) | | | | | |  __/ (_| (_) | (_| |  __/ |
 *   \__,_| \_/\_/ \___||___/\___/|_| |_| |_|\___|\___\___/ \__,_|\___|_|
 *
 */



class Asesomecoder_Leopards_Tracker_Shortcode
{

    /**
     *  It is the shortcode functions of the plugin
     *
     *  By useing this shortcode user can show options on their
     * 	website, anywhere they want
     *
     */


    public static function run()
    {
        function leopards_tracker_shortcode()
        {
            ob_start();
            include_once LEOPARDS_TRACKER_PLUGIN_PATH . 'public/partials/leopards_tracker-public-display.php';
            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        };

        add_shortcode('leopards_tracker', 'leopards_tracker_shortcode');
    }
}
