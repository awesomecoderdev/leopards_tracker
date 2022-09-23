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
 * @author     MD Ibrahim Kholil <awesomecoder.dev@gmail.com>
 */
class Leopards_tracker
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Leopards_tracker_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('LEOPARDS_TRACKER_VERSION')) {
			$this->version = LEOPARDS_TRACKER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'leopards_tracker';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Leopards_tracker_Loader. Orchestrates the hooks of the plugin.
	 * - Leopards_tracker_i18n. Defines internationalization functionality.
	 * - Leopards_tracker_Admin. Defines all hooks for the admin area.
	 * - Leopards_tracker_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-leopards_tracker-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-leopards_tracker-i18n.php';

		/**
		 * The class responsible for defining shortcode functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-leopards_tracker-shortcode.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-leopards_tracker-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-leopards_tracker-public.php';

		Asesomecoder_Leopards_Tracker_Shortcode::run();


		$this->loader = new Leopards_tracker_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Leopards_tracker_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Leopards_tracker_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Leopards_tracker_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		// Activate Admin Menu
		$this->loader->add_action('admin_menu', $plugin_admin, 'leopards_tracker_create_menu');

		// action hooks for ajax request
		$this->loader->add_action("wp_ajax_leopards_tracker_ajax_request", $this, 'handel_leopards_tracker_admin_ajax_requests');
		$this->loader->add_action("wp_ajax_nopriv_leopards_tracker_ajax_request", $this, 'handel_leopards_tracker_admin_ajax_requests');
	}


	public function handel_leopards_tracker_admin_ajax_requests()
	{
		if (isset($_REQUEST["trackid"]) && !empty($_REQUEST["trackid"])) {
			$trackid = $_REQUEST["trackid"];
			$url = "https://leopardscourier.com/pk/tracking/index.php";
			$response = wp_remote_request(
				$url,
				array(
					'method'      => 'POST',
					'timeout'     => 45,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking'    => true,
					'sslverify'   => false,
					'headers'     => array(),
					'body'        => array(
						"cn_number" => "$trackid",
					),
					'cookies'     => array()
				)
			);

			if (!is_wp_error($response)) {
				$html = wp_remote_retrieve_body($response);
				$dom = new DOMDocument();
				@$dom->loadHTML($html);
				$dom->preserveWhiteSpace = false;
				$dom->validateOnParse = true;
				$homeSearch = $dom->getElementById("homeSearch");
				$output = $dom->saveHTML($homeSearch);


				$output = str_replace('background="images/', 'background="https://leopardscourier.com/pk/tracking/images/', $output);
				$output = str_replace('url(images/', 'url(https://leopardscourier.com/pk/tracking/images/', $output);
				$output = str_replace('src="', 'src="https://leopardscourier.com/pk/tracking/', $output);
				echo $output;
			} else {
				echo '<table><tr><th colspan="2">No data available</th></tr></table>';
			}
		} else {
			echo '<table><tr><th colspan="2">No data available</th></tr></table>';
		}

		// end ajax
		wp_die();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Leopards_tracker_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		// action hooks for ajax request
		$this->loader->add_action("wp_ajax_leopards_tracker_ajax_request", $this, 'handel_leopards_tracker_admin_ajax_requests');
		$this->loader->add_action("wp_ajax_nopriv_leopards_tracker_ajax_request", $this, 'handel_leopards_tracker_admin_ajax_requests');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Leopards_tracker_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
