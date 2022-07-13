<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Rtik
 * @subpackage Rtik/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rtik
 * @subpackage Rtik/public
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Rtik_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rtik-public.css', array(), $this->version, 'all' );
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'css/datatables.min.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtik-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));

	}

	public function input_data_peserta(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-input-data-peserta.php';
	}

	public function input_data_pelatihan(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-input-data-pelatihan.php';
	}

	public function input_anggota_rtik(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-input-anggota.php';
	}

	public function data_pelatihan(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/data-pelatihan-detail.php';
	}

	public function simpan_pelatihan(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan data pelatihan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_rtik_apikey' )) {
				if(empty($_POST['judul'])){
					$ret['status'] = 'error';
					$ret['message'] = 'Judul tidak boleh kosong!';
					die(json_encode($ret));
				}elseif(empty($_POST['waktu'])){
					$ret['status'] = 'error';
					$ret['message'] = 'waktu tidak boleh kosong!';
					die(json_encode($ret));
				}
				$hari = explode('T', $_POST['waktu']);
				$_POST['waktu'] = $hari[0].' '.$hari[1];
				$judul = $_POST['judul'].' | '.$hari[0];
				$post_type = 'pelatihan';
				$options = array(
					'nama_page' => $judul,
					'content' => '[data_pelatihan]',
					'post_status' => 'publish',
					'post_type' => $post_type,
					'show_header' => 1,
					'no_key' => 1
				);
				if(empty($_POST['id_post'])){
					$get_title = get_page_by_title( $judul, OBJECT, $post_type );
					if ($get_title == false) {
						$link = $this->functions->generatePage($options);
						$post_id = $link['id'];
						$title = get_the_title($post_id);
					}else {
						$ret['status'] = 'error';
						$ret['message'] = 'Data sudah ada!';
						die(json_encode($ret));
					}
				}else{
					$title = get_the_title($post_id);
					$post_id = $_POST['id_post'];
					if($judul != $title){
						$options['post_id'] = $post_id;
						$this->functions->generatePage($options);
					}
				}

				if(!empty($post_id)){
					update_post_meta($post_id, '_meta_judul', $_POST['judul']);
					update_post_meta($post_id, '_meta_materi', $_POST['materi']);
					update_post_meta($post_id, '_meta_narasumber', $_POST['narasumber']);
					update_post_meta($post_id, '_meta_waktu', $_POST['waktu']);
					update_post_meta($post_id, '_meta_lokasi', $_POST['lokasi']);
					update_post_meta($post_id, '_meta_pamflet', $_POST['pamflet']);
					update_post_meta($post_id, '_meta_deskripsi', $_POST['deskripsi']);
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'ID post aset tidak ditemukan!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

	public function simpan_peserta(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan data peserta pelatihan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_rtik_apikey' )) {
				if(empty($_POST['id_pelatihan'])){
					$ret['status'] = 'error';
					$ret['message'] = 'ID pelatihan tidak boleh kosong!';
					die(json_encode($ret));
				}elseif(empty($_POST['data_excel'])){
					$ret['status'] = 'error';
					$ret['message'] = 'Data excel tidak boleh kosong!';
					die(json_encode($ret));
				}
				$peserta_all = json_decode(stripslashes($_POST['data_excel']));
				$id_pelatihan = $_POST['id_pelatihan'];
				foreach($peserta_all as $peserta){
					$judul = trim($peserta->email);
					$post_type = 'peserta_pelatihan';
					$pelatihan_existing = array();
					$get_title = get_page_by_title( $judul, OBJECT, $post_type );
					if ($get_title == false) {
						$options = array(
							'nama_page' => $judul,
							'content' => '[data_peserta_pelatihan]',
							'post_status' => 'publish',
							'post_type' => $post_type,
							'show_header' => 1,
							'no_key' => 1
						);
						$link = $this->functions->generatePage($options);
						$post_id = $link['id'];
					}else{
						$post_id = $get_title->ID;
					}
					$pelatihan_existing = $wpdb->get_results($wpdb->prepare('
						select 
							id 
						from rtik_peserta_pelatihan 
						where id_pelatihan=%d
							and id_peserta=%d',
						$id_pelatihan,
						$post_id,
					), ARRAY_A);
					$opsi = array(
						'id_pelatihan' => $id_pelatihan,
						'id_peserta' => $post_id
					);
					if(!empty($peserta->timestamp)){
						$waktu_daftar = date('Y-m-d H:i:s', strtotime($peserta->timestamp));
						$opsi['waktu_daftar'] = $waktu_daftar;
					}
					if(!empty($peserta->timestamp_daftar_ulang)){
						$waktu_daftar_ulang = date('Y-m-d H:i:s', strtotime($peserta->timestamp_daftar_ulang));
						$opsi['waktu_daftar_ulang'] = $waktu_daftar_ulang;
					}
					if(!empty($peserta->konfirmasi_hadir)){
						$opsi['konfirmasi_hadir'] = $peserta->konfirmasi_hadir;
					}
					if(!empty($peserta->lolos)){
						$opsi['lolos'] = $peserta->lolos;
					}
					if(!empty($peserta->harapan)){
						$opsi['harapan'] = $peserta->harapan;
					}
					if(!empty($peserta->saran)){
						$opsi['saran'] = $peserta->saran;
					}

					if(empty($pelatihan_existing)){
						$wpdb->insert('rtik_peserta_pelatihan', $opsi);
					}else{
						$wpdb->update('rtik_peserta_pelatihan', $opsi, array(
							'id' => $pelatihan_existing[0]['id']
						));
					}

					if(!empty($peserta->nama)){
						update_post_meta($post_id, '_meta_nama', $peserta->nama);
					}
					if(!empty($peserta->wa)){
						update_post_meta($post_id, '_meta_wa', $peserta->wa);
					}
					if(!empty($peserta->email)){
						update_post_meta($post_id, '_meta_email', $peserta->email);
					}
					if(!empty($peserta->alamat)){
						update_post_meta($post_id, '_meta_alamat', $peserta->alamat);
					}
					if(!empty($peserta->pekerjaan)){
						update_post_meta($post_id, '_meta_pekerjaan', $peserta->pekerjaan);
					}
					if(!empty($peserta->tangal_lahir)){
						update_post_meta($post_id, '_meta_tangal_lahir', $peserta->tangal_lahir);
					}
					if(!empty($peserta->pengalaman)){
						update_post_meta($post_id, '_meta_pengalaman', $peserta->pengalaman);
					}
					if(!empty($peserta->harapan)){
						update_post_meta($post_id, '_meta_harapan', $peserta->harapan);
					}
					if(!empty($peserta->usaha)){
						update_post_meta($post_id, '_meta_usaha', $peserta->usaha);
					}
					if(!empty($peserta->laptop)){
						update_post_meta($post_id, '_meta_laptop', $peserta->laptop);
					}
					if(!empty($peserta->saran)){
						update_post_meta($post_id, '_meta_saran', $peserta->saran);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

}
