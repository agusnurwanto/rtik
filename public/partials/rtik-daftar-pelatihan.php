<?php
global $post;
global $wpdb;
$api_key = get_option('_crb_rtik_apikey');
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'pelatihan',
    'post_status' => 'publish',
    'meta_query' => array(
       array(
           'key' => 'meta_judul',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);

$daftar_pelatihan = '';
$query = new WP_Query($args);
$no = 0;
foreach($query->posts as $post){
    $no++;
    $link = get_permalink($post->ID);
    $daftar_pelatihan .= '
        <tr id_pelatihan="'.$post->ID.'">
            <td class="text-center">'.$no.'</td>
            <td>
                <a href="'.$link.'">'.get_post_meta($post->ID, '_meta_judul', true).'</a>
            </td>
            <td>'.get_post_meta($post->ID, '_meta_materi', true).'</td>
            <td>'.get_post_meta($post->ID, '_meta_waktu', true).'</td>
            <td>'.get_post_meta($post->ID, '_meta_narasumber', true).'</td>
            <td>'.get_post_meta($post->ID, '_meta_lokasi', true).'</td>
            <td>'.get_post_meta($post->ID, '_meta_deskripsi', true).'</td>
        </tr>';
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
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center">Daftar Pelatihan Relawan Teknologi Informasi dan Komunikasi (RTIK) Magetan</h2>
        <div style="padding: 10px; min-width: 900px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 45px;">No</th>
                        <th class="text-center" style="width: 145px;">Judul Pelatihan</th>
                        <th class="text-center">Materi</th>
                        <th class="text-center">Waktu</th>
                        <th class="text-center">Narasumber</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $daftar_pelatihan; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>