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

	public function daftar_pelatihan(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-daftar-pelatihan.php';
	}

	public function pendaftaran_peserta(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-pendaftaran-peserta.php';
	}

	public function daftar_instruktur(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once RTIK_PLUGIN_PATH . 'public/partials/rtik-daftar-instruktur.php';
	}

	public function get_data_peserta($cek_return){
		global $wpdb;
		$return = array(
			'status' => 'success',
			'results'	=> array(),
			'pagination'=> array(
			    "more" => false
			)
		);

		if(!empty($_POST)){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_rtik_apikey' )) {
				$args = array(
				    'posts_per_page' => 10,
				    'paged' => $_POST['page'],
				    'post_type' => 'peserta_pelatihan',
				    'post_status' => 'publish',
				);
				if(!empty($_POST['search'])){
				    $args['meta_query'] = array(
				        'relation'  => 'OR',
				        array(
				           'key' => '_meta_nama',
				           'value' => $_POST['search'],
				           'compare' => 'LIKE',
				        ),
				        array(
				           'key' => '_meta_alamat',
				           'value' => $_POST['search'],
				           'compare' => 'LIKE',
				        )
				   	);
				};

				$query = new WP_Query($args);
				$return['sql'] = $wpdb->last_query;

				foreach ($query->posts as $post) {
		    		$return['results'][] = array(
		    			'id' => $post->ID,
		    			'text' => get_post_meta($post->ID, '_meta_nama', true).' | '.get_post_meta($post->ID, '_meta_alamat', true)
		    		);
		    	}

				if(count($return['results']) > 0){
					$return['pagination']['more'] = true;
				}
			}else{
				$return['status'] = 'error';
				$return['message'] ='Api Key tidak sesuai!';
			}
		}else{
			$return['status'] = 'error';
			$return['message'] ='Format tidak sesuai!';
		}
		if($cek_return){
			return $return;
		}else{
			die(json_encode($return));
		}
	}

	public function cari_detail_peserta($cek_return){
		global $wpdb;
		$return = array(
			'status' => 'success',
			'data'	=> array()
		);

		if(!empty($_POST)){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_rtik_apikey' )) {
				if(empty($_POST['id_peserta'])){
					$return['status'] = 'error';
					$return['message'] ='ID peserta tidak boleh kosong!';
				}
				if(empty($_POST['email'])){
					$return['status'] = 'error';
					$return['message'] ='Email tidak boleh kosong!';
				}
				if($return['status'] != 'error'){
					$email_asli = get_post_meta($_POST['id_peserta'], '_meta_email', true);
					$return['data']['nama'] = get_post_meta($_POST['id_peserta'], '_meta_nama', true);
					$return['data']['alamat'] = get_post_meta($_POST['id_peserta'], '_meta_alamat', true);
					if($email_asli == $_POST['email']){
						$return['data']['id_peserta'] = $_POST['id_peserta'];
						$return['data']['wa'] = get_post_meta($_POST['id_peserta'], '_meta_wa', true);
						$return['data']['usaha'] = get_post_meta($_POST['id_peserta'], '_meta_usaha', true);
						$return['data']['website'] = get_post_meta($_POST['id_peserta'], '_meta_website', true);
						$return['data']['sosmed'] = get_post_meta($_POST['id_peserta'], '_meta_sosmed', true);
						$return['data']['marketplace'] = get_post_meta($_POST['id_peserta'], '_meta_marketplace', true);
						$return['data']['pekerjaan'] = get_post_meta($_POST['id_peserta'], '_meta_pekerjaan', true);
						$return['data']['tanggal_lahir'] = get_post_meta($_POST['id_peserta'], '_meta_tanggal_lahir', true);
						$return['data']['harapan'] = get_post_meta($_POST['id_peserta'], '_meta_harapan', true);
						$return['data']['saran'] = get_post_meta($_POST['id_peserta'], '_meta_saran', true);
						$return['data']['pengalaman'] = get_post_meta($_POST['id_peserta'], '_meta_pengalaman', true);
						$return['data']['laptop'] = get_post_meta($_POST['id_peserta'], '_meta_laptop', true);
						$return['data']['konfirmasi_hadir'] = get_post_meta($_POST['id_peserta'], '_meta_konfirmasi_hadir', true);
					}else{
						$return['status'] = 'error';
						$return['message'] ='Email tidak ditemukan untuk ID peserta ini ('.$return['data']['nama'].' | '.$return['data']['alamat'].')! Jika anda belum pernah mendaftar sebelumnya atau data belum ada di database, silahkan langsung mengisi form di bawah ini untuk mengisi data baru.';
					}
				}
			}else{
				$return['status'] = 'error';
				$return['message'] ='Api Key tidak sesuai!';
			}
		}else{
			$return['status'] = 'error';
			$return['message'] ='Format tidak sesuai!';
		}
		if($cek_return){
			return $return;
		}else{
			die(json_encode($return));
		}
	}

	public function get_pelatihan_aktif(){
		$args = array(
		    'posts_per_page' => -1,
		    'post_type' => 'pelatihan',
		    'post_status' => 'publish',
		    'meta_query' => array(
		        'relation'  => 'AND',
		        array(
		           'key' => '_meta_judul',
		           'value' => array(''),
		           'compare' => 'NOT IN',
		        ),
		        array(
		           'key' => '_meta_waktu',
		           'value' => date( 'Y-m-d H:i:s' ),
		           'compare' => '>=',
		        )
		   )
		);
		$query = new WP_Query($args);
		$data_pelatihan = array();
		foreach($query->posts as $post){
		    $data_pelatihan[$post->ID] = array(
		        'title' => get_the_title($post->ID),
		        'judul' => get_post_meta($post->ID, '_meta_judul', true),
		        'materi' => get_post_meta($post->ID, '_meta_materi', true),
		        'narasumber' => get_post_meta($post->ID, '_meta_narasumber', true),
		        'waktu' => get_post_meta($post->ID, '_meta_waktu', true),
		        'lokasi' => get_post_meta($post->ID, '_meta_lokasi', true),
		        'pamflet' => get_post_meta($post->ID, '_meta_pamflet', true),
		        'deskripsi' => get_post_meta($post->ID, '_meta_deskripsi', true)
		    );
		}
		return $data_pelatihan;
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
				$_POST['waktu'] = $hari[0].' '.$hari[1].':00';
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
					if(!empty($peserta->timestamp_daftar_ulang)){
						$waktu_daftar_ulang = date('Y-m-d H:i:s', strtotime($peserta->timestamp_daftar_ulang));
						$opsi['waktu_daftar_ulang'] = $waktu_daftar_ulang;
					}
					if(!empty($peserta->timestamp)){
						$waktu_daftar = date('Y-m-d H:i:s', strtotime($peserta->timestamp));
						$opsi['waktu_daftar'] = $waktu_daftar;
					}else{
						$waktu_daftar = date('Y-m-d H:i:s');
						if(!empty($opsi['waktu_daftar_ulang'])){
							$waktu_daftar = $opsi['waktu_daftar_ulang'];
						}
						$opsi['waktu_daftar'] = $waktu_daftar;
						if(empty($peserta->nama)){
							$peserta->nama = get_post_meta($post_id, '_meta_nama', true);
						}
						if(empty($peserta->wa)){
							$peserta->wa = get_post_meta($post_id, '_meta_wa', true);
						}
						if(empty($peserta->email)){
							$peserta->email = get_post_meta($post_id, '_meta_email', true);
						}
						if(empty($peserta->alamat)){
							$peserta->alamat = get_post_meta($post_id, '_meta_alamat', true);
						}
						if(empty($peserta->pekerjaan)){
							$peserta->pekerjaan = get_post_meta($post_id, '_meta_pekerjaan', true);
						}
						if(empty($peserta->tanggal_lahir)){
							$peserta->tanggal_lahir = get_post_meta($post_id, '_meta_tanggal_lahir', true);
						}
						if(empty($peserta->pengalaman)){
							$peserta->pengalaman = get_post_meta($post_id, '_meta_pengalaman', true);
						}
						if(empty($peserta->harapan)){
							$peserta->harapan = get_post_meta($post_id, '_meta_harapan', true);
						}
						if(empty($peserta->usaha)){
							$peserta->usaha = get_post_meta($post_id, '_meta_usaha', true);
						}
						if(empty($peserta->laptop)){
							$peserta->laptop = get_post_meta($post_id, '_meta_laptop', true);
						}
						if(empty($peserta->saran)){
							$peserta->saran = get_post_meta($post_id, '_meta_saran', true);
						}
						if(empty($peserta->website)){
							$peserta->website = get_post_meta($post_id, '_meta_website', true);
						}
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
					if(!empty($peserta->tanggal_lahir)){
						update_post_meta($post_id, '_meta_tanggal_lahir', $peserta->tanggal_lahir);
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
					if(!empty($peserta->website)){
						update_post_meta($post_id, '_meta_website', $peserta->website);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

	public function simpan_peserta_satuan(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan data peserta pelatihan!',
			'url_pelatihan' => ''
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( '_crb_rtik_apikey' )) {
				if(empty($_POST['id_pelatihan'])){
					$ret['status'] = 'error';
					$ret['message'] = 'ID pelatihan tidak boleh kosong!';
					die(json_encode($ret));
				}elseif(empty($_POST['email'])){
					$ret['status'] = 'error';
					$ret['message'] = 'Email tidak boleh kosong!';
					die(json_encode($ret));
				}
				$id_pelatihan = $_POST['id_pelatihan'];
				$judul = trim($_POST['email']);
				if(!empty($_POST['id_peserta'])){
					$post_id = $_POST['id_peserta'];
					wp_update_post(
					    array (
					        'ID' => $post_id,
					        'post_title' => $judul
					    )
					);
				}else{
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
						$ret['status'] = 'error';
						$ret['message'] = 'Email sudah dipakai oleh peserta lain!';
						die(json_encode($ret));
					}
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
				$waktu_daftar_ulang = date('Y-m-d H:i:s');
				$opsi['waktu_daftar_ulang'] = $waktu_daftar_ulang;
				$waktu_daftar = date('Y-m-d H:i:s');
				$opsi['waktu_daftar'] = $waktu_daftar;
				if(!empty($_POST['konfirmasi_hadir'])){
					$opsi['konfirmasi_hadir'] = $_POST['konfirmasi_hadir'];
				}
				if(!empty($_POST['lolos'])){
					$opsi['lolos'] = $_POST['lolos'];
				}
				if(!empty($_POST['harapan'])){
					$opsi['harapan'] = $_POST['harapan'];
				}
				if(!empty($_POST['saran'])){
					$opsi['saran'] = $_POST['saran'];
				}

				if(empty($pelatihan_existing)){
					$wpdb->insert('rtik_peserta_pelatihan', $opsi);
				}else{
					$wpdb->update('rtik_peserta_pelatihan', $opsi, array(
						'id' => $pelatihan_existing[0]['id']
					));
				}
				update_post_meta($post_id, '_meta_nama', $_POST['nama']);
				update_post_meta($post_id, '_meta_wa', $_POST['wa']);
				update_post_meta($post_id, '_meta_email', $_POST['email']);
				update_post_meta($post_id, '_meta_alamat', $_POST['alamat']);
				update_post_meta($post_id, '_meta_pekerjaan', $_POST['pekerjaan']);
				update_post_meta($post_id, '_meta_tanggal_lahir', $_POST['tanggal_lahir']);
				update_post_meta($post_id, '_meta_pengalaman', $_POST['pengalaman']);
				update_post_meta($post_id, '_meta_harapan', $_POST['harapan']);
				update_post_meta($post_id, '_meta_usaha', $_POST['usaha']);
				update_post_meta($post_id, '_meta_laptop', $_POST['laptop']);
				update_post_meta($post_id, '_meta_saran', $_POST['saran']);
				update_post_meta($post_id, '_meta_website', $_POST['website']);
				update_post_meta($post_id, '_meta_sosmed', $_POST['sosmed']);
				update_post_meta($post_id, '_meta_marketplace', $_POST['marketplace']);
				update_post_meta($post_id, '_meta_konfirmasi_hadir', $_POST['konfirmasi_hadir']);
				$ret['url_pelatihan'] = get_permalink($id_pelatihan);
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

}
