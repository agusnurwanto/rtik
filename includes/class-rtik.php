<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Rtik
 * @subpackage Rtik/includes
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
 * @package    Rtik
 * @subpackage Rtik/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Rtik {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rtik_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'RTIK_VERSION' ) ) {
			$this->version = RTIK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'rtik';

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
	 * - Rtik_Loader. Orchestrates the hooks of the plugin.
	 * - Rtik_i18n. Defines internationalization functionality.
	 * - Rtik_Admin. Defines all hooks for the admin area.
	 * - Rtik_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rtik-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rtik-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rtik-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rtik-public.php';

		$this->loader = new Rtik_Loader();

		// Functions tambahan
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-rtik-functions.php';

		$this->functions = new Rtik_Functions( $this->plugin_name, $this->version );

		$this->loader->add_action('template_redirect', $this->functions, 'allow_access_private_post', 0);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rtik_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Rtik_i18n();

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

		$plugin_admin = new Rtik_Admin( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('carbon_fields_register_fields', $plugin_admin, 'crb_attach_rtik_options');
		$this->loader->add_action('init', $plugin_admin, 'create_posttype_rtik');
		$this->loader->add_filter('kc_us_allowed_post_types_to_generate_short_links', $plugin_admin, 'disable_shortlink', 999, 1);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Rtik_Public( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action('wp_ajax_simpan_pelatihan',  $plugin_public, 'simpan_pelatihan');
		$this->loader->add_action('wp_ajax_simpan_peserta',  $plugin_public, 'simpan_peserta');

		$this->loader->add_action('wp_ajax_get_data_peserta',  $plugin_public, 'get_data_peserta');
		$this->loader->add_action('wp_ajax_nopriv_get_data_peserta',  $plugin_public, 'get_data_peserta');

		$this->loader->add_action('wp_ajax_cari_detail_peserta',  $plugin_public, 'cari_detail_peserta');
		$this->loader->add_action('wp_ajax_nopriv_cari_detail_peserta',  $plugin_public, 'cari_detail_peserta');

		$this->loader->add_action('wp_ajax_simpan_peserta_satuan',  $plugin_public, 'simpan_peserta_satuan');
		$this->loader->add_action('wp_ajax_nopriv_simpan_peserta_satuan',  $plugin_public, 'simpan_peserta_satuan');

		add_shortcode('input_data_pelatihan',  array($plugin_public, 'input_data_pelatihan'));
		add_shortcode('input_data_peserta',  array($plugin_public, 'input_data_peserta'));
		add_shortcode('input_anggota_rtik',  array($plugin_public, 'input_anggota_rtik'));
		add_shortcode('data_pelatihan',  array($plugin_public, 'data_pelatihan'));
		add_shortcode('daftar_pelatihan',  array($plugin_public, 'daftar_pelatihan'));
		add_shortcode('pendaftaran_peserta',  array($plugin_public, 'pendaftaran_peserta'));
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
	 * @return    Rtik_Loader    Orchestrates the hooks of the plugin.
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
