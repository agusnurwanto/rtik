<?php
global $post;
global $wpdb;
$api_key = get_option('_crb_rtik_apikey');
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'peserta_pelatihan',
    'post_status' => 'publish',
    'meta_query' => array(
       array(
           'key' => '_meta_nama',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);

$daftar_instruktur = '';
$query = new WP_Query($args);
$no = 0;
foreach($query->posts as $post){
    $no++;
    $link = get_permalink($post->ID);
    $daftar_instruktur .= '
        <div class="col-md-3 mx-auto">
            <div class="card" id_pelatihan="'.$post->ID.'" style="margin-bottom: 10px;">
                <div class="card-body">
                    <h5 class="card-title">'.get_post_meta($post->ID, '_meta_nama', true).'</h5>
                    <p class="card-text">'.get_post_meta($post->ID, '_meta_usaha', true).'</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">'.get_post_meta($post->ID, '_meta_website', true).'</li>
                    <li class="list-group-item">'.get_post_meta($post->ID, '_meta_alamat', true).'</li>
                </ul>
                <div class="card-body">
                    <a href="'.get_permalink($post->ID).'" class="card-link">Detail</a>
                </div>
            </div>
        </div>
        ';
}
?>
<style type="text/css">
    .warning {
        background: #f1a4a4;
    }
    .hide, nav.post-navigation, header.entry-header {
        display: none;
    }
    td {
        word-break: break-word;
    }
    .list-group {
        margin: 0;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;" class="text-center">
        <h2>Daftar Peserta Pelatihan</h2>
        <div class="row">
        <?php echo $daftar_instruktur; ?>
        </div>
    </div>
</div>