<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Rtik
 * @subpackage Rtik/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rtik
 * @subpackage Rtik/admin
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Rtik_Admin {

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

	private $functions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rtik_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rtik_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rtik-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rtik_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rtik_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtik-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function crb_attach_rtik_options() {
		$input_data_peserta = $this->functions->generatePage(array(
			'nama_page' => 'Input data peserta pelatihan',
			'content' => '[input_data_peserta]',
        	'show_header' => 1,
			'post_status' => 'private'
		));
		$input_data_pelatihan = $this->functions->generatePage(array(
			'nama_page' => 'Input data pelatihan',
			'content' => '[input_data_pelatihan]',
        	'show_header' => 1,
			'post_status' => 'private'
		));
		$input_anggota_rtik = $this->functions->generatePage(array(
			'nama_page' => 'Input anggota RTIK',
			'content' => '[input_anggota_rtik]',
        	'show_header' => 1,
			'post_status' => 'private'
		));
		$basic_options_container = Container::make( 'theme_options', __( 'RTIK' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
	        	Field::make( 'html', 'crb_rtik_link' )
	            	->set_html( '
	            	<h2><b>HALAMAN SISTEM RTIK</b></h2>
	            	<ul>
						<li><b>Input data pelatihan: <a target="_blank" href="'.$input_data_pelatihan['url'].'">'.$input_data_pelatihan['title'].'</a></b></li>
						<li><b>Input peserta pelatihan: <a target="_blank" href="'.$input_data_peserta['url'].'">'.$input_data_peserta['title'].'</a></b></li>
						<li><b>Input data anggota RTIK: <a target="_blank" href="'.$input_anggota_rtik['url'].'">'.$input_anggota_rtik['title'].'</a></b></li>
	            	</ul>
            	' )
            ) );

	}

	public function create_posttype_rtik(){
	    register_post_type( 'pelatihan',
	        array(
	            'labels' => array(
	                'name' => __( 'Data Pelatihan' ),
	                'singular_name' => __( 'Data Pelatihan' )
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'rewrite' => array('slug' => 'pelatihan'),
	            'show_in_rest' => true,
	            'show_in_menu' => true,
	            'menu_position' => 5
	        )
	    );
	    register_post_type( 'peserta_pelatihan',
	        array(
	            'labels' => array(
	                'name' => __( 'Peserta Pelatihan' ),
	                'singular_name' => __( 'Peserta Pelatihan' )
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'rewrite' => array('slug' => 'peserta_pelatihan'),
	            'show_in_rest' => true,
	            'show_in_menu' => true,
	            'menu_position' => 5
	        )
	    );
	    register_post_type( 'anggota_rtik',
	        array(
	            'labels' => array(
	                'name' => __( 'Anggota RTIK' ),
	                'singular_name' => __( 'Anggota RTIK' )
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'rewrite' => array('slug' => 'anggota_rtik'),
	            'show_in_rest' => true,
	            'show_in_menu' => true,
	            'menu_position' => 5
	        )
	    );
	}

}
