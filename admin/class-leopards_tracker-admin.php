<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://awesomecoder.dev/
 * @since      1.0.0
 *
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Leopards_tracker
 * @subpackage Leopards_tracker/admin
 * @author     MD Ibrahim Kholil <awesomecoder.dev@gmail.com>
 */
class Leopards_tracker_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Leopards_tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Leopards_tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/leopards_tracker-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Leopards_tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Leopards_tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/leopards_tracker-admin.js', array('jquery'), $this->version, false);


		// Some local vairable to get ajax url
		wp_localize_script($this->plugin_name, 'leopards_tracker', array(
			"name"	=> "awesomeCoder",
			"author" =>	"MD Ibrahim Kholil",
			"url" => get_bloginfo('url'),
			"ajaxurl"	=> admin_url("admin-ajax.php")
		));
	}



	/**
	 * Register the Dashboard Menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function leopards_tracker_create_menu()
	{

		/**
		 * This function is provided Dashboard Menu for the admin area.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ac_product_compare_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ac_product_compare_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// add menu on adminbar
		add_menu_page('Leopards Tracker', 'Leopards Tracker', 'manage_options', 'leopards_tracker',  array($this, 'leopards_tracker_activator_callback'), 'dashicons-filter', 50); //dashicons-podio
		// add submenu on adminbar
		add_submenu_page('leopards_tracker', 'Dashboard', 'Dashboard', 'manage_options', 'leopards_tracker',   array($this, 'leopards_tracker_dashboard_callback'));
	}

	// Admin Menu Activator CallBack Function
	public function leopards_tracker_activator_callback()
	{
		// Default function for activate admin menu
	}

	// Dashboard menu callback function
	public function leopards_tracker_dashboard_callback()
	{
		ob_start();
		include_once LEOPARDS_TRACKER_PLUGIN_PATH . 'admin/partials/leopards_tracker-admin-display.php';
		$dashboard = ob_get_contents();
		ob_end_clean();
		echo $dashboard;
	}


	public function handel_leopards_tracker_admin_ajax_requests()
	{

		echo json_encode(array(
			"success"		=> true,
			"data"		=> $_REQUEST,
		), JSON_PRETTY_PRINT);

		// end ajax
		wp_die();
	}
}
