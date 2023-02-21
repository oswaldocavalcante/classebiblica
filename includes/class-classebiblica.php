<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/includes
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
 * @package    Classebiblica
 * @subpackage Classebiblica/includes
 * @author     Oswaldo Cavalcante <jocmail@gmail.com>
 */
class Classebiblica {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Classebiblica_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct() {
		if ( defined( 'CLASSEBIBLICA_VERSION' ) ) {
			$this->version = CLASSEBIBLICA_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'classebiblica';

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
	 * - Classebiblica_Loader. Orchestrates the hooks of the plugin.
	 * - Classebiblica_i18n. Defines internationalization functionality.
	 * - Classebiblica_Admin. Defines all hooks for the admin area.
	 * - Classebiblica_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-classebiblica-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-classebiblica-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-classebiblica-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-classebiblica-public.php';

		$this->loader = new Classebiblica_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Classebiblica_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Classebiblica_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Classebiblica_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//add admin menu items
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'my_admin_menu' );

		//register general settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'classebiblica_register_settings' );

		//create reading plan table in the database
		$this->loader->add_action( 'init', $plugin_admin, 'create_reading_plan_db' );

		//create a custom post type to hold content
		$this->loader->add_action( 'add_meta_boxes', 	$plugin_admin, 'cb_course_group_meta_box' );
		$this->loader->add_action( "tutor_save_course", $plugin_admin, 'cb_course_group_meta_save', 10, 2);

		//sending email to student after registration
		remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
		$this->loader->add_action( 'user_register', $plugin_admin, 'cb_email_student_registration', 10, 2);

		$this->loader->add_action( 'tutor_after_enrolled', $plugin_admin, 'cb_email_student_course_enroll', 10, 3);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
	
		$plugin_public = new Classebiblica_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//add shortcode
		$this->loader->add_shortcode( 'classebiblica', $plugin_public, 'classebiblica_shortcode' );

		//show a modal to an enrolled student at Tutor LMS about his Telegram Group
		$this->loader->add_action( 'tutor_after_enroll', $plugin_public, 'cb_group_modal', 10, 2 );

		//show a button to an enrolled student at Tutor LMS to his Telegram Group
		$this->loader->add_action( 'tutor_course/single/actions_btn_group/before', $plugin_public, 'cb_group_button');

		//add a button to dashboard
		$this->loader->add_action( 'tutor_dashboard/nav_items', $plugin_public, 'cb_add_dashboard_help');

		//redirect to pannel if user is logged in
		$this->loader->add_shortcode( 'cb_redirect_panel', $plugin_public, 'cb_redirecting_panel');

		//adds a bible reading plan
		$this->loader->add_shortcode( 'cb_bible_reading_plan', $plugin_public, 'cb_bible_reading_plan');

		//translate de slug courses to 'cursos'
		$this->loader->add_filter( 'register_post_type_args', $plugin_public, 'cb_course_register_post_type_args', 10, 2 );

		//enqueue css to donor dashboard of Give plugin
		$this->loader->add_action('wp_print_styles', $plugin_public, 'my_custom_override_iframe_template_styles', 10);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Classebiblica_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
