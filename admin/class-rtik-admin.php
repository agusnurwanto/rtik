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
		$data_pelatihan = $this->functions->generatePage(array(
			'nama_page' => 'Daftar Pelatihan',
			'content' => '[daftar_pelatihan]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
		$pendaftaran_peserta = $this->functions->generatePage(array(
			'nama_page' => 'Pendaftaran Peserta Pelatihan',
			'content' => '[pendaftaran_peserta]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));
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
	            Field::make( 'text', 'crb_rtik_apikey', 'APIKEY RTIK' )
	            	->set_default_value($this->functions->generateRandomString()),
	        	Field::make( 'html', 'crb_rtik_link' )
	            	->set_html( '
	            	<h2><b>HALAMAN SISTEM RTIK</b></h2>
	            	<ul>
						<li><b>Input data pelatihan: <a target="_blank" href="'.$input_data_pelatihan['url'].'">'.$input_data_pelatihan['title'].'</a></b></li>
						<li><b>Input peserta pelatihan: <a target="_blank" href="'.$input_data_peserta['url'].'">'.$input_data_peserta['title'].'</a></b></li>
						<li><b>Input data anggota RTIK: <a target="_blank" href="'.$input_anggota_rtik['url'].'">'.$input_anggota_rtik['title'].'</a></b></li>
						<li><b>Daftar Pelatihan: <a target="_blank" href="'.$data_pelatihan['url'].'">'.$data_pelatihan['title'].'</a></b></li>
						<li><b>Pendaftaran peserta pelatihan: <a target="_blank" href="'.$pendaftaran_peserta['url'].'">'.$pendaftaran_peserta['title'].'</a></b></li>
	            	</ul>
            	' )
            ) );

	    Container::make( 'post_meta', __( 'Detail Pelatihan' ) )
		    ->where( 'post_type', '=', 'pelatihan' )
	        ->add_fields( array(
	            Field::make( 'text', 'meta_judul', 'Judul Pelatihan' ),
	            Field::make( 'text', 'meta_materi', 'Judul Materi' ),
	            Field::make( 'text', 'meta_narasumber', 'Narasumber' ),
	            Field::make( 'date_time', 'meta_waktu', 'Waktu Pelaksanaan' ),
	            Field::make( 'text', 'meta_lokasi', 'Lokasi' ),
	            Field::make( 'rich_text', 'meta_pamflet', 'Pamflet / Poster' ),
	            Field::make( 'rich_text', 'meta_deskripsi', 'Deskripsi' )
	            	->set_help_text('Deskripsi pelatihan atau keterangan tambahan.')
	        ) );

	    Container::make( 'post_meta', __( 'Detail Peserta' ) )
		    ->where( 'post_type', '=', 'peserta_pelatihan' )
	        ->add_fields( array(
	            Field::make( 'text', 'meta_nama', 'Nama Peserta' ),
	            Field::make( 'text', 'meta_wa', 'Nomor WA' ),
	            Field::make( 'text', 'meta_email', 'Email' ),
	            Field::make( 'text', 'meta_usaha', 'Usaha' ),
	            Field::make( 'textarea', 'meta_alamat', 'Alamat' ),
	            Field::make( 'textarea', 'meta_harapan', 'Harapan' ),
	            Field::make( 'textarea', 'meta_saran', 'Kritik / Saran' ),
	            Field::make( 'text', 'meta_pekerjaan', 'Pekerjaan' ),
	            Field::make( 'date', 'meta_tangal_lahir', 'Tanggal Lahir' ),
	            Field::make( 'text', 'meta_pengalaman', 'Pengalaman' ),
	            Field::make( 'text', 'meta_laptop', 'Punya Laptop' )
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

	function disable_shortlink($post_types){
		$allowed_post_types = array(
			'post',
			'page',
			'product', // https://wordpress.org/plugins/woocommerce
			'download', // https://wordpress.org/plugins/easy-digital-downloads
			'event', // https://wordpress.org/plugins/events-manager/
			'tribe_events', // https://wordpress.org/plugins/the-events-calendar/
			'docs', // https://wordpress.org/plugins/betterdocs/
			'kbe_knowledgebase', // https://wordpress.org/plugins/wp-knowledgebase/
			'mec-events', // https://wordpress.org/plugins/modern-events-calendar-lite/
			'kruchprodukte', // https://wordpress.org/support/topic/custom-posts-type-2/
		);
		// return $allowed_post_types;
		return array();
	}

}
