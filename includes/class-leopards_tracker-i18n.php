<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://awesomecoder.dev/
 * @since      1.0.0
 *
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/includes
 * @author     Mohammad Ibrahim <awesomecoder.dev@gmail.com>
 */
class Leopards_tracker_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'leopards_tracker',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
